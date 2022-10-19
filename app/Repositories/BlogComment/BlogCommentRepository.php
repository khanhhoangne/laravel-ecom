<?php
namespace App\Repositories\BlogComment;

use App\Repositories\BaseRepository;

class BlogCommentRepository extends BaseRepository implements BlogCommentRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\BlogComment::class;
    }

    public function getAllBlogComment()
    {
        $field = ['id', 'name', 'slug', 'banner', 'parent_id'];

        return $this->model->where('status', 1)->get($field);
    }
    
    public function getCommentsByBlogId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = []) {
        $prepare_query = $this->model->select("tbl_blogs_comments.id", "tbl_blogs_comments.content", 
        "tbl_blogs_comments.created_at", 'shop_customers.fullname', 'shop_customers.avatar')
            ->join("shop_customers", "shop_customers.id", "=", "tbl_blogs_comments.customer_id")
            ->where("tbl_blogs_comments.comment_status", "=", 1)
            ->where("tbl_blogs_comments.blog_id", "=", $id)
            ->where("tbl_blogs_comments.parent_id", "=", null);

        $this->handleConditions($conditions, $fieldAllows, $prepare_query);

        $this->handleOrderBy($orderBy, $fieldAllows, $prepare_query);

        return $this->handleLimit($limit, $prepare_query);
    }

    public function getCommentsByParentId($blog_id, $parent_id) {
        return $this->model->select("tbl_blogs_comments.id", "tbl_blogs_comments.content", 
        "tbl_blogs_comments.created_at", 'shop_customers.fullname', 'shop_customers.avatar')
            ->join("shop_customers", "shop_customers.id", "=", "tbl_blogs_comments.customer_id")
            ->where("tbl_blogs_comments.comment_status", "=", 1)
            ->where("tbl_blogs_comments.blog_id", "=", $blog_id)
            ->where("tbl_blogs_comments.parent_id", "=", $parent_id)->get();
    }
}