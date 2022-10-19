<?php

namespace App\UseCases\Order;

use App\Models\Order;
use App\UseCases\UseCaseInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\ProductOption\ProductOptionRepositoryInterface;

class OrderUseCase implements UseCaseInterface {

    protected $orderRepo;
    protected $productOptionRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ProductOptionRepositoryInterface $productOptionRepo,
    )
    {
        $this->orderRepo = $orderRepo;
        $this->productOptionRepo = $productOptionRepo;
    }

    public function getAll() {

    }
    
    public function getOrderExported() {
        $orders = $this->orderRepo->getOrderExported()->toArray();
    }

    public function getOrdersByCustomerId($id, $query = []) {
        $fieldAllows = ['order_status', 'created_at'];
        $limit = [];
        $orderBy = [
            'created_at' => 'desc',
        ];

        if (!empty($query['pagination'])) {
            $limit = $query['pagination'];
        }

        if (!empty($query['orderBy'])) {
            $orderBy = $query['orderBy'];
        }

        $ordersQuery = Order::where('customer_id', $id);
        $this->orderRepo->handleConditions($query['conditions'], $fieldAllows, $ordersQuery);

        $this->orderRepo->handleOrderBy($orderBy ,$fieldAllows, $ordersQuery);

        $orders = $ordersQuery->paginate($limit['limit'], "*", "_page", $limit['page'])->withQueryString();

        if (!empty($orders->toArray())) {
            $orders->appends([
                'orderBy' => null, 
                'pagination' => null, 
                'conditions' => null
            ]);
            
            foreach ($orders as $order) {
                foreach ($order->orderdetails as $key => $orderItem) {
                    $optionIds = $orderItem->product_option;
                    if (!empty($optionIds)) {
                        $optionIdsArr = explode(',', $optionIds);
                        $optionArray = [];
                        foreach ($optionIdsArr as $optionId) {
                            $option = $this->productOptionRepo->find($optionId);
                            array_push($optionArray, [
                                'option' => $option->option,
                                'detail' => $option->detail
                            ]);
                        }
                        $order->orderdetails[$key]->product_option = $optionArray;
                    }
                    $orderItem->product;
                }
            } 
        }

        return $orders;
    }

    public function getAllByCondition($query = []) {
        $fieldAllows = [];
        $conditions = [];
        $limit = [
            "page" => 1,
            "limit" => 6
        ];
        $orderBy = [
            'shop_orders.created_at' => 'desc',
        ];

        if (!empty($query['pagination'])) {
            $limit = $query['pagination'];
        }

        if (!empty($query['orderBy'])) {
            $orderBy = $query['orderBy'];
        }

        if (!empty($query['limit'])) {
            $limit = $query['limit'];
        }

        $orders = $this->orderRepo->getAllOrder($conditions, $orderBy, $fieldAllows, $limit);

        $ordersTmp = $orders->toArray();
        if (count($limit)) {
            $ordersTmp = $orders->toArray()['data'];
        }

        // xử lý tính toán tổng tiền  
        for ($i = 0; $i < count($ordersTmp); $i++) {
            $ordersTmp[$i]['total'] = $ordersTmp[$i]['quantity']*$ordersTmp[$i]['unit_price'] - $ordersTmp[$i]['discount_amount'];
            unset($ordersTmp[$i]['quantity']);
            unset($ordersTmp[$i]['unit_price']);
            unset($ordersTmp[$i]['discount_amount']);
        }
        
        // xử lý gộp các đơn hàng chi tiết vào đơn hàng
        $ordersCalc = [];
        for ($i = 0; $i < count($ordersTmp); $i++) {
            if (empty($ordersCalc[$ordersTmp[$i]['id']])) {
                $ordersCalc[$ordersTmp[$i]['id']] = $ordersTmp[$i];
            } else {
                $ordersCalc[$ordersTmp[$i]['id']]['total'] += $ordersTmp[$i]['total'];
            }
        }

        $orders['data'] = $ordersCalc;

        // dd($orders);

        return $orders;
    }

    public function getLastIndex() {
        return $this->orderRepo->getLastIndex()->toArray();
    }

    public function find($id) {
        return $this->orderRepo->find($id);
    }

    public function create($attributes = []) {
        $this->orderRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        $this->orderRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->orderRepo->delete($id);
    }

    public function getOrderDetail($id) {
        return $this->orderRepo->getOrderDetail($id)->toArray();
    }
}