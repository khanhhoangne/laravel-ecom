<?php

namespace App\UseCases;

use App\Models\Order;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductOption\ProductOptionRepositoryInterface;
use Carbon\Carbon;

class StatisticUseCase {

    protected $productRepo;
    protected $customerRepo;
    protected $orderRepo;
    protected $orderDetailRepo;
    protected $productOptionRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CustomerRepositoryInterface $customerRepo,
        OrderRepositoryInterface $orderRepo,
        OrderDetailRepositoryInterface $orderDetailRepo,
        ProductOptionRepositoryInterface $productOptionRepo,
    )
    {
        $this->productRepo = $productRepo;
        $this->customerRepo = $customerRepo;
        $this->orderRepo = $orderRepo;
        $this->orderDetailRepo = $orderDetailRepo;
        $this->productOptionRepo = $productOptionRepo;
    }

    public function statisticCountCustomers($type) {
        $durations = $this->handleTypeTime($type);
        $curCount = $this->customerRepo->countIf([
            "created_at >= ".$durations['firstDayOrCurrent'],
            "created_at <= ".$durations['lastDayOrCurrent']]
        );
        $prevCount = $this->customerRepo->countIf([
            "created_at >= ".$durations['firstDayOfPrevious'],
            "created_at <= ".$durations['lastDayOfPrevious']]
        );
        return [
            "type" => $type,
            "curCount" => $curCount,    
            "prevCount" => $prevCount
        ];
    }

    public function statisticRevenue($type) {
        $durations = $this->handleTypeTime($type);
        $conditionsCurrent = [
            "created_at >= ".$durations['firstDayOrCurrent'],
            "created_at <= ".$durations['lastDayOrCurrent']
        ];
        $conditionsOrderCurrent = $conditionsCurrent;
        array_push($conditionsOrderCurrent, "order_status : 4");
        $ordersCurrent = $this->orderRepo->findByField($conditionsOrderCurrent);
        
        $orderIds = [];
        if (count($ordersCurrent)) {
            foreach ($ordersCurrent as $order) {
                array_push($orderIds, $order->id);
            }
        }
        $orderIds = implode(',', $orderIds);
        $conditionsOrderDetailCurrent = $conditionsCurrent;
        array_push($conditionsOrderDetailCurrent, "order_id {in} $orderIds");
        $curTotalItem = $this->orderDetailRepo->findByField($conditionsOrderDetailCurrent)->toArray();

        $conditionsPrevious = [
            "created_at >= ".$durations['firstDayOfPrevious'],
            "created_at <= ".$durations['lastDayOfPrevious']
        ];
        $conditionsOrderPrevious = $conditionsPrevious;
        array_push($conditionsOrderPrevious, "order_status : 4");
        $ordersPrevious = $this->orderRepo->findByField($conditionsOrderPrevious);
        
        $orderIds = [];
        if (count($ordersPrevious)) {
            foreach ($ordersPrevious as $order) {
                array_push($orderIds, $order->id);
            }
        }
        $orderIds = implode(',', $orderIds);
        $conditionsOrderDetailPrevious = $conditionsPrevious;
        array_push($conditionsOrderDetailPrevious, "order_id {in} $orderIds");
        $prevTotalItem = $this->orderDetailRepo->findByField($conditionsOrderDetailPrevious)->toArray();
        
        $curTotal = 0;
        $prevTotal = 0;

        if (!empty($curTotalItem)) {
            foreach ($curTotalItem as $item) {
                $curTotal += $item->quantity*$item->unit_price - $item->discount_amount;
            }
        }

        if (!empty($prevTotalItem)) {
            foreach ($prevTotalItem as $item) {
                $prevTotal += $item->quantity*$item->unit_price - $item->discount_amount;
            }
        }

        return [
            "type" => $type,
            "curTotal" => intval($curTotal),    
            "prevTotal" => intval($prevTotal)   
        ];
    }

    public function statisticCountOrders($type) {
        $durations = $this->handleTypeTime($type);
        $curCount = $this->orderRepo->countIf([
            "created_at >= ".$durations['firstDayOrCurrent'],
            "created_at <= ".$durations['lastDayOrCurrent']]
        );
        $prevCount = $this->orderRepo->countIf([
            "created_at >= ".$durations['firstDayOfPrevious'],
            "created_at <= ".$durations['lastDayOfPrevious']]
        );
        return [
            "type" => $type,
            "curCount" => $curCount,    
            "prevCount" => $prevCount
        ];
    }

    public function statisticNewestOrders($typeOrders, $limitOrders)  {
        $durations = $this->handleTypeTime($typeOrders);
        $conditions = [
            "created_at >= ".$durations['firstDayOrCurrent'],
            "created_at <= ".$durations['lastDayOrCurrent']
        ];
        $fieldAllows = [];
        $limit = [
            "limit" => $limitOrders,
            "page" => 1
        ];
        $orderBy = [
            'created_at' => 'desc'
        ];
        $ordersQuery = Order::select('order_status', 'id', 'customer_id', 'payment_type_id');
        $this->orderRepo->handleConditions($conditions, $fieldAllows, $ordersQuery);
        $this->orderRepo->handleOrderBy($orderBy, $fieldAllows, $ordersQuery);
        $orders = $ordersQuery->paginate($limit['limit'], "*", "_page", $limit['page']);
        if (!empty($orders->toArray())) {
            foreach ($orders as $order) {
                foreach ($order->orderdetails as $orderItem) {
                    $orderItem->product;
                }
                $order->customer;
                $order->payment;
            } 
        }
        return $orders->items();
    }

    public function statisticTopSell($type) {
        $durations = $this->handleTypeTime($type);
        $limit = [];
        $conditions = [
            "order_status : 4",
            "shop_orders.created_at >= ".$durations['firstDayOrCurrent'],
            "shop_orders.created_at <= ".$durations['lastDayOrCurrent']
        ];

        $topSells = $this->orderRepo->getTopSell($conditions, [], $limit)->toArray();
        if (count($limit)) {
            $topSells = $topSells['data'];
        }

        $topSellsCalc = [];

        if (count($topSells)) {
            // handle calculate total money
            for ($i = 0; $i < count($topSells); $i++) {
                $topSells[$i]['total'] = $topSells[$i]['quantity']*$topSells[$i]['unit_price'] - $topSells[$i]['discount_amount'];
            }
            
            // handle duplicate products
            for ($i = 0; $i < count($topSells); $i++) {
                if (empty($topSells[$i]['product_option'])) {
                    if (empty($topSellsCalc[$topSells[$i]['id']])) {
                        $topSellsCalc[$topSells[$i]['id']] = $topSells[$i];
                    } else {
                        $topSellsCalc[$topSells[$i]['id']]['total'] += $topSells[$i]['total'];
                        $topSellsCalc[$topSells[$i]['id']]['quantity'] += $topSells[$i]['quantity'];
                    }
                } else {
                    if (empty($topSellsCalc[$topSells[$i]['product_option']])) {
                        $topSellsCalc[$topSells[$i]['product_option']] = $topSells[$i];
                    } else {
                        $topSellsCalc[$topSells[$i]['product_option']]['total'] += $topSells[$i]['total'];
                        $topSellsCalc[$topSells[$i]['product_option']]['quantity'] += $topSells[$i]['quantity'];
                    }
                }
            }

            // dd($topSellsCalc);
    
            // query option id
            foreach ($topSellsCalc as $key => $top) {
                if (!empty($top['product_option'])) {
                    $arrId = explode(',', $top['product_option']);
                    $strOption = [];
                    foreach ($arrId as $id) {
                        $option = $this->productOptionRepo->find($id)->detail;
                        array_push($strOption, $option);
                    }
                    $topSellsCalc[$key]['option'] = implode(' | ', $strOption); 
                } else {
                    $topSellsCalc[$key]['option'] = '';
                }
            }
    
            // handle sort top sells
            usort($topSellsCalc, function($a, $b){
                if ($a['quantity'] < $b['quantity']) return 1;
                if ($b['quantity'] < $a['quantity']) return -1;

                if ($a['total'] < $b['total']) return 1;
                if ($b['total'] < $a['total']) return -1;
    
                return 0;
            });
        }
        
        return $topSellsCalc;
    }

    public function statisticReportYear() {
        $firstDayOfYear = Carbon::now()->startOfYear()->toDateTimeString();
        $lastDayOfYear = Carbon::now()->endOfYear()->toDateTimeString();

        $conditions = [
            "created_at <= $lastDayOfYear",
            "created_at >= $firstDayOfYear"
        ];

        $customers = $this->customerRepo->findByField($conditions);
        
        $conditionsOrder = $conditions;
        array_push($conditionsOrder, "order_status : 4");
        $orders = $this->orderRepo->findByField($conditionsOrder);
        
        $orderIds = [];
        if (count($orders)) {
            foreach ($orders as $order) {
                array_push($orderIds, $order->id);
            }
        }
        $orderIds = implode(',', $orderIds);
        $conditionsOrderDetail = $conditions;
        foreach ($conditionsOrderDetail as $key => $value) {
            if (str_contains($value, 'created_at')) {
                $conditionsOrderDetail[$key] = 'shop_order_details.'.$value;
            }
        }
        array_push($conditionsOrderDetail, "order_id {in} $orderIds");
        $status = 4;
        $orderDetails = $this->orderDetailRepo->getAllOrderDetailCompleted($status, $conditionsOrderDetail)->toArray();

        $countCustomersByMonth = $this->countOrSum($customers);
        $countOrdersByMonth = $this->countOrSum($orders);
        $totalRevenueByMonth = $this->countOrSum($orderDetails, 'sum');
        return [
            'countCustomersByMonth' => $countCustomersByMonth,
            'countOrdersByMonth' => $countOrdersByMonth,
            'totalRevenueByMonth' => $totalRevenueByMonth
        ];
    }

    public function countOrSum($data, $type = "count") {
        if (count($data)) {
            $months = [
                "January", "February", "March", "April", "May", "June", 
                "July", "August", "September", "October", "November", "December"
            ];
            $current = Carbon::now();
            $year = $current->year;
            
            if ($type == "count") {
                $dataCountByMonth = [];
                foreach ($data as $value) {
                    foreach ($months as $m => $month) {
                        $firstDay = new Carbon("first day of $month $year");
                        $lastDay = new Carbon("last day of $month $year");
                        if (empty($dataCountByMonth[$m+1])) {
                            $dataCountByMonth[$m+1] = 0;
                        }
                        if ($value->created_at >= $firstDay->toDateTimeString() 
                            && $value->created_at <= $lastDay->toDateTimeString()) {
                            $dataCountByMonth[$m+1]++;
                        }
                    }
                }
                return implode(",", $dataCountByMonth);
            } else {
                $dataSumByMonth = [];
                foreach ($data as $value) {
                    foreach ($months as $m => $month) {
                        $firstDay = new Carbon("first day of $month $year");
                        $lastDay = new Carbon("last day of $month $year");
                        if (empty($dataSumByMonth[$m+1])) {
                            $dataSumByMonth[$m+1] = 0;
                        }
                        if ($value['created_at'] >= $firstDay->toDateTimeString() 
                            && $value['created_at'] <= $lastDay->toDateTimeString()) {
                            $dataSumByMonth[$m+1] += $value['total']*$value['unit_price'] - $value['discount_amount'];
                        }
                    }
                }
                return implode(",",$dataSumByMonth);
            }
        }
    }

    private function handleTypeTime($type) {
        if ($type === 'Tháng này') {
            $current = Carbon::now();
            $prev = Carbon::now()->subMonths(1);
            $curMonthName = $current->format('F');  
            $prevMonthName = $prev->format('F');
            $year = $current->year;
            $firstDayOrCurrent = new Carbon("first day of $curMonthName $year");
            $lastDayOrCurrent = new Carbon("last day of $curMonthName $year");
            $firstDayOfPrevious = new Carbon("first day of $prevMonthName $year");
            $lastDayOfPrevious = new Carbon("last day of $prevMonthName $year");
        }
        if ($type === 'Năm nay') {
            $firstDayOrCurrent = Carbon::now()->startOfYear();
            $lastDayOrCurrent = Carbon::now()->endOfYear();
            $firstDayOfPrevious = Carbon::now()->subYears(1)->startOfYear();
            $lastDayOfPrevious = Carbon::now()->subYears(1)->endOfYear();
        }

        return [
            "firstDayOrCurrent" => $firstDayOrCurrent->toDateTimeString(),
            "lastDayOrCurrent" => $lastDayOrCurrent->toDateTimeString(),
            "firstDayOfPrevious" => $firstDayOfPrevious->toDateTimeString(),
            "lastDayOfPrevious" => $lastDayOfPrevious->toDateTimeString(),
            "type" => $type
        ];
    }
}