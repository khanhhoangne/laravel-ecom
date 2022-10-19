<?php

namespace App\Http\Livewire\Blogs;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogDetail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AdminAddBlogComponent extends Component
{
	use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $title;
    public $slug;
    public $subtitle;
    public $thumbnail;
    public $content;
    public $status;

    public $category_id;

    protected $rules = [
        'title' => 'required',
        'slug' => 'required|unique:tbl_blogs',
		'subtitle' => 'required',
		'thumbnail' => 'required',
		'content' => 'required',
		'status' => 'required'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'title' => 'Tiêu đề bài viết',
        'slug' => 'Liên kết tĩnh',
		'subtitle' => 'Tiêu đề phụ',
		'thumbnail' => 'Ảnh tiêu đề',
		'content' => 'Nội dung',
		'status' => 'Trạng thái'
    ];

    public function generateslug() {
        $this->slug = Str::slug($this->title);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

	public function storeBlog() {  
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $blog = new Blog();
		
        $blog->title = $this->title;
        $blog->slug = $this->slug;
		$blog->subtitle = $this->subtitle;
		$blog->content = $this->content;
		$blog->status = $this->status;

        if (!empty($this->thumbnail)) {
            $thumbnailName = $this->slug . Carbon::now()->timestamp . '.' . $this->thumbnail->extension();
            $this->thumbnail->storeAs('public/uploads/blogs', $thumbnailName);

            $blog->thumbnail = $thumbnailName;
        }
        
        $blog->save();

		$blogDetail = new BlogDetail();

		$blogDetail->blog_id = $blog->id;
		$blogDetail->cate_id = $this->category_id;

		$blogDetail->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm bài viết thành công!',
            'text' => ''
        ]);

        $blog = $this->reset();
    }

    public function redirectToListView() {
        return redirect()->route('blogs');
    }

    public function render()
    {
		$pageTitle = 'Thêm mới bài viết';

		$categories = BlogCategory::where('status', 1)->get();

        return view('livewire.blogs.admin-add-blog-component',[
            'categories' => $categories,
        ])->layout('layouts.base', [
			'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
		]);
    }
}
