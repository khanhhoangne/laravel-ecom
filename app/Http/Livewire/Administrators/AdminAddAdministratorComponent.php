<?php

namespace App\Http\Livewire\Administrators;

use App\UseCases\Administrator\AdministratorUseCase;
use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use App\UseCases\UserHasRole\UserHasRoleUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Livewire\Component;

class AdminAddAdministratorComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $name;
    public $password;
    public $username;
    public $email;
    public $job_title;
    public $manager_id;
    public $phone;
    public $status = 1;
    public $users;
    public $roleTemp;

    public $nameRole;
    public $slug;
    public $show = false;
    protected $commands;
    protected $permissions;
    public $arrCommandId = [];

    public $roleIds = [];
    public $roles;

    private $adminUseCase;
    private $roleUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    private $userHasRoleUseCase;

    protected $rules = [
        'name' => 'required',
        'password' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'phone' => 'required|unique:users',
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.',
        'email' => ':attribute không đúng định dạng. Vui lòng nhập lại.',
        'phone' => ':attribute kkhông được để trống.'
    ];
 
    protected $validationAttributes = [
        'name' => 'Tên quản trị viên',
        'password' => 'Mật khẩu',
        'username' => 'Username',
        'email' => 'Địa chỉ email',
        'phone' => 'Số điện thoại'
    ];

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

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeAdmin() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        $this->validateRoleIds();

        $admin = [
            'name' => $this->name,
            'password' => Hash::make($this->password),
            'username' => $this->username,
            'email' => $this->email,
            'job_title' => $this->job_title ? $this->job_title : null,
            'phone' => $this->phone,
            'status' => intval($this->status) === 1 ? 'active' : 'inactive',
            'manager_id' => $this->manager_id ? intval($this->manager_id) : null,
        ];

        $newAdmin = $this->adminUseCase->create($admin);
        foreach ($this->roleIds as $roleId) {
            $userHasRoleData = [
                'role_id' => $roleId,
                'user_id' => $newAdmin->id,
            ];
            $this->userHasRoleUseCase->create($userHasRoleData);
        }

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm quản trị viên thành công!',
            'text' => ''
        ]);
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

    public function render()
    {
        $pageTitle = 'Thêm mới quản trị viên';

        return view('livewire.administrators.admin-add-administrator-component', [
            'commands' => $this->commands,
            'permissions' => $this->permissions
        ])->layout('layouts.base',[
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
