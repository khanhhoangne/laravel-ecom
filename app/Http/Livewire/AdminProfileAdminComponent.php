<?php

namespace App\Http\Livewire;

use App\UseCases\Administrator\AdministratorUseCase;
use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Validator;
use Livewire\WithFileUploads;

class AdminProfileAdminComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $username;
    public $email;
    public $phone;
    public $job_title;
    public $address;
    public $profile_photo_path;
    public $admin_id;
    
    public $old_password;
    public $password;
    public $new_password;
    public $renew_password;

    private $commandUseCase;
    private $permissionUseCase;
    private $roleUseCase;
    private $adminUseCase;

    public $show = false;
    public $nameRole;
    public $slug;
    protected $commands;
    protected $permissions;
    public $arrCommandId = [];
    public $roleIds = [];
    public $roles;

    public $newImage;
    public $active_tab = 0;

    protected $rules = [];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.',
        'email' => ':attribute không đúng định dạng email. Vui lòng nhập lại.',
        'min:6' => ':attribute tối thiểu 6 ký tự'
    ];

    protected $validationAttributes = [
        'name' => 'Tên quản trị viên',
        'username' => 'Username',
        'email' => 'Email',
        'phone' => 'Số điện thoại',
        'job_title' => 'Vị trí công việc',
    ];

    protected $validationAttributesPass = [
        'password' => 'Mật khẩu hiện tại',
        'new_password' => 'Mật khẩu mới',
        'renew_password' => 'Nhập lại mật khẩu mới',
    ];

    public function setRulesPass() {
        return [
            'password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'renew_password' => 'required_with:new_password|same:new_password|min:6',
        ];
    }

    public function setRules() {
        return [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'job_title' => 'required',
            'username' => 'required|unique:users,username,'.$this->admin_id,
        ];
    }

    public function boot(
        AdministratorUseCase $adminUseCase,
        CommandUseCase $commandUseCase,
        PermissionUseCase $permissionUseCase,
        RoleUseCase $roleUseCase,
    ) {
        $this->adminUseCase = $adminUseCase;
        $this->user = Config::get('user');

        $this->roleUseCase = $roleUseCase;
        $this->commandUseCase = $commandUseCase;
        $this->permissionUseCase = $permissionUseCase;

        $this->roles = $this->roleUseCase->getAll();
    }  

    public function mount() {
        $admin = $this->adminUseCase->find($this->user->id);
        foreach ($admin->userHasRoles as $userItem) {
            $userItem->role;
        }

        foreach ($admin->userHasRoles as $userItem) {
            array_push($this->roleIds, strval($userItem->role_id));
        }

        $this->admin_id = $this->user->id;
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->job_title = $this->user->job_title;
        $this->address = $this->user->address1;
        $this->profile_photo_path = $this->user->profile_photo_path;
        $this->old_password = $this->user->password;
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updateAdmin() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $admin = [
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'job_title' => $this->job_title,
            'address1' => $this->address,
        ];

        if (!empty($this->newImage)) {
            $imageName = $admin['username'] . Carbon::now()->timestamp . '.' .$this->newImage->extension();
            $this->newImage->storeAs('public/uploads/users', $imageName);
            $admin['profile_photo_path'] = $imageName;
        }

        $this->adminUseCase->update($this->admin_id, $admin);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật quản trị viên thành công!',
            'text' => ''
        ]);

        return redirect(route('profile'));
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

    public function updatePassword() {
        $this->rules = $this->setRulesPass();
        $this->validate($this->rules, $this->messages, $this->validationAttributesPass);

        $this->verifyPassword();

        $pass = [
            'password' => Hash::make($this->new_password),
        ];

        $this->adminUseCase->update($this->admin_id, $pass);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật mật khẩu thành công!',
            'text' => ''
        ]);

        return redirect(route('profile'));
    }

    public function verifyPassword() {
        if (!Hash::check($this->password, $this->old_password)) {
            $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                    $validator->errors()->add('password', 'Nhập sai mật khẩu. vui lòng nhập lại');
                });
            })->validate(); 
        }
    }

    public function updateTab($index) {
        $this->active_tab = $index;
    }

    public function removeAvatar() {
        $this->newImage = null;
    }

    public function render()
    {
        $pageTitle = 'Thông tin cá nhân';

        return view('livewire.admin-profile-admin-component', [
            'user' => $this->user,
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
