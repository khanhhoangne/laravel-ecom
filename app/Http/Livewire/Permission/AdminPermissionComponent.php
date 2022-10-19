<?php

namespace App\Http\Livewire\Permission;

use App\UseCases\Permission\PermissionUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminPermissionComponent extends Component
{
    protected $listeners = ['delete' => 'deletePermission'];
    private $permissionUseCase;
    public $permissions;

    public function boot(
        PermissionUseCase $permissionUseCase,
    ) {
        $this->permissionUseCase = $permissionUseCase;
        $this->permissions = $this->permissionUseCase->getAll();
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deletePermission($id) {
        $this->permissionUseCase->delete($id);

        $this->permissions = $this->permissionUseCase->getAll();
    }

    public function render()
    {
        $pageTitle = 'Danh sách quyền hạn';

        return view('livewire.permission.admin-permission-component', [
            'permissions' => $this->permissions,
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
