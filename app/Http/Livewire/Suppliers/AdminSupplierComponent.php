<?php

namespace App\Http\Livewire\Suppliers;

use App\Models\ProductSupplier;
use Illuminate\Support\Facades\Config;
use Livewire\WithPagination;
use Livewire\Component;

class AdminSupplierComponent extends Component
{
    // use WithPagination;

    protected $listeners = ['delete' => 'deleteSupplier'];

    public function render() {
        $pageTitle = 'Nhà cung ứng sản phẩm';
        $suppliers = ProductSupplier::orderBy('created_at', 'desc')->paginate(8);

        return view('livewire.suppliers.admin-supplier-component', [
            'suppliers' => $suppliers
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

    public function deleteSupplier($id) {
        $category = ProductSupplier::find($id);
        $category->delete();
    }
}
