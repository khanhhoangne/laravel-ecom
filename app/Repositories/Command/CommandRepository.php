<?php
namespace App\Repositories\Command;

use App\Repositories\BaseRepository;

class CommandRepository extends BaseRepository implements CommandRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Command::class;
    }
}