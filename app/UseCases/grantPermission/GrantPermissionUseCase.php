<?php

namespace App\UseCases\GrantPermission;

use App\Models\GrantPermission;
use App\UseCases\UseCaseInterface;
use App\Repositories\GrantPermission\GrantPermissionRepositoryInterface;

class GrantPermissionUseCase implements UseCaseInterface {

    protected $grantPermissionRepo;

    public function __construct(GrantPermissionRepositoryInterface $grantPermissionRepo)
    {
        $this->grantPermissionRepo = $grantPermissionRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->grantPermissionRepo->getAll();
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
        $grantPermissionQuery = GrantPermission::select('user_id', 'permission_id', 
        'command_id', 'expired_date', 'description', 'id');
        $this->grantPermissionRepo->handleConditions($conditions, $fieldAllows, $grantPermissionQuery);

        $grantPermission = $grantPermissionQuery->paginate($limit['limit'], "*", "_page", $limit['page']);

        if (!empty($grantPermission->toArray())) {
            foreach ($grantPermission as $grantItem) {
                $grantItem->permission;
                $grantItem->command;
                $grantItem->user;
            } 
        }
        return $grantPermission;
    }

    public function find($id) {
        return $this->grantPermissionRepo->find($id);
    }

    public function create($attributes = []) {
       return $this->grantPermissionRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->grantPermissionRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->grantPermissionRepo->delete($id);
    }
}