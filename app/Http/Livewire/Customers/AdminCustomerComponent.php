<?php

namespace App\Http\Livewire\Customers;

use App\UseCases\Customer\CustomerUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminCustomerComponent extends Component
{
    private $customerUseCase;
    public $take=6;
    public $page=1;
    public $sort='shop_customers.created_at';
    public $order='desc';
    public $search;

    protected $queryString = ['take', 'page', 'sort', 'order'];

    public function boot(
        CustomerUseCase $customerUseCase,
    ) {
        $this->customerUseCase = $customerUseCase;
    }  

    public function handlePaginate($page, $take) {
        $this->page = $page;
        $this->take = $take;
    }

    public function updateSearch($search) {
        $this->search = $search;

        $this->page = 1;
        $this->take = 6;
    }

    public function render()
    {
        $pageTitle = 'Danh sách khách hàng';
        
        $pagination = [
            'take' => $this->take,
            'page' => $this->page
        ];
        $sortBy = [
            'sort' => $this->sort,
            'order' => $this->order
        ];
        $filter = [];

        $customersData = $this->customerUseCase->getAllByCondition($pagination, $sortBy, $filter, $this->search);

        $this->page = $customersData['pagination']['curPage'];

        return view('livewire.customers.admin-customer-component', [
            'customers' => $customersData['elements'],
            'pageCount' => $customersData['pagination']['pageCount'],
            'curPage' => $customersData['pagination']['curPage'],
            'itemCount' => $customersData['pagination']['itemCount'],
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
