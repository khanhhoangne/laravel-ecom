<?php

namespace App\UseCases\RoleHasPermission;

use App\UseCases\UseCaseInterface;
use App\Repositories\RoleHasPermission\RoleHasPermissionRepositoryInterface;

class RoleHasPermissionUseCase implements UseCaseInterface {

    protected $roleHasPermissionRepo;

    public function __construct(RoleHasPermissionRepositoryInterface $roleHasPermissionRepo)
    {
        $this->roleHasPermissionRepo = $roleHasPermissionRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->roleHasPermissionRepo->getAll();
    }

    public function find($id) {
        return $this->roleHasPermissionRepo->find($id);
    }

    public function create($attributes = []) {
       return $this->roleHasPermissionRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->roleHasPermissionRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->roleHasPermissionRepo->delete($id);
    }

    public function getPermission($conditions = []) {
        return $this->roleHasPermissionRepo->findOne($conditions);
    }
}