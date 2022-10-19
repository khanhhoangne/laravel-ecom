<?php

namespace App\Http\Livewire\Categories;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Config;
use Livewire\WithPagination;
use Livewire\Component;

class AdminCategoryComponent extends Component
{
    // use WithPagination;

    protected $listeners = ['delete' => 'deleteCategory'];
    
    public function render() {
        $pageTitle = 'Danh mục sản phẩm';
        $categories = ProductCategory::orderBy('created_at', 'desc')->paginate(8);

        foreach ($categories as $category) {
            $category->children;
        }

        return view('livewire.categories.admin-category-component', [
            'categories' => $categories
        ])->layout('layouts.base', [
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
        $category = ProductCategory::find($id);
        $category->delete();
    }
}
