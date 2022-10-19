<?php
namespace App\Repositories\UserHasRole;

use App\Repositories\BaseRepository;

class UserHasRoleRepository extends BaseRepository implements UserHasRoleRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\UserHasRole::class;
    }
}
