<?php

namespace App\UseCases\Administrator;

use App\Models\User;
use App\UseCases\UseCaseInterface;
use App\Repositories\Administrator\AdministratorRepositoryInterface;

class AdministratorUseCase implements UseCaseInterface {

    protected $administratorRepo;

    public function __construct(
        AdministratorRepositoryInterface $administratorRepo
    )
    {
        $this->administratorRepo = $administratorRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->administratorRepo->getAll();
    }

    public function getAndPaginate($query = []) {
        $fieldAllows = [];
        $limit = [
            'page' => 1,
            'limit' => 10,
        ];
        $orderBy = [
            'created_at' => 'desc'
        ];
        $conditions = [];
        if (!empty($query['limit'])) {
            $limit = $query['limit'];
        }
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }
        $userQuery = User::select('name', 'username', 'id', 'profile_photo_path', 
        'email', 'job_title');
        $this->administratorRepo->handleConditions($conditions, $fieldAllows, $userQuery);
        $this->administratorRepo->handleOrderBy($orderBy, $fieldAllows, $userQuery);

        $users = $userQuery->paginate($limit['limit'], "*", "_page", $limit['page']);

        if (!empty($users->toArray())) {
            foreach ($users as $user) {
                foreach ($user->userHasRoles as $userItem) {
                    $userItem->role;
                }
            } 
        }

        return $users;
    }

    public function find($id) {
        return $this->administratorRepo->find($id);
    }

    public function create($attributes = []) {
        return $this->administratorRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->administratorRepo->update($id, $attributes);
    }

    public function delete($id) {
        return $this->administratorRepo->delete($id);
    }
}