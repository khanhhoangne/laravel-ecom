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

class AdminEditBlogComponent extends Component
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
	public $newThumbnail;

	public $blogId;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'title' => 'Tiêu đề bài viết',
        'slug' => 'Liên kết tĩnh',
		'subtitle' => 'Tiêu đề phụ',
		'newThumbnail' => 'Ảnh tiêu đề',
		'content' => 'Nội dung',
		'status' => 'Trạng thái'
    ];

	public function setRules() {
        return [
            'title' => 'required',
            'slug' => 'required|unique:tbl_blogs,slug,' . $this->blogId,
			'subtitle' => 'required',
			'newThumbnail' => 'required',
			'content' => 'required',
			'status' => 'required'
        ];
    }

	public function mount($blog_slug) {
        $blog = Blog::where('slug', $blog_slug)->first();

        $this->blogId = $blog->id;
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->subtitle = $blog->subtitle;
		$this->thumbnail = $blog->thumbnail;
		$this->content = $blog->content;
        $this->status = $blog->status;
    }

    public function generateslug() {
        $this->slug = Str::slug($this->title);
    }

    public function updated($fields) {
		$this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

	public function updateBlog() {
		$this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        
        $blog = Blog::find($this->blogId);
		
        $blog->title = $this->title;
        $blog->slug = $this->slug;
		$blog->subtitle = $this->subtitle;
		$blog->content = $this->content;
		$blog->status = $this->status;

		if ($this->newThumbnail) {
            $imageName = $this->slug . Carbon::now()->timestamp . '.' . $this->newThumbnail->extension();
            $this->newThumbnail->storeAs('public/uploads/blogs', $imageName);

            $blog->thumbnail = $imageName;
        }
        
        $blog->save();

		$blogDetail = BlogDetail::where('blog_id', $blog->id);
		$blogDetail->cate_id = $this->category_id;
		$blogDetail->save();

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật bài viết thành công!',
            'text' => ''
        ]);

        $blog = $this->reset();
    }

    public function redirectToListView() {
        return redirect()->route('blogs');
    }

	public function render() {
		$pageTitle = 'Cập nhật bài viết';

		$categories = BlogCategory::where('status', 1)->get();

        return view('livewire.blogs.admin-edit-blog-component',[
            'categories' => $categories,
        ])->layout('layouts.base', [
			'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
		]);
    }
}
