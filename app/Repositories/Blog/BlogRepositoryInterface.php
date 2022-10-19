<?php
namespace App\Repositories\Blog;

use App\Repositories\RepositoryInterface;

interface BlogRepositoryInterface extends RepositoryInterface
{
    public function getBlogsByCategoryId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = []);
}