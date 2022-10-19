<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use App\UseCases\ImportDetail\ImportDetailUseCase;
use Illuminate\Support\Facades\Http;
use App\UseCases\Product\ProductUseCase;
use Illuminate\Support\Facades\Config;

class AdminExportComponent extends Component
{
    private $importDetailUseCase;
    private $productUseCase;
    public $product;
    public $productSearch;
    public $selected = false;
    public $productSelected;
    public $importDetail;
    public $status = "1";
    public $productStockType;
    public $checkedStatus;
    public $page = 1;
    public $takeProduct = 1;


    public function boot(ImportDetailUseCase $importDetailUseCase, ProductUseCase $productUseCase)
    {
        $this->importDetailUseCase = $importDetailUseCase;
        $this->productUseCase = $productUseCase;
    }

    public function selectedProduct($id) {
        $this->productSelected = $this->productUseCase->find($id);
        $this->importDetailUseCase->getImportDetail($id);
        $this->selected = true;

        $selectProduct = $this->importDetailUseCase->getAllImportDetail($id);
        
        if(!$selectProduct) {
            $this->dispatchBrowserEvent('alert', 
            ['type' => 'error',  'message' => 'Không tìm thấy dữ liệu!']);
            $this->importDetail = [];
        } else { 
            $this->importDetail = $selectProduct;
        }
    }

    public function mount() {
        $this->filterStatus();
    }

    public function removeSelected() {
        $this->selected = false;
        $this->productSelected = null;
    }

    public function handleChange()
    {
        if(!empty($this->product)) {
            $this->productSearch = $this->productUseCase->getProductByName($this->product);
        } else {
            $this->productSearch = [];
        }
    }

    public function filterStatus($page = null) {
        $this->productStockType = $this->importDetailUseCase->calculateQuantityProduct($this->status, $page);
        $this->productStockType = array_values($this->productStockType);
        $this->checkedStatus = $this->status;
        $this->page = 1;
    }

    public function filterByRange($page) {
        $this->page = intval($page);
    }

    public function resetPage() {
        $this->page = 1;
    }


    public function render()
    {
        $pageTitle = 'Quản lý kho hàng';

        return view('livewire.warehouse.admin-export-component')
            ->layout(
                'layouts.base',
                [
                    'pageTitle' => $pageTitle,
                    'commandsOfUser' => Config::get('commands'),
                    'account' =>  Config::get('user'),
                ]
            );
    }
}
