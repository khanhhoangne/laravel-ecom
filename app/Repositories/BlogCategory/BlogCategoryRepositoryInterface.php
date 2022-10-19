<?php
namespace App\Repositories\BlogCategory;

use App\Repositories\RepositoryInterface;

interface BlogCategoryRepositoryInterface extends RepositoryInterface
{
    public function getAllBlogCategory();
}