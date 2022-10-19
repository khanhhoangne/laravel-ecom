<?php

namespace App\Http\Livewire\Administrators;

use App\UseCases\Administrator\AdministratorUseCase;
use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use App\UseCases\UserHasRole\UserHasRoleUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;
use Livewire\Component;

class AdminEditAdministratorComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $admin_id;
    public $name;
    public $username;
    public $job_title;
    public $manager_id;
    public $status;
    public $users;
    public $roleTemp;

    public $nameRole;
    public $slug;
    public $show = false;
    protected $commands;
    protected $permissions;
    public $arrCommandId = [];

    public $roleIds = [];
    public $roleOldIds = [];
    public $roles;

    private $adminUseCase;
    private $roleUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    private $userHasRoleUseCase;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.',
        'email' => ':attribute không đúng định dạng email. Vui lòng nhập lại.',
        'phone' => ':attribute không đúng định dạng số điện thoại.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên quản trị viên',
        'username' => 'Username',
    ];

    public function setRules() {
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$this->admin_id,
        ];
    }

    public function boot(
        AdministratorUseCase $adminUseCase,
        RoleUseCase $roleUseCase,
        CommandUseCase $commandUseCase,
        PermissionUseCase $permissionUseCase,
        UserHasRoleUseCase $userHasRoleUseCase,
    ) {
        $this->adminUseCase = $adminUseCase;
        $this->roleUseCase = $roleUseCase;
        $this->commandUseCase = $commandUseCase;
        $this->permissionUseCase = $permissionUseCase;
        $this->userHasRoleUseCase = $userHasRoleUseCase;

        $this->users = $this->adminUseCase->getAll();
        $this->roles = $this->roleUseCase->getAll();
    }  

    public function mount($id) {
        $admin = $this->adminUseCase->find($id);
        foreach ($admin->userHasRoles as $userItem) {
            $userItem->role;
        }

        foreach ($admin->userHasRoles as $userItem) {
            array_push($this->roleIds, strval($userItem->role_id));
            array_push($this->roleOldIds, strval($userItem->role_id));
        }

        $this->admin_id = $admin->id;
        $this->name = $admin->name;
        $this->username = $admin->username;
        $this->job_title = $admin->job_title;
        $this->manager_id = $admin->manager_id;
        $this->status = $admin->status === 'active' ? 1 : 0;
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateAdmin() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        $this->validateRoleIds();

        $checkDiffRoleAdd = array_diff($this->roleIds, $this->roleOldIds);
        $checkDiffRoleDelete = array_diff($this->roleOldIds, $this->roleIds);
        // handle delete Role
        if (!empty($checkDiffRoleDelete)) {
            foreach ($checkDiffRoleDelete as $key => $value) {
                $this->userHasRoleUseCase->delete([
                    'role_id' => intval($value), 
                    'user_id' => intval($this->admin_id)
                ]);
            }
        }
        // handle add Role
        if (!empty($checkDiffRoleAdd)) {
            foreach ($checkDiffRoleAdd as $key => $value) {
                $this->userHasRoleUseCase->create([
                    'role_id' => intval($value), 
                    'user_id' => intval($this->admin_id)
                ]);
            }
        }

        $admin = [
            'name' => $this->name,
            'username' => $this->username,
            'job_title' => $this->job_title,
            'manager_id' => $this->manager_id,
            'status' => $this->status === "1" ? "active" : "inactive",
        ];

        $this->adminUseCase->update($this->admin_id, $admin);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật quản trị viên thành công!',
            'text' => ''
        ]);
    }

    public function addRole($role_id) {
        if (!in_array($role_id, $this->roleIds)) {
            array_push($this->roleIds, $role_id);
        }
        $this->roleTemp = null;
    }

    public function removeRole($role_id) {
        if (in_array($role_id, $this->roleIds)) {
            $key = array_search(strval($role_id), $this->roleIds, true);
            if ($key !== false) {
                unset($this->roleIds[$key]);
            }
        }
    }

    public function getRoleDetailById($id) {
        $this->commands = $this->commandUseCase->getAll();
        $this->permissions = $this->permissionUseCase->getAll();

        $role = $this->roleUseCase->getRoleById($id);
        
        $this->nameRole = $role->name;
        $this->slug = $role->slug;

        // handle data
        $arrComands = [];
        foreach ($role->roleHasPermission as $command) {
            if (empty($arrComands[$command->command->id])) {
                $arrComands[$command->command->id] = $command->command->name;
            }
        }
        $this->arrCommandId = $arrComands;

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

        $this->show = true;
    }

    public function closeModal() {
        $this->show = false;
    }

    protected function validateRoleIds() {
        if (empty($this->roleIds)) {
            $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                    $validator->errors()->add('roleIds', 'Vui lòng chọn ít nhất 1 vai trò');
                });
            })->validate();
        }
    }

    public function redirectToListView() {
        return redirect()->route('administrators');
    }

    public function render()
    {
        $pageTitle = 'Cập nhật quản trị viên';

        return view('livewire.administrators.admin-edit-administrator-component', [
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
