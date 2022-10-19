<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use App\UseCases\Order\OrderUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminOrderComponent extends Component
{

    private $orderUseCase;
    private $orders;
    public $orderDetails;
    public $show = false;
    public $limit=6;
    public $page;

    protected $fillable = ['order_status']; 

    public function boot(
        OrderUseCase $orderUseCase,
    ) {
        $this->orderUseCase = $orderUseCase;

        $limit = [
            'limit' => $this->limit,
            'page' => $this->page
        ];

        $conditions['limit'] = $limit;

        $this->orders = $this->orderUseCase->getAllByCondition($conditions);
    }   

    public function changeStatus($id, $status)
    {
        Order::where('id', $id)->update(['order_status' => intval($status)]);

        $limit = [
            'limit' => $this->limit,
            'page' => $this->page
        ];

        $conditions['limit'] = $limit;

        $this->orders = $this->orderUseCase->getAllByCondition($conditions);
    }

    public function getOrderDetail($id) {
        $this->orderDetails = $this->orderUseCase->getOrderDetail($id);

        $this->show = true;
    }

    public function closeModal() {
        $this->show = false;
    }

    public function handlePaginate($page, $take) {
        $this->page = $page;
        $this->take = $take;
    }

    public function render()
    {
        $pageTitle = 'Danh sách đơn hàng';

        return view('livewire.orders.admin-order-component', [
            'orders' => $this->orders
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
