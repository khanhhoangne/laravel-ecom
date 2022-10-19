<?php

namespace App\Http\Livewire\Roles;

use App\UseCases\Command\CommandUseCase;
use App\UseCases\Permission\PermissionUseCase;
use App\UseCases\Role\RoleUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminRoleComponent extends Component
{
    protected $listeners = ['delete' => 'deleteRole'];
    protected $roles;
    protected $roleHasCommands;
    public $limit=6;
    public $page;
    public $show = false;
    public $roleDetail;
    protected $commands;
    protected $permissions;
    public $name;
    public $slug;
    public $arrCommandId = [];

    private $roleUseCase;
    private $commandUseCase;
    private $permissionUseCase;
    
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

        $limit = [
            'limit' => $this->limit,
            'page' => $this->page
        ];

        $conditions['limit'] = $limit;

        $this->roles = $this->roleUseCase->getAndPaginate($conditions);
        
        foreach ($this->roles as $role) {
            $roleHasCommands[$role->name] = [];
            foreach ($role->roleHasPermission as $item) {
                if (empty($roleHasCommands[$role->name][$item->command->name])) {
                    $roleHasCommands[$role->name][$item->command->name] = $item->command->name;
                }
            }
        }

        $this->roleHasCommands = $roleHasCommands;
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteRole($id) {
        $this->roleUseCase->delete($id);

        $this->roles = $this->roleUseCase->getAndPaginate();
    }

    public function handlePaginate($page, $take) {
        $this->page = $page;
        $this->take = $take;
    }

    public function getRoleDetailById($id) {
        $role = $this->roleUseCase->getRoleById($id);
        
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
        $pageTitle = 'Danh sách vai trò';
        return view('livewire.roles.admin-role-component', [
            'roles' => $this->roles,
            'roleHasCommands' => $this->roleHasCommands,
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
