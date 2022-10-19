<?php
namespace App\Repositories\BlogCategory;

use App\Repositories\BaseRepository;

class BlogCategoryRepository extends BaseRepository implements BlogCategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\BlogCategory::class;
    }

    public function getAllBlogCategory()
    {
        $field = ['id', 'name', 'slug', 'banner', 'parent_id'];

        return $this->model->where('status', 1)->get($field);
    }
}