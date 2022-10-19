<?php
namespace App\Repositories\Category;

use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function getAllCategories()
    {
        $field = ['id', 'category_name', 'category_slug', 'status', 'image', 'parent_id'];

        return $this->model->get($field);
    }

    public function findCategory($id)
    {
        $field = ['id', 'category_name', 'image', 'parent_id'];
        return $this->model->find($id, $field);
    }
}