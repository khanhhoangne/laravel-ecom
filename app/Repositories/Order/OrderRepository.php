<?php
namespace App\Repositories\Order;

use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function getOrderDetail($id) {
        return $this->model->select('shop_orders.id', 'shop_orders.order_date', 'shop_orders.order_status',
        'shop_orders.shipped_date', 'shop_orders.paid_date','shop_customers.fullname','shop_customers.email',
        'shop_customers.phone',  'shop_payment_types.payment_name', 'shop_order_details.quantity',
        'shop_order_details.unit_price', 'shop_order_details.discount_amount', 'shop_products.product_name',
        'shop_products.image', 'shop_customer_address.address')
            ->join('shop_customers', 'shop_orders.customer_id', '=', 'shop_customers.id')
            ->join('shop_payment_types', 'shop_orders.payment_type_id', '=', 'shop_payment_types.id')
            ->join('shop_order_details', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_details.product_id')
            ->join('shop_customer_address', 'shop_customer_address.id', '=', 'shop_orders.address_id')
            ->where('shop_orders.id', '=', $id)
            ->get();
    }

    public function getAllOrder($conditions = [], $orderBy = [], $fieldAllows = [], $limit = [])
    {
        $prepare_query = $this->model->select('shop_orders.id', 'shop_orders.order_date', 'shop_orders.order_status',
        'shop_customers.fullname', 'shop_payment_types.payment_name', 'shop_order_details.quantity',
        'shop_order_details.unit_price', 'shop_order_details.discount_amount')
            ->join('shop_customers', 'shop_orders.customer_id', '=', 'shop_customers.id')
            ->join('shop_payment_types', 'shop_orders.payment_type_id', '=', 'shop_payment_types.id')
            ->join('shop_order_details', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_details.product_id')
            ->orderBy('shop_orders.created_at', 'desc');

        $this->handleConditions($conditions, $fieldAllows, $prepare_query);

        $this->handleOrderBy($orderBy, $fieldAllows, $prepare_query);

        return $this->handleLimit($limit, $prepare_query);
    }

    public function getLastIndex() {
        return $this->model->orderBy('created_at', 'desc')->first();
    }

    public function getOrderExported() {}
        
    public function getOrdersByCustomerId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = []) {
        $prepare_query = $this->model->select('shop_orders.id', 'shop_orders.order_date', 'shop_orders.order_status',
        'shop_order_details.quantity', 'shop_order_details.unit_price', 'shop_order_details.discount_amount',
        'shop_products.image', 'shop_products.product_name')
            ->join('shop_order_details', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_details.product_id')
            ->where('shop_orders.customer_id', '=', $id);

        $this->handleConditions($conditions, $fieldAllows, $prepare_query);

        $this->handleOrderBy($orderBy, $fieldAllows, $prepare_query);

        return $this->handleLimit($limit, $prepare_query);
    }

    public function getTopSell($conditions = [], $fieldAllows = [], $limit = []) {
        $prepare_query = $this->model->select('shop_order_details.quantity', 'shop_order_details.unit_price', 'shop_order_details.discount_amount',
        'shop_products.image', 'shop_products.product_name', 'shop_order_details.product_option', "shop_products.id")
            ->join('shop_order_details', 'shop_orders.id', '=', 'shop_order_details.order_id')
            ->join('shop_products', 'shop_products.id', '=', 'shop_order_details.product_id');

        $this->handleConditions($conditions, $fieldAllows, $prepare_query);

        return $this->handleLimit($limit, $prepare_query);
    }
}