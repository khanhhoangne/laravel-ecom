<?php

namespace App\Http\Livewire\Products;

use App\UseCases\Product\ProductUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class AdminProductComponent extends Component
{
    protected $listeners = ['delete' => 'deleteProduct'];
    private $productUseCase;
    protected $products;
    public $limit=6;
    public $page;

    public function boot(
        ProductUseCase $productUseCase,
    ) {
        $this->productUseCase = $productUseCase;

        $limit = [
            'limit' => $this->limit,
            'page' => $this->page
        ];

        $conditions['limit'] = $limit;

        $this->products = $this->productUseCase->getAndPaginate($conditions);
    }  

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deleteProduct($id) {
        $this->productUseCase->delete($id);

        $this->products = $this->productUseCase->getAndPaginate();
    }

    public function handlePaginate($page, $take) {
        $this->page = $page;
        $this->take = $take;
    }

    public function render()
    {
        $pageTitle = 'Danh sách Sản phẩm';
      
        return view('livewire.products.admin-product-component', [
            'products' => $this->products,
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
