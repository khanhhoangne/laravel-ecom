<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getOrderDetail($id);
    public function getAllOrder($conditions = [], $orderBy = [], $fieldAllows = [], $limit = []);
    public function getLastIndex();
    public function getOrderExported();
    public function getOrdersByCustomerId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = []);
    public function getTopSell($conditions = [], $fieldAllows = [], $limit = []); 
}