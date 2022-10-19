<?php
namespace App\Repositories\ProductOption;

use App\Repositories\RepositoryInterface;

interface ProductOptionRepositoryInterface extends RepositoryInterface
{
    public function getLastIndex();
}