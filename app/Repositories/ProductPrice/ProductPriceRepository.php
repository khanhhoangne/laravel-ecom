<?php
namespace App\Repositories\ProductPrice;

use App\Repositories\BaseRepository;

class ProductPriceRepository extends BaseRepository implements ProductPriceRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ProductPrice::class;
    }
}