<?php

namespace App\UseCases\OrderDetail;

use App\UseCases\UseCaseInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;


class OrderDetailUseCase implements UseCaseInterface {

    protected $orderDetailRepo;

    public function __construct(OrderDetailRepositoryInterface $orderDetailRepo)
    {
        $this->orderDetailRepo = $orderDetailRepo;
    }

    public function getAllByCondition($query = []) {
        
    }

    public function getAll() {}

    public function find($id) {
        return $this->orderDetailRepo->find($id);
    }

    public function create($attributes = []) {
        $this->orderDetailRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        $this->orderDetailRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->orderDetailRepo->delete($id);
    }

}