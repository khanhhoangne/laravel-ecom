<?php
namespace App\Repositories\GrantPermission;

use App\Repositories\BaseRepository;

class GrantPermissionRepository extends BaseRepository implements GrantPermissionRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\GrantPermission::class;
    }
}