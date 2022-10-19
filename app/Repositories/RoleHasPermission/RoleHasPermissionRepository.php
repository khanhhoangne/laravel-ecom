<?php
namespace App\Repositories\RoleHasPermission;

use App\Repositories\BaseRepository;

class RoleHasPermissionRepository extends BaseRepository implements RoleHasPermissionRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\RoleHasPermission::class;
    }
}