<?php

namespace App\Http\Livewire\Grants;

use App\UseCases\GrantPermission\GrantPermissionUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminGrantPermissionComponent extends Component
{
    protected $listeners = ['delete' => 'deleteGrantPermission'];
    private $grantPermissionUseCase;
    protected $grantPermissions;

    public function boot(
        GrantPermissionUseCase $grantPermissionUseCase,
    ) {
        $this->grantPermissionUseCase = $grantPermissionUseCase;
        $this->grantPermissions = $this->grantPermissionUseCase->getAndPaginate();
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteGrantPermission($id) {
        $this->grantPermissionUseCase->delete($id);

        $this->grantPermissions = $this->grantPermissionUseCase->getAndPaginate();
    }

    public function render()
    {
        $pageTitle = 'Danh sách cấp quyền';
        
        return view('livewire.grants.admin-grant-permission-component', [
            'grantPermissions' => $this->grantPermissions,
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
