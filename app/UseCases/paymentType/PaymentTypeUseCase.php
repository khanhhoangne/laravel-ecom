<?php

namespace App\UseCases\PaymentType;

use App\UseCases\UseCaseInterface;
use App\Repositories\PaymentType\PaymentTypeRepositoryInterface;
use Carbon\Carbon;

class PaymentTypeUseCase implements UseCaseInterface {

    protected $paymentTypeRepo;

    public function __construct(PaymentTypeRepositoryInterface $paymentTypeRepo)
    {
        $this->paymentTypeRepo = $paymentTypeRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->paymentTypeRepo->getPaymentTypes();
    }

    public function find($id) {
        return $this->paymentTypeRepo->find($id);
    }

    public function create($attributes = []) {
        $imageName = null;
        if (!empty($attributes['image'])) {
            $imageName = $attributes['payment_slug'] . Carbon::now()->timestamp . '.' .$attributes['image']->extension();
            $attributes['image']->storeAs('public/uploads/payments', $imageName);
        }
        $attributes['image'] = $imageName;

        $this->paymentTypeRepo->create($attributes);
    }

    public function update($id, $attributes = [], $newImage = null) {
        if (!empty($newImage)) {
            $imageName = $attributes['payment_slug'].Carbon::now()->timestamp. '.' .$newImage->extension();
            $newImage->storeAs('public/uploads/payments', $imageName);

            $attributes['image'] = $imageName;
        }

        $this->paymentTypeRepo->update($id, $attributes);
    }

    public function delete($id) {
        $this->paymentTypeRepo->delete($id);
    }

    public function getPayment($conditions = []) {
        return $this->paymentTypeRepo->findOne($conditions);
    }
}