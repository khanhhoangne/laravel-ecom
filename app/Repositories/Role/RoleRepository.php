<?php
namespace App\Repositories\Role;

use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Role::class;
    }
}