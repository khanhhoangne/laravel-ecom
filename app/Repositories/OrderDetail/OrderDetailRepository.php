<?php
namespace App\Repositories\OrderDetail;

use App\Repositories\BaseRepository;

class OrderDetailRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\OrderDetail::class;
    }

    public function getAllOrderDetailCompleted($status, $conditions = []) {
        $prepare_query = $this->model->select('shop_order_details.product_id', 'shop_order_details.product_option', 
        'quantity as total', 'discount_amount', 'unit_price', 'shop_order_details.created_at')
        ->join('shop_orders', 'shop_orders.id', '=', 'shop_order_details.order_id')
        ->where('order_status', '=', $status);

        $this->handleConditions($conditions, [], $prepare_query);
        
        return $this->handleLimit([], $prepare_query);
    }
}