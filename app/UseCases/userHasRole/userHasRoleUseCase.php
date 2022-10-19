<?php

namespace App\UseCases\UserHasRole;

use App\UseCases\UseCaseInterface;
use App\Repositories\UserHasRole\UserHasRoleRepositoryInterface;

class UserHasRoleUseCase implements UseCaseInterface {

    protected $userHasRoleRepo;

    public function __construct(UserHasRoleRepositoryInterface $userHasRoleRepo)
    {
        $this->userHasRoleRepo = $userHasRoleRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->userHasRoleRepo->getAll();
    }

    public function find($id) {
        return $this->userHasRoleRepo->find($id);
    }

    public function create($attributes = []) {
       return $this->userHasRoleRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->userHasRoleRepo->update($id, $attributes);
    }

    public function delete($conditions = []) {
        if (!empty($conditions)) {
            $this->userHasRoleRepo->removeByCondition($conditions);
        }
    }
}