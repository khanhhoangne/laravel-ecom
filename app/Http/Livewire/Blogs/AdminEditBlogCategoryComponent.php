<?php

namespace App\Http\Livewire\Blogs;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminEditBlogCategoryComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $name;
    public $slug;
    public $banner;
    public $status;

    public $newBanner;
    public $parent_id;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên danh mục',
        'slug' => 'Liên kết tĩnh'
    ];

    public function setRules() {
        return [
            'name' => 'required',
            'slug' => 'required|unique:tbl_blogs_categories,slug,' . $this->category_id,
        ];
    }

    public function mount($category_slug) {
        $category = BlogCategory::where('slug', $category_slug)->first();

        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->banner = $category->banner;
        $this->status = $category->status;
    }

    public function generateslug() {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateCategory() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $category = BlogCategory::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->status = $this->status;

        if ($this->newBanner) {
            $imageName = $this->slug . Carbon::now()->timestamp . '.' . $this->newBanner->extension();
            $this->newBanner->storeAs('public/uploads/blogcategories', $imageName);

            $category->banner = $imageName;
        }

        $category->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật danh mục thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('blogcategories');
    }

    public function render()
    {
        $pageTitle = 'Cập nhật danh mục bài viết';

		$categories = BlogCategory::where('parent_id', NULL)->get();

        return view('livewire.blogs.admin-edit-blog-category-component',[
			'categories' => $categories
		])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
