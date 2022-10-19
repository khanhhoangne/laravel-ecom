<?php
namespace App\Repositories\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function getProduct()
    {
        return $this->model->getFillable();
    }

    public function getProductGalleryById($id) {
        return $this->model->select(
            'shop_product_gallery.image',
        )
        ->join('shop_product_gallery', 'shop_product_gallery.product_id', '=', 'shop_products.id')
        ->where('shop_products.id', '=', $id)->get()->toArray();
    }

    public function getProductDiscountById($id) {
        return $this->model->select(
            'shop_product_discounts.discount_type', 'shop_product_discounts.discount_value', 'shop_product_discounts.is_flashsale', 'shop_product_discounts.start_date', 'shop_product_discounts.end_date'
        )
        ->join('shop_product_discounts', 'shop_product_discounts.product_id', '=', 'shop_products.id')
        ->where('shop_products.id', '=', $id)->get()->toArray();
    }   

    public function getProductById($id) {
        return $this->model->select(
            'shop_products.id','shop_products.product_name','shop_products.image','shop_products.short_description', 'shop_products.description', 'shop_products.is_continued', 'shop_products.is_featured', 'shop_products.is_new',
            'shop_suppliers.supplier_name',
            'shop_categories.category_name',
            'shop_categories.id as category_id'
        )
        ->join('shop_suppliers', 'shop_suppliers.id', '=', 'shop_products.supplier_id')
        ->join('shop_categories', 'shop_categories.id', '=', 'shop_products.category_id')
        ->where('shop_products.id', '=', $id)->get()->toArray();
    }

    public function getLastIndex() {
        return $this->model->orderBy('created_at', 'desc')->first();
    }
}


