<?php
namespace App\Repositories\PaymentType;

use App\Repositories\BaseRepository;

class PaymentTypeRepository extends BaseRepository implements PaymentTypeRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\PaymentType::class;
    }

    public function getPaymentTypes()
    {
        return $this->model->select('payment_name', 'description', 'payment_slug', 'image', 'id')->get();
    }
}