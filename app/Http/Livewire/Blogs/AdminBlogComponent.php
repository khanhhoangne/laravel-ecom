<?php

namespace App\Http\Livewire\Blogs;

use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class AdminBlogComponent extends Component
{
    // use WithPagination;

    protected $listeners = ['delete' => 'deleteCategory'];

    public function render()
    {
        $pageTitle = 'Bài viết';
        $blogs = Blog::orderBy('created_at', 'DESC')->paginate(8);

        foreach ($blogs as $blog) {
            foreach ($blog->blogDetails as $detail) {
                $detail->blogCategory;
            }
        }

        return view('livewire.blogs.admin-blog-component',[
            'blogs' => $blogs
        ])->layout('layouts.base',[
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteCategory($id) {
        $category = BlogCategory::find($id);
        $category->delete();
    }
}
