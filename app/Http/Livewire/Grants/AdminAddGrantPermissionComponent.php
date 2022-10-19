<?php

namespace App\Http\Livewire\Grants;

use App\UseCases\Administrator\AdministratorUseCase;
use App\UseCases\Command\CommandUseCase;
use App\UseCases\GrantPermission\GrantPermissionUseCase;
use App\UseCases\Permission\PermissionUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Validator;
use Livewire\Component;

class AdminAddGrantPermissionComponent extends Component
{
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $user_id;
    public $permission_id;
    public $command_id;
    public $description;
    public $expired_date;

    public $grantIds = [];
    public $grantTemp;

    protected $commands;
    protected $permissions;
    protected $admins;

    private $grantPermissionUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    private $adminUseCase;

    protected $rules = [
        'user_id' => 'required',
        'command_id' => 'required',
        'expired_date' => 'required|date',
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'date' => ':attribute không đúng định dạng ngày. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'user_id' => 'Quản trị viên',
        'command_id' => 'Module quản lý',
        'expired_date' => 'Ngày hết hạn',
    ];

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

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storeGrantPermission() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);
        $this->validateGrandIds();

        foreach($this->grantIds as $grantId) {
            $grant = [
                'user_id' => intval($this->user_id),
                'command_id' => intval($this->command_id),
                'permission_id' => intval($grantId),
                'expired_date' => $this->expired_date,
                'description' => $this->description ? $this->description : null,
            ];
    
            $this->grantPermissionUseCase->create($grant);
        }


        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cấp quyền thành công!',
            'text' => ''
        ]);
    }

    protected function validateGrandIds() {
        if (empty($this->grantIds)) {
            $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                    $validator->errors()->add('grantIds', 'Vui lòng chọn ít nhất 1 quyền hạn');
                });
            })->validate();
        }
    }

    public function addPermission($permission_id) {
        if (!in_array($permission_id, $this->grantIds)) {
            array_push($this->grantIds, $permission_id);
        }
        $this->grantTemp = null;
    }

    public function removePermission($permission_id) {
        if (in_array($permission_id, $this->grantIds)) {
            $key = array_search(strval($permission_id), $this->grantIds, true);
            if ($key !== false) {
                unset($this->grantIds[$key]);
            }
        }
    }

    public function redirectToListView() {
        return redirect()->route('grant-permissions');
    }

    public function render()
    {
        $pageTitle = 'Tạo cấp quyền';

        return view('livewire.grants.admin-add-grant-permission-component', [
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
