<?php
namespace App\Repositories\ProductOption;

use App\Repositories\BaseRepository;

class ProductOptionRepository extends BaseRepository implements ProductOptionRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ProductOption::class;
    }

    public function getLastIndex() {
        return $this->model->orderBy('created_at', 'desc')->first();
    }
}