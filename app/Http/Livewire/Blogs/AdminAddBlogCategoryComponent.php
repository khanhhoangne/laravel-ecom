<?php

namespace App\Http\Livewire\Blogs;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminAddBlogCategoryComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $name;
    public $slug;
    public $banner;
    public $status;

    public $parent_id;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:tbl_blogs_categories'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên danh mục',
        'slug' => 'Liên kết tĩnh'
    ];

    public function generateslug() {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeCategory() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $category = new BlogCategory();
        $category->name = $this->name;
        $category->slug = $this->slug;
		$category->parent_id = $this->parent_id;
        $category->status = $this->status;

        if (!empty($this->banner)) {
            $bannerName = $this->slug . Carbon::now()->timestamp . '.' . $this->banner->extension();
            $this->banner->storeAs('public/uploads/blogcategories', $bannerName);

            $category->banner = $bannerName;
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
        return redirect()->route('blogcategories');
    }

    public function render() {
        $pageTitle = 'Thêm mới danh mục bài viết';


		$categories = BlogCategory::where('parent_id', NULL)->get();

        return view('livewire.blogs.admin-add-blog-category-component', [
			'categories' => $categories
		])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
