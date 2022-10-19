<?php

namespace App\UseCases\Role;

use App\Models\Role;
use App\UseCases\UseCaseInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\RoleHasPermission\RoleHasPermissionRepositoryInterface;

class RoleUseCase implements UseCaseInterface {

    protected $roleRepo;
    protected $roleHasPermissionRepo;

    public function __construct(
        RoleRepositoryInterface $roleRepo,
        RoleHasPermissionRepositoryInterface $roleHasPermissionRepo
    )
    {
        $this->roleRepo = $roleRepo;
        $this->roleHasPermissionRepo = $roleHasPermissionRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->roleRepo->getAll();
    }

    public function getAndPaginate($query = []) {
        $fieldAllows = [];
        $limit = [
            'page' => 1,
            'limit' => 10,
        ];
        $conditions = [];
        if (!empty($query['limit'])) {
            $limit = $query['limit'];
        }
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }
        $roleQuery = Role::select('name', 'slug', 'id');
        $this->roleRepo->handleConditions($conditions, $fieldAllows, $roleQuery);

        $roles = $roleQuery->paginate($limit['limit'], "*", "_page", $limit['page']);

        if (!empty($roles->toArray())) {
            foreach ($roles as $role) {
                foreach ($role->roleHasPermission as $roleItem) {
                    $roleItem->role;
                    $roleItem->command;
                }
            } 
        }

        return $roles;
    }

    public function find($id) {
        return $this->roleRepo->find($id);
    }

    public function create($data = []) {
        $roleData = [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];
        $createRole = $this->roleRepo->create($roleData);
        foreach ($data['permission'] as $command_id => $arrPermission) {
            foreach ($arrPermission as $permission_id) {
                $roleHasPermissionData = [
                    'permission_id' => $permission_id,
                    'role_id' => $createRole->id,
                    'command_id' => $command_id,
                ];
                $this->roleHasPermissionRepo->create($roleHasPermissionData);
            }
        }
    }

    public function addPermission($role_id, $command_id, $arrPermission = []) {
        if (!empty($arrPermission)) {
            foreach ($arrPermission as $permission) {
                $roleHasPermissionData = [
                    'permission_id' => $permission['permission_id'],
                    'role_id' => $role_id,
                    'command_id' => $command_id,
                ];
                $this->roleHasPermissionRepo->create($roleHasPermissionData);
            }
        }
    }

    public function update($id, $data = []) {
        $roleData = [
            'name' => $data['name'],
            'slug' => $data['slug'],
        ];
        $this->roleRepo->update($id, $roleData);
        foreach ($data['permission'] as $command_id => $arrPermission) {
            foreach ($arrPermission as $permission) {
                $roleHasPermissionData = [
                    'permission_id' => $permission['permission_id'],
                    'role_id' => $id,
                    'command_id' => $command_id,
                ];
                if (!empty($permission['role_per_com_id'])) {
                    $this->roleHasPermissionRepo->update($permission['role_per_com_id'], $roleHasPermissionData);
                } else {
                    $this->roleHasPermissionRepo->create($roleHasPermissionData);
                }
            }
        }    
    }

    public function getRoleBySlug($slug) {
        $role = Role::where('slug', $slug)->get();
        $role = $role[0];
        foreach ($role->roleHasPermission as $roleItem) {
            $roleItem->command;
            $roleItem->permission;
        }
        
        return $role;
    } 

    public function getRoleById($id) {
        $role = Role::where('id', $id)->get();
        $role = $role[0];
        foreach ($role->roleHasPermission as $roleItem) {
            $roleItem->command;
            $roleItem->permission;
        }
        
        return $role;
    } 

    public function delete($id) {
        $this->roleHasPermissionRepo->removeByCondition([
            "role_id" => $id,
        ]);
        return $this->roleRepo->delete($id);
    }

    public function deleteCommandAndPermissions($role_id, $arrCommandId = []) {
        if (!empty($arrCommandId)) {
            foreach ($arrCommandId as $key => $command_id) {
                $this->roleHasPermissionRepo->removeByCondition([
                    "role_id" => $role_id,
                    "command_id" => $command_id
                ]);
            }
        }
    }
}