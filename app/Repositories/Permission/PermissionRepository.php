<?php
namespace App\Repositories\Permission;

use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Permission::class;
    }
}