<?php

namespace App\Http\Livewire\Administrators;

use App\UseCases\Administrator\AdministratorUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminAdministratorComponent extends Component
{
    protected $listeners = ['delete' => 'deleteAdmin'];
    private $adminUseCase;
    protected $admins;
    public $limit=6;
    public $page;

    public function boot(
        AdministratorUseCase $adminUseCase,
    ) {
        $this->adminUseCase = $adminUseCase;

        $limit = [
            'limit' => $this->limit,
            'page' => $this->page
        ];

        $conditions['limit'] = $limit;

        $this->admins = $this->adminUseCase->getAndPaginate($conditions);
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteAdmin($id) {
        $this->adminUseCase->delete($id);

        $this->admins = $this->adminUseCase->getAndPaginate();
    }

    public function render()
    { 
        $pageTitle = 'Danh sách quản trị viên';
        return view('livewire.administrators.admin-administrator-component', [
            'admins' => $this->admins,
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
