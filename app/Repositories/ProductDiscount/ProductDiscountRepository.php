<?php
namespace App\Repositories\ProductDiscount;

use App\Repositories\BaseRepository;

class ProductDiscountRepository extends BaseRepository implements ProductDiscountRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ProductDiscount::class;
    }
}