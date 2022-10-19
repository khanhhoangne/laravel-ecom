<?php

namespace App\Http\Livewire\Categories;

use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminEditCategoryComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $category_name;
    public $category_slug;
    public $image;
    public $status;
    public $description;

    public $newImage;
    public $category_id;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'category_name' => 'Tên danh mục',
        'category_slug' => 'Liên kết tĩnh'
    ];

    public function setRules() {
        return [
            'category_name' => 'required',
            'category_slug' => 'required|unique:shop_categories,category_slug,' . $this->category_id,
        ];
    }

    public function mount($cate_slug) {
        $category = ProductCategory::where('category_slug', $cate_slug)->first();

        $this->category_id = $category->id;
        $this->category_name = $category->category_name;
        $this->category_slug = $category->category_slug;
        $this->image = $category->image;
        $this->status = $category->status;
        $this->description = $category->description;
    }

    public function generateslug() {
        $this->category_slug = Str::slug($this->category_name);
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateCategory() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $category = ProductCategory::find($this->category_id);
        $category->category_name = $this->category_name;
        $category->category_slug = $this->category_slug;
        $category->status = $this->status;
        $category->description = $this->description;

        if ($this->newImage) {
            $imageName = $this->category_slug.Carbon::now()->timestamp. '.' .$this->newImage->extension();
            $this->newImage->storeAs('public/uploads/categories', $imageName);

            $category->image = $imageName;
        }

        $category->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật danh mục thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('categories');
    }

    public function render() {
        $pageTitle = 'Cập nhật danh mục sản phẩm';

        return view('livewire.categories.admin-edit-category-component')->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
