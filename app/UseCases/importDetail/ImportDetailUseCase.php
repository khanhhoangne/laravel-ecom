<?php

namespace App\UseCases\ImportDetail;

use App\UseCases\UseCaseInterface;
use App\Repositories\ImportDetail\ImportDetailRepositoryInterface;
use App\Repositories\ProductOption\ProductOptionRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;


class ImportDetailUseCase implements UseCaseInterface
{

    protected $importDetailRepo;
    protected $productOptionRepo;
    protected $orderDetailRepo;
    const NEARLY_OUT_OF_STOCK = 50;
    const OUT_OF_STOCK = 0;
    const STOCK_PROCESSING = 1;
    const STOCK_REFUND = 2;

    public function __construct(ImportDetailRepositoryInterface $importDetailRepo
        , ProductOptionRepositoryInterface $productOptionRepo
        , OrderDetailRepositoryInterface $orderDetailRepo
    )
    {
        $this->importDetailRepo = $importDetailRepo;
        $this->productOptionRepo = $productOptionRepo;
        $this->orderDetailRepo = $orderDetailRepo;
    }

    public function getAllByCondition($query = [])
    {
    }

    public function getImportDetail($id)
    {
        $importDetail = $this->importDetailRepo->getImportDetail($id)->toArray();
        
        return $this->handleOptionName($importDetail);
    }

    public function getAllImportDetail($idProduct)
    {
        $importDetail = $this->importDetailRepo->getAllImportDetail()->toArray();
        foreach ($importDetail as $data) {
            if ($data['product_id'] == $idProduct) {
                $product[] = $data;
            }
        }   

        if(empty($product)) {
            return false;
        }

        $product = $this->handleOptionName($product);
        

        foreach ($product as $key => $data) {
            $product[$key]['total'] = $data['total'] - $this->exportProduct($data['product_id'], $data['product_option']);
        }

        return $product;
    }

    public function exportProduct($id, $option) {
        $export = $this->orderDetailRepo->getAllOrderDetailCompleted(self::STOCK_PROCESSING)->toArray();
        $stack = 0;
        foreach($export as $data) {
            if($data['product_id'] == $id && $data['product_option'] == $option) {
                $stack += $data['total'];
            }
        }
        $refundStock = $this->orderDetailRepo->getAllOrderDetailCompleted(self::STOCK_REFUND)->toArray();

        foreach ($refundStock as $data) {
            if($data['product_id'] == $id && $data['product_option'] == $option) {
                $stack -= $data['total'];
            }
        }
        return $stack;
    }

    public function calculateQuantityProduct($type, $page) {
        $products = $this->importDetailRepo->getAllImportDetail()->toArray();
        foreach ($products as $key => $data) {
            $products[$key]['total'] = $data['total'] - $this->exportProduct($data['product_id'], $data['product_option']);
            if($type == 1) {
                if($products[$key]['total'] == self::OUT_OF_STOCK || $products[$key]['total'] > self::NEARLY_OUT_OF_STOCK ) {
                    unset($products[$key]);
                }
            } else {
                if($products[$key]['total'] > self::OUT_OF_STOCK) {
                    unset($products[$key]);
                }
            }
        }

        $products = $this->handleOptionName($products);

        return $products;

        
    }

    public function handleOptionName($arr){
        foreach ($arr as $key => $data) {
            $str = '';
            if ($data['product_option'] != 0) {
                $splices = explode(',', $data['product_option']);
                foreach ($splices as $keySecond => $splice) {
                    $optionDetail =  $this->productOptionRepo->findByFieldVersionOld(['id : ' . $splice], '', '', true)[0]['detail'];
                    $str .= $optionDetail;
                    if ($keySecond < count($splices) - 1) {
                        $str .= ', ';
                    }
                }
            }
            $arr[$key]['option_name'] = $str;
        }
        return $arr;
    }



    public function getAll()
    {
    }

    public function find($id)
    {
        return $this->importDetailRepo->find($id);
    }

    public function create($attributes = [])
    {
        $this->importDetailRepo->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $this->importDetailRepo->update($id, $attributes);
    }

    public function delete($id)
    {
        $this->importDetailRepo->delete($id);
    }
}
