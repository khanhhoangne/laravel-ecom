<?php
namespace App\Repositories\ImportDetail;

use App\Repositories\BaseRepository;

class ImportDetailRepository extends BaseRepository implements ImportDetailRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ImportDetail::class;
    }

    public function getImportDetail($id)
    {
        return $this->model->select('shop_products.product_name', 'shop_import_detail.product_option', 'shop_import_detail.quantity', 'shop_import_detail.unit_price')
            ->join('shop_products', 'shop_products.id', '=', 'shop_import_detail.product_id')
            ->where('import_id', '=', $id)
            ->get();
    }
    
    public function getAllImportDetail() {
        return $this->model->select('shop_products.product_name','shop_import_detail.product_id', 'shop_import_detail.product_option')
        ->selectRaw('sum(shop_import_detail.quantity) as total')
        ->join('shop_products', 'shop_products.id', '=', 'shop_import_detail.product_id')
        ->groupBy('shop_import_detail.product_option')
        ->get();
    }

    public function getAllImportDetailByProduct($id, $option) {
        return $this->model->select('shop_products.product_name','shop_import_detail.product_id', 'shop_import_detail.product_option')
        ->selectRaw('sum(shop_import_detail.quantity) as total')
        ->join('shop_products', 'shop_products.id', '=', 'shop_import_detail.product_id')
        ->where('product_id', '=', $id)
        ->where('product_option', '=', $option)
        ->groupBy('shop_import_detail.product_option')
        ->get();
    }
 
}