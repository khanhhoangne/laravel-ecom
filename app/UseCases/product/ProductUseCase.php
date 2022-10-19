<?php

namespace App\UseCases\Product;

use App\Models\Product;
use App\Repositories\Order\OrderRepositoryInterface;
use App\UseCases\UseCaseInterface;
use App\UseCases\Pagination;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductPrice\ProductPriceRepositoryInterface;
use App\Repositories\ProductOption\ProductOptionRepositoryInterface;
use App\Repositories\ProductDiscount\ProductDiscountRepositoryInterface;
use App\Repositories\ProductReview\ProductReviewRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\ImportDetail\ImportDetailRepositoryInterface;


class ProductUseCase implements UseCaseInterface
{

    protected $productRepo;
    protected $productPriceRepo;
    protected $productOptionRepo;
    protected $productDiscountRepo;
    protected $orderRepo;
    protected $reviewRepo;
    protected $orderDetailRepo;
    protected $importDetailRepo;

    const NEARLY_OUT_OF_STOCK = 50;
    const OUT_OF_STOCK = 0;
    const STOCK_PROCESSING = 1;
    const STOCK_REFUND = 2;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductPriceRepositoryInterface $productPriceRepo,
        ProductOptionRepositoryInterface $productOptionRepo,
        ProductDiscountRepositoryInterface $productDiscountRepo,
        OrderRepositoryInterface $orderRepo,
        ProductReviewRepositoryInterface $reviewRepo,
        OrderDetailRepositoryInterface $orderDetailRepo,
        ImportDetailRepositoryInterface $importDetailRepo
    ) {
        $this->productRepo = $productRepo;
        $this->productPriceRepo = $productPriceRepo;
        $this->productOptionRepo = $productOptionRepo;
        $this->productDiscountRepo = $productDiscountRepo;
        $this->orderRepo = $orderRepo;
        $this->reviewRepo = $reviewRepo;
        $this->orderDetailRepo = $orderDetailRepo;
        $this->importDetailRepo = $importDetailRepo;
    }

    public function getProductByName($search)
    {
        return $this->productRepo->findByFieldVersionOld(["product_name <=> " . $search], '', '', true);
    }

    public function getAllByCondition($pagination = [], $sort = [], $filter = [], $search = null)
    {
        // if(empty($pagination) && empty($sort) && empty($filter) && empty($search)) {
        //     return false;
        // }
        $orderBy = "created_at : asc";
        $limit = "";

        if ($pagination !== []) {
            $pagination = Pagination::paginate($pagination);
            $offset = ($pagination['page'] - 1) * $pagination['take'];
            $limit = $pagination['take'] . " : " . $offset;
        }

        $conditions = [];

        if ($filter !== []) {
            foreach ($filter['filter'] as $key => $value) {
                if ($key !== 'q' && !in_array($key, $this->productRepo->getProduct())) {
                    return false;
                }
                if ($key !== 'q') {
                    $conditions[] = "$key : $value";
                }
            }
            if ($search !== null) {
                $conditions[] = "product_name <=> " . $search;
            }
        }

        if ($sort !== []) {
            $orderBy = $sort['sort'] . ' : ' . $sort['order'];
        }

        $product = $this->productRepo->findByFieldVersionOld($conditions, $orderBy, $limit, true);


        if (empty($product)) {
            return false;
        }

        $strTemp = '';

        foreach ($product as $key => $data) {
            $strTemp .= strval($data['id']) . ',';
            $productPrice[] = $this->productPriceRepo->findByFieldVersionOld(["product_id : " . $data['id']], $orderBy, $limit, true);
            if ($productPrice[$key] == []) {
                unset($productPrice[$key]);
            }
            $product[$key]['image'] = env('APP_URL') . '/storage/uploads/products/' . $data['image'];
        
            $productRating = $this->reviewRepo->findByFieldVersionOld(["product_id : " . $data['id']], "", "", true);

            $product[$key]['rated'] = 0;
    
            if(!empty($productRating)) {
                foreach($productRating as $data) {
                    $product[$key]['rated'] += $data['rating'];
                }
                $product[$key]['rated'] /= count($productRating);
            }
        }

        $strTemp = substr($strTemp, 0, -1);

        foreach ($productPrice as $key => $data) {
            usort($productPrice[$key], function ($item1, $item2) {
                return $item1['price'] <=> $item2['price'];
            });
        }

        $discount = $this->productDiscountRepo->findByFieldVersionOld(['product_id {in}' . $strTemp], '', '', true);

        foreach ($productPrice as $key => $value) {
            foreach ($product as $keySecond => $data) {
                if ($product[$keySecond]['id'] == $productPrice[$key][0]['product_id']) {
                    $product[$keySecond]['price'] = $productPrice[$key][0]['price'];
                    unset(
                        $product[$keySecond]['short_description'],
                        $product[$keySecond]['description'],
                    );
                }
            }
        }

        foreach ($discount as $data) {
            foreach ($product as $key => $value) {
                if ($data['product_id'] == $value['id']) {
                    $product[$key]['discount'] = $data;
                    if ($data['is_flashsale'] == 'Not flash sale') {
                        unset(
                            $product[$key]['discount']['id'],
                            $product[$key]['discount']['product_id']
                        );
                        continue;
                    }
                }
            }
        }



        return $product;
    }

    public function getProductDiscount($pagination = [])
    {
      
        $orderBy = "created_at : asc";
        $limit = "";

        $conditions = [];

        if ($pagination !== []) {
            $pagination = Pagination::paginate($pagination);
            $offset = ($pagination['page'] - 1) * $pagination['take'];
            $limit = $pagination['take'] . " : " . $offset;
        }

        $product = $this->productRepo->findByFieldVersionOld($conditions, '', '', true);
     
        if (empty($product)) {
            return false;
        }

        $strTemp = '';

        foreach ($product as $key => $data) {
            $strTemp .= strval($data['id']) . ',';
            $productPrice[] = $this->productPriceRepo->findByFieldVersionOld(["product_id : " . $data['id']], $orderBy, $limit, true);
            if ($productPrice[$key] == []) {
                unset($productPrice[$key]);
            }
           
            $product[$key]['image'] = env('APP_URL') . '/storage/uploads/products/' . $data['image'];
            $productRating = $this->reviewRepo->findByFieldVersionOld(["product_id : " . $data['id']], "", "", true);
        
            $product[$key]['rated'] = 0;
    
            if(!empty($productRating)) {
                foreach($productRating as $data) {
                    $product[$key]['rated'] += $data['rating'];
                }
                $product[$key]['rated'] /= count($productRating);
            }
        }

        $strTemp = substr($strTemp, 0, -1);

        foreach ($productPrice as $key => $data) {
            usort($productPrice[$key], function ($item1, $item2) {
                return $item1['price'] <=> $item2['price'];
            });
        }

        $discount = $this->productDiscountRepo->findByFieldVersionOld([], $orderBy, $limit, true);

        foreach ($productPrice as $key => $value) {
            foreach ($product as $keySecond => $data) {
                if ($product[$keySecond]['id'] == $productPrice[$key][0]['product_id']) {
                    $product[$keySecond]['price'] = $productPrice[$key][0]['price'];
                    unset(
                        $product[$keySecond]['short_description'],
                        $product[$keySecond]['description'],
                    );
                }
            }
        }

        $count = 0;

        $product_discount = [];

        foreach ($product as $key => $value) {
            foreach ($discount as $data) {
                if($count === count($discount)){
                    break;
                }
                if ($data['product_id'] == $value['id']) {
                    $count++;
                    $product[$key]['discount'] = $data;
                    
                    if ($data['is_flashsale'] == 'Not flash sale') {
                        unset(
                            $product[$key]['discount']['id'],
                            $product[$key]['discount']['product_id']
                        );
                    }
                    $product_discount[] = $product[$key];
                }
            }
            
        }

        return $product_discount;
    }

    public function getProductReviews($id, $pagination = []){       
        if ($pagination !== []) {
            $pagination = Pagination::paginate($pagination);
            $offset = ($pagination['page'] - 1) * $pagination['take'];
            $take = $pagination['take'];
        }

        $productReview = $this->reviewRepo->getReviews($id, $offset ?? 0, $take ?? 100);
        dd($productReview);
        return $productReview;
    }

    public function exportProduct($id, $option) {
        $export = $this->orderDetailRepo->getAllOrderDetailCompleted(self::STOCK_PROCESSING)->toArray();
        
        $stack = 0;
        foreach($export as $data) {
            if($data['product_id'] == intval($id) && $data['product_option'] == $option[0]) {
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


    public function getAll()
    {
        return $this->productRepo->getAll();
    }

    public function find($id)
    {
        $product = $this->productRepo->getProductById($id);
        if (empty($product)) {
            throw new \Exception("The request just sent is not valid.");
        }

        $product = $product[0];

        $product['image'] = env('APP_URL') . '/storage/uploads/products/' . $product['image'];

        $gallery = array_map(function ($val) {
            return env('APP_URL') . '/storage/uploads/products/' . $val['image'];
        }, $this->productRepo->getProductGalleryById($id));

        $discount = $this->productRepo->getProductDiscountById($id);
        
        if(!empty($discount)) {
            if (!empty($discount['is_flashsale'])) {
                if ($discount['is_flashsale'] === 'Not flash sale') {
                    unset(
                        $discount['start_date'],
                        $discount['end_date']
                    );
                }
            }
            $product['discount'] = $discount;
        }
        

        if (!empty($gallery)) {
            $product['gallery'] = $gallery;
        }

        $productPrice = $this->productPriceRepo->findByFieldVersionOld(["product_id : " . $id], "", "", true);
        $productOption = $this->productOptionRepo->findByFieldVersionOld(["product_id : " . $id], "", "", true);
        $listOption = array();
        $i = 0;
        foreach ($productPrice as $value) {
            if (intval($value['option_id']) == 0 || $value['option_id'] == null) {
                $product['price'] = $value['price'];
                return $product;
            }
            $slices = explode(',', $value['option_id']);
            $count = count($slices);
            $import = $this->importDetailRepo->getAllImportDetailByProduct($id, $slices)->toArray();
            
            foreach ($slices as $key => $slice) {
                foreach ($productOption as $data) {
                    if ($slice == $data['id']) {
                        $listOption[$i][] = [
                            'option_id' => $data['id'],
                            'option' => $data['option'],
                            'detail' => $data['detail']
                        ];
                        if ($key == $count - 1) {
                            if(empty($import)) {
                                $cal = 0;
                            } else {
                                $cal = intval($import[0]['total']) - $this->exportProduct($id, $slices);
                            }
                            
                            $listOption[$i][] = [
                                'price' => $value['price'],
                            ];

                            if($cal > 0) {
                                $listOption[$i][] = [
                                    'is_stock' => 1,
                                ];
                            } else {
                                $listOption[$i][] = [
                                    'is_stock' => 0,
                                ];
                            }
                            
                        }
                    }
                }
            }
            $i++;
        }

        $productRating = $this->reviewRepo->findByFieldVersionOld(["product_id : " . $id], "", "", true);
        
        $product['rated'] = 0;

        if(!empty($productRating)) {
            foreach($productRating as $data) {
                $product['rated'] += $data['rating'];
            }
            $product['rated'] /= count($productRating);
        }

        if($product['rated'] === 0) {
            $product['total_reviews'] = 0;
        } else {
            $product['total_reviews'] = count($productRating);
        }

        $product['list_option'] = $listOption;

        foreach ($listOption as $key => $value) {
            
        }
        


        return $product;
    }

    public function createReview($data = []) {
        $this->reviewRepo->create($data);
    }

    public function getAndPaginate($query = [])
    {
        $fieldAllows = [];
        $limit = [
            'page' => 1,
            'limit' => 10,
        ];
        $conditions = [];
        if (!empty($query['limit'])) {
            $limit = $query['limit'];
        }
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }

        $productQuery = Product::select(
            'id',
            'product_code',
            'product_name',
            'product_slug',
            'is_continued',
            'image',
            'category_id',
            'supplier_id'
        );
        $this->productRepo->handleConditions($conditions, $fieldAllows, $productQuery);

        $this->productRepo->handleOrderBy(['created_at' => 'desc'], $fieldAllows, $productQuery);

        $products = $productQuery->paginate($limit['limit'], "*", "_page_", $limit['page']);

        if (!empty($products->toArray())) {
            foreach ($products as $product) {
                $product->category;
                $product->supplier;
            }
        }

        return $products;
    }

    public function createProduct($data = [])
    {
        $product = $data;

        if (!empty($product['list_option'])) {
            unset($product['list_option']);
            $options = $data['list_option'];
        }

        if (!empty($product['discount'])) {
            unset($product['discount']);
            $discount = $data['discount'];
        }

        $this->productRepo->create($product);

        $lastIndexProduct = $this->productRepo->getLastIndex()->toArray()['id'];

        if (!empty($discount)) {
            $discount['product_id'] = $lastIndexProduct;
            $this->productDiscountRepo->create($discount);
        }

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $optionCompare = '';
                foreach ($value as $keySecond => $option) {
                    if ($keySecond < count($options[$key]) - 1) {
                        $this->productOptionRepo->create(['product_id' => $lastIndexProduct, 'option' => $option['option'], 'detail' => $option['detail']]);
                        $lastIndexProductOption = $this->productOptionRepo->getLastIndex()->toArray()['id'];
                        $optionCompare .= $lastIndexProductOption;
                    }

                    if ($keySecond === count($options[$key]) - 1) {
                        $this->productPriceRepo->create(['product_id' => $lastIndexProduct, 'option_id' => $optionCompare, 'price' => $option['price']]);
                    }
                }
            }
        }
    }

    public function getTopSell($query)
    {
        $conditions = [];
        $limit = [];
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }
        if (!empty($query['pagination'])) {
            $limit = $query['pagination'];
        }
        $fieldAllows = [
            "created_at", "order_status"
        ];
        foreach ($conditions as $key => $condition) {
            if (str_contains($condition, 'created_at')) {
                $conditions[$key] = "shop_orders." . $condition;
            }
        }
        array_push($conditions, "order_status : 4");
        $topSells = $this->orderRepo->getTopSell($conditions, $fieldAllows, []);

        $topSells = $topSells->toArray();

        // handle calculate total money
        for ($i = 0; $i < count($topSells); $i++) {
            $topSells[$i]['total'] = $topSells[$i]['quantity'] * $topSells[$i]['unit_price'] - $topSells[$i]['discount_amount'];
        }

        // handle duplicate products options
        $topSellsCalc = [];
        for ($i = 0; $i < count($topSells); $i++) {
            if (empty($topSellsCalc[$topSells[$i]['product_option']])) {
                $topSellsCalc[$topSells[$i]['product_option']] = $topSells[$i];
            } else {
                $topSellsCalc[$topSells[$i]['product_option']]['total'] += $topSells[$i]['total'];
                $topSellsCalc[$topSells[$i]['product_option']]['quantity'] += $topSells[$i]['quantity'];
            }
        }

        // query option id
        foreach ($topSellsCalc as $key => $top) {
            $arrId = explode(',', $top['product_option']);
            $strOption = [];
            foreach ($arrId as $id) {
                $option = $this->productOptionRepo->find($id)->detail;
                array_push($strOption, $option);
            }
            $topSellsCalc[$key]['option'] = implode(' | ', $strOption);
        }

        // handle sort top sells
        usort($topSellsCalc, function ($a, $b) {
            if ($a['quantity'] < $b['quantity']) return 1;
            if ($b['quantity'] < $a['quantity']) return -1;

            return 0;
        });

        $topSellsCalc = array_slice($topSellsCalc, 0, $limit['limit']);

        return $topSellsCalc;
    }

    public function create($attributes = [])
    {
    }

    public function update($id, $attributes = [])
    {
    }


    public function delete($id)
    {
        return $this->productRepo->delete($id);
    }
}
