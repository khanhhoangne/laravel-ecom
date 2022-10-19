<?php

namespace App\Http\Livewire;

use App\UseCases\StatisticUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class DashboardComponent extends Component
{
    private $statisticUseCase;
    public $customersCount;
    public $revenue;
    public $ordersCount;
    protected $orders;
    protected $topSells;
    public $reportYear;

    public $typeCustomersCount = 'Tháng này';
    public $typeRevenue = 'Tháng này';
    public $typeOrdersCount = 'Tháng này';
    public $typeOrders = 'Tháng này';
    public $typeTopSells = 'Tháng này';

    public $limitOrders = 10;

    public function boot(
        StatisticUseCase $statisticUseCase,
    ) {
        $this->statisticUseCase = $statisticUseCase;

        $this->customersCount = $this->statisticUseCase->statisticCountCustomers($this->typeCustomersCount);
        $this->revenue = $this->statisticUseCase->statisticRevenue($this->typeRevenue);
        $this->ordersCount = $this->statisticUseCase->statisticCountOrders($this->typeOrdersCount);
        $this->orders = $this->statisticUseCase->statisticNewestOrders($this->typeOrders, $this->limitOrders);
        $this->topSells = $this->statisticUseCase->statisticTopSell($this->typeTopSells);

        $this->reportYear = $this->statisticUseCase->statisticReportYear();
    } 

    public function render()
    {
        $pageTitle = 'Trang chủ';
        return view('livewire.dashboard-component', [
            'orders' => $this->orders,
            'topSells' => $this->topSells,
            'countCustomersByMonth' => $this->reportYear['countCustomersByMonth'],
            'countOrdersByMonth' => $this->reportYear['countOrdersByMonth'],
            'totalRevenueByMonth' => $this->reportYear['totalRevenueByMonth'],
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
