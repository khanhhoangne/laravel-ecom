<?php

namespace App\Http\Livewire\Categories;

use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminAddCategoryComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $category_name;
    public $category_slug;
    public $image;
    public $status;
    public $description;

    public $category_id;

    protected $rules = [
        'category_name' => 'required',
        'category_slug' => 'required|unique:shop_categories'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'category_name' => 'Tên danh mục',
        'category_slug' => 'Liên kết tĩnh'
    ];

    public function generateslug() {
        $this->category_slug = Str::slug($this->category_name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeCategory() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $category = new ProductCategory();
        $category->category_name = $this->category_name;
        $category->category_slug = $this->category_slug;
        $category->status = $this->status;
        $category->description = $this->description;

        // process value of position field
        $maxCurrentPosition = ProductCategory::max('position');
        $category->position = $maxCurrentPosition + 1;

        if (!empty($this->image)) {
            $imageName = $this->category_slug . Carbon::now()->timestamp . '.' . $this->image->extension();
            $this->image->storeAs('public/uploads/categories', $imageName);

            $category->image = $imageName;
        }
        
        $category->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm danh mục thành công!',
            'text' => ''
        ]);

        $category = $this->reset();
    }

    public function redirectToListView() {
        return redirect()->route('categories');
    }

    public function render() {
        $pageTitle = 'Thêm mới Danh mục sản phẩm';

        return view('livewire.categories.admin-add-category-component')->layout('layouts.base',[
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
