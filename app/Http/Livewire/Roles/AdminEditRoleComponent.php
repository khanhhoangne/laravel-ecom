<?php

namespace App\Http\Livewire\Roles;

use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use App\UseCases\RoleHasPermission\RoleHasPermissionUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Livewire\Component;

class AdminEditRoleComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $name;
    public $slug;
    protected $commands;
    protected $permissions;
    public $arrCommandId = [];
    public $arrOldCommandId = [];
    public $arrPermissionId = [];
    public $arrOldPermissionId = [];
    public $role_id;

    private $roleUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    private $roleHasPermissionUseCase;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên vai trò',
        'slug' => 'Liên kết tĩnh'
    ];

    public function setRules() {
        return [
            'name' => 'required',
            'slug' => 'required|unique:acl_roles,slug,' . $this->role_id,
        ];
    }

    public function boot(
        RoleUseCase $roleUseCase,
        CommandUseCase $commandUseCase,
        PermissionUseCase $permissionUseCase,
        RoleHasPermissionUseCase $roleHasPermissionUseCase,
    ) {
        $this->roleUseCase = $roleUseCase;
        $this->commandUseCase = $commandUseCase;
        $this->permissionUseCase = $permissionUseCase;
        $this->roleHasPermissionUseCase = $roleHasPermissionUseCase;

        $this->commands = $this->commandUseCase->getAll();
        $this->permissions = $this->permissionUseCase->getAll();
    }  

    public function mount($role_slug) {
        $role = $this->roleUseCase->getRoleBySlug($role_slug);
        
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->slug = $role->slug;

        // handle data
        $arrComands = [];
        foreach ($role->roleHasPermission as $command) {
            if (empty($arrComands[$command->command->id])) {
                $arrComands[$command->command->id] = $command->command->name;
            }
        }
        $this->arrCommandId = $arrComands;
        $this->arrOldCommandId = $arrComands;

        $arrPermission = [];
        foreach ($role->roleHasPermission as $command) {
            if (empty($arrPermission[$command->command->id])) {
                $arrPermission[$command->command->id] = [];
            }
            array_push($arrPermission[$command->command->id], [
                "role_per_com_id" => $command->id,
                "permission_id" =>  $command->permission->id
            ]);
        }
        $this->arrPermissionId = $arrPermission;
        $this->arrOldPermissionId = $arrPermission;
    }

    public function generateslug() {
        $this->slug = Str::slug($this->name);
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateRole() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $checkDiffCommandAdd = array_diff($this->arrCommandId, $this->arrOldCommandId);
        $checkDiffCommandDelete = array_diff($this->arrOldCommandId, $this->arrCommandId);
        // handle delete command
        if (!empty($checkDiffCommandDelete)) {
            $arrCommandId = [];
            foreach ($checkDiffCommandDelete as $key => $value) {
                array_push($arrCommandId, $key);
            }
            $this->roleUseCase->deleteCommandAndPermissions($this->role_id, $arrCommandId);
        }
        // handle add command and permissions
        if (!empty($checkDiffCommandAdd)) {
            foreach ($checkDiffCommandAdd as $key => $value) {
                $this->roleUseCase->addPermission($this->role_id, $key, $this->arrPermissionId[$key]);
            }
        }
        // handle update command and permissions
        foreach ($this->arrPermissionId as $key => $value) {
            foreach($checkDiffCommandAdd as $k => $add) {
                if ($k === $key) {
                    unset($this->arrPermissionId[$key]);
                    unset($this->arrOldPermissionId[$key]);
                }
            }

            foreach($checkDiffCommandDelete as $d => $del) {
                if ($d === $key) {
                    unset($this->arrPermissionId[$key]);
                    unset($this->arrOldPermissionId[$key]);
                }
            }
        }

        $arrRolePerComIds = [];
        $arrOldRolePerComIds = [];
        foreach ($this->arrPermissionId as $com) {
            foreach ($com as $rolePerCom) {
                if ($rolePerCom['role_per_com_id'] !== null) {
                    array_push($arrRolePerComIds, $rolePerCom['role_per_com_id']);
                }
            }
        }
        foreach ($this->arrOldPermissionId as $com) {
            foreach ($com as $rolePerCom) {
                array_push($arrOldRolePerComIds, $rolePerCom['role_per_com_id']);
            }
        }
        $checkDiffPermissionDelete = array_diff($arrOldRolePerComIds, $arrRolePerComIds);
        
        foreach ($checkDiffPermissionDelete as $rolePerComId) {
            $this->roleHasPermissionUseCase->delete($rolePerComId);
        }

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'permission' => $this->arrPermissionId
        ];

        $this->roleUseCase->update($this->role_id, $data);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật vai trò thành công!',
            'text' => ''
        ]);
    }

    public function handlePrintPermission($command, $checked) {
        if ($checked) {
            $this->arrCommandId[$command['id']] = $command['name'];
        } else {
            if (array_key_exists($command['id'], $this->arrCommandId)) {
                unset($this->arrCommandId[$command['id']]);
            }
            if (array_key_exists($command['id'], $this->arrPermissionId)) {
                unset($this->arrPermissionId[$command['id']]);
            }
        }
    }   

    public function handlePermission($permission_id, $command_id, $checked) {
        if ($checked) {
            if (empty($this->arrPermissionId[$command_id])) {
                $this->arrPermissionId[$command_id] = [];
            }
            array_push($this->arrPermissionId[$command_id], [
                "role_per_com_id" => null,
                "permission_id" => $permission_id
            ]);
            return;
        }
        $key = $this->checkPermission($permission_id, $this->arrPermissionId[$command_id]);
        unset($this->arrPermissionId[$command_id][$key]);
    }

    protected function checkPermission($permission_id, $arr) {
        $check = false;
        foreach ($arr as $key => $item) {
            if ($item['permission_id'] === $permission_id) {
                $check = $key;
            }
        }
        return $check;
    }

    public function redirectToListView() {
        return redirect()->route('roles');
    }

    public function render()
    {
        $pageTitle = 'Cập nhật vai trò';

        return view('livewire.roles.admin-edit-role-component', [
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
