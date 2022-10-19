<?php

namespace App\Http\Livewire\Grants;

use App\UseCases\Administrator\AdministratorUseCase;
use App\UseCases\Command\CommandUseCase;
use App\UseCases\GrantPermission\GrantPermissionUseCase;
use App\UseCases\Permission\PermissionUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminEditGrantPermissionComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $user_id;
    public $permission_id;
    public $command_id;
    public $description;
    public $expired_date;

    public $grant_id;

    protected $commands;
    protected $permissions;
    protected $admins;

    private $grantPermissionUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    private $adminUseCase;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'date' => ':attribute không đúng định dạng ngày. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'user_id' => 'Quản trị viên',
        'command_id' => 'Module quản lý',
        'expired_date' => 'Ngày hết hạn',
        'permission_id' => 'Quyền hạn'
    ];

    public function setRules() {
        return [
            'user_id' => 'required',
            'permission_id' => 'required',
            'command_id' => 'required',
            'expired_date' => 'required|date',
        ];
    }

    public function boot(
        GrantPermissionUseCase $grantPermissionUseCase,
        AdministratorUseCase $adminUseCase,
        CommandUseCase $commandUseCase,
        PermissionUseCase $permissionUseCase,
    ) {
        $this->grantPermissionUseCase = $grantPermissionUseCase;
        $this->commandUseCase = $commandUseCase;
        $this->permissionUseCase = $permissionUseCase;
        $this->adminUseCase = $adminUseCase;

        $this->commands = $this->commandUseCase->getAll();
        $this->permissions = $this->permissionUseCase->getAll();
        $this->admins = $this->adminUseCase->getAll();
    }  

    public function mount($grant_id) {
        $grant = $this->grantPermissionUseCase->find($grant_id);

        $this->grant_id = $grant->id;
        $this->user_id = $grant->user_id;
        $this->command_id = $grant->command_id;
        $this->permission_id = $grant->permission_id;
        $this->description = $grant->description;
        $this->expired_date = $grant->expired_date;
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateGrantPermission() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $grant = [
            'user_id' => intval($this->user_id),
            'command_id' => intval($this->command_id),
            'permission_id' => intval($this->permission_id),
            'expired_date' => $this->expired_date,
            'description' => $this->description ? $this->description : null,
        ];

        $this->grantPermissionUseCase->update($this->grant_id, $grant);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật danh mục thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('grant-permissions');
    }

    public function render()
    {
        $pageTitle = 'Cập nhật cấp quyền';
        
        return view('livewire.grants.admin-edit-grant-permission-component', [
            'admins' => $this->admins,     
            'commands' => $this->commands,
            'permissions' => $this->permissions
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
