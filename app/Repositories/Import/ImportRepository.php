<?php
namespace App\Repositories\Import;

use App\Repositories\BaseRepository;

class ImportRepository extends BaseRepository implements ImportRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Import::class;
    }

    public function getLastIndex() {
        return $this->model->orderBy('created_at', 'desc')->first();
    }

    public function getAllImport($date, $sort, $by) {
        return $this->model->select('shop_imports.id', 'shop_stores.store_name', 'shop_imports.import_date')
            ->join('shop_stores', 'shop_imports.store_id', '=', 'shop_stores.id')
            ->whereBetween('import_date', array(''.$date.' 00:00:00', ''.$date.' 23:59:59'))
            ->orderBy('shop_imports.'.$sort, $by)->get();
    
    }
}