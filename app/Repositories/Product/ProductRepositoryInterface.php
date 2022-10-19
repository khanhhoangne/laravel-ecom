<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getProduct();
    public function getProductGalleryById($id);
    public function getProductDiscountById($id);
    public function getProductById($id);
    public function getLastIndex();
}