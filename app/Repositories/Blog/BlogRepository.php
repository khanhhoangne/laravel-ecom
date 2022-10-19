<?php
namespace App\Repositories\Blog;

use App\Repositories\BaseRepository;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Blog::class;
    }

    public function getBlogsByCategoryId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = [])
    {
        $prepare_query = $this->model->select("tbl_blogs.id", "tbl_blogs.title", 
        "tbl_blogs.slug", "tbl_blogs.subtitle", "tbl_blogs.thumbnail", 
        "tbl_blogs.author", "tbl_blogs.view", "tbl_blogs.created_at")
            ->join("tbl_blogs_details", "tbl_blogs_details.blog_id", "=", "tbl_blogs.id")
            ->where("tbl_blogs.status", "=", 1)
            ->where("tbl_blogs_details.cate_id", "=", $id);

        $this->handleConditions($conditions, $fieldAllows, $prepare_query);

        $this->handleOrderBy($orderBy, $fieldAllows, $prepare_query);

        return $this->handleLimit($limit, $prepare_query);
    }
}