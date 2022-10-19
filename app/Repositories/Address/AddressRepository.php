<?php
namespace App\Repositories\Address;

use App\Repositories\BaseRepository;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Address::class;
    }
}