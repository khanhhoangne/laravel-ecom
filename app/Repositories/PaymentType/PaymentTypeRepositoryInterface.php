<?php
namespace App\Repositories\PaymentType;

use App\Repositories\RepositoryInterface;

interface PaymentTypeRepositoryInterface extends RepositoryInterface
{
    public function getPaymentTypes();
}