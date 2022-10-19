<?php
namespace App\Repositories\ProductReview;

use App\Repositories\BaseRepository;

class ProductReviewRepository extends BaseRepository implements ProductReviewRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\ProductReview::class;
    }

    public function getReviews($id, $offset, $take) {
        return $this->model->select('shop_customers.fullname', 'shop_customers.avatar','shop_product_reviews.comment', 'shop_product_reviews.rating', 'shop_product_reviews.status')
            ->join('shop_customers', 'shop_product_reviews.customer_id', '=', 'shop_customers.id')
            ->where('shop_product_reviews.product_id', '=', $id)
            ->skip($offset)->take($take)
            ->orderBy('shop_product_reviews.created_at', 'desc')
            ->get()->toArray();
    }
}


