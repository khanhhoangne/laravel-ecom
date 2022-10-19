<?php
namespace App\Repositories\Administrator;

use App\Repositories\BaseRepository;

class AdministratorRepository extends BaseRepository implements AdministratorRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\User::class;
    }
}