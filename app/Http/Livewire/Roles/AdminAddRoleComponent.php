<?php

namespace App\Http\Livewire\Roles;

use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminAddRoleComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];
    
    public $name;
    public $slug;
    protected $commands;
    protected $permissions;
    public $arrCommandId = [];
    public $arrPermissionId = [];

    private $roleUseCase;
    private $commandUseCase;
    private $permissionUseCase;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:acl_roles'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên vai trò',
        'slug' => 'Liên kết tĩnh'
    ];

    public function boot(
        RoleUseCase $roleUseCase,
        CommandUseCase $commandUseCase,
        PermissionUseCase $permissionUseCase,
    ) {
        $this->roleUseCase = $roleUseCase;
        $this->commandUseCase = $commandUseCase;
        $this->permissionUseCase = $permissionUseCase;

        $this->commands = $this->commandUseCase->getAll();
        $this->permissions = $this->permissionUseCase->getAll();
    }  

    public function generateslug() {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeRole() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'permission' => $this->arrPermissionId
        ];

        $this->roleUseCase->create($data);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm quyền hạn thành công!',
            'text' => ''
        ]);
    }

    public function handlePrintPermission($command, $checked) {
        if ($checked) {
            $this->arrCommandId[$command['id']] = $command['name'];
            return;
        }
        if (array_key_exists($command['id'], $this->arrCommandId)) {
            unset($this->arrCommandId[$command['id']]);
        }
        if (array_key_exists($command['id'], $this->arrPermissionId)) {
            unset($this->arrPermissionId[$command['id']]);
        }
    }   

    public function handlePermission($permission_id, $command_id, $checked) {
        if ($checked) {
            if (empty($this->arrPermissionId[$command_id])) {
                $this->arrPermissionId[$command_id] = [];
            }
            array_push($this->arrPermissionId[$command_id], $permission_id);
            return;
        }
        $key = array_search($permission_id, $this->arrPermissionId[$command_id]);
        unset($this->arrPermissionId[$command_id][$key]);
    }

    public function redirectToListView() {
        return redirect()->route('roles');
    }

    public function render()
    {
        $pageTitle = 'Thêm mới vai trò';
        return view('livewire.roles.admin-add-role-component', [
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
