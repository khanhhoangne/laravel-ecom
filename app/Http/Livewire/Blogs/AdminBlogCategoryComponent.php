<?php

namespace App\Http\Livewire\Blogs;

use App\Models\BlogCategory;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminBlogCategoryComponent extends Component
{

    protected $listeners = ['delete' => 'deleteCategory'];

	public $getParentName = '\app\Http\Livewire\Blogs\AdminBlogCategoryComponent::getParentName';

    public function render()
    {
        $pageTitle = 'Danh mục bài viết';
        $blogCategories = BlogCategory::orderBy('created_at', 'DESC')->paginate(8);

        return view('livewire.blogs.admin-blog-category-component',[
            'blogCategories' => $blogCategories
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

	public static function getParentName($id) {
		$category = BlogCategory::find($id);

		return $category->name;
	}
}
