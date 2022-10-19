<?php

namespace App\UseCases\Permission;

use App\UseCases\UseCaseInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;

class PermissionUseCase implements UseCaseInterface {

    protected $permissionRepo;

    public function __construct(PermissionRepositoryInterface $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->permissionRepo->getAll();
    }

    public function find($id) {
        return $this->permissionRepo->find($id);
    }

    public function create($attributes = []) {
       return $this->permissionRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->permissionRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->permissionRepo->delete($id);
    }
    
    public function getPermission($conditions = []) {
        return $this->permissionRepo->findOne($conditions);
    }
}