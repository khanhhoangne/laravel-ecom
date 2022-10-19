<?php

namespace App\UseCases\BlogCategory;

use App\UseCases\UseCaseInterface;
use App\Repositories\BlogCategory\BlogCategoryRepositoryInterface;

class BlogCategoryUseCase implements UseCaseInterface {

    protected $blogCategoryRepo;

    public function __construct(BlogCategoryRepositoryInterface $blogCategoryRepo)
    {
        $this->blogCategoryRepo = $blogCategoryRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->blogCategoryRepo->getAllBlogCategory();
    }

    public function find($id) {

    }

    public function create($attributes = []) {

    }

    public function update($id, $attributes = []) {

    }
}