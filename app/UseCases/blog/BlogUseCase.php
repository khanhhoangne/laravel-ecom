<?php

namespace App\UseCases\Blog;

use App\UseCases\UseCaseInterface;
use App\Repositories\Blog\BlogRepositoryInterface;

class BlogUseCase implements UseCaseInterface {

    protected $blogRepo;

    public function __construct(BlogRepositoryInterface $blogRepo)
    {
        $this->blogRepo = $blogRepo;
    }

    public function getAllByCondition($query = []) {
        $conditions = [];
        $limit = [];
        $orderBy = [];
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }
        if (!empty($query['pagination'])) {
            $limit = $query['pagination'];
        }
        if (!empty($query['orderBy'])) {
            $orderBy = $query['orderBy'];
        }
        $fieldAllows = [
            "title", "status", "author", 
            "view", "created_at", "id"
        ];

        $result = $this->blogRepo->findByField($conditions, $orderBy, $fieldAllows, $limit);
        // sử dụng khi dùng với middleware handle-query
        if (!empty($result->toArray())) {
            $result->appends([
                'orderBy' => null, 
                'pagination' => null, 
                'conditions' => null
            ]);
        }
        return $result;
    }

    public function getBlogsByCategoryId($id, $query = []) {
        $conditions = [];
        $limit = [];
        $orderBy = [];
        if (!empty($query['conditions'])) {
            $conditions = $query['conditions'];
        }
        if (!empty($query['pagination'])) {
            $limit = $query['pagination'];
        }
        if (!empty($query['orderBy'])) {
            $orderBy = $query['orderBy'];
        }
        $fieldAllows = [
            "title", "status", "author", 
            "view", "created_at", "id"
        ];

        $result = $this->blogRepo->getBlogsByCategoryId($id, $conditions, $orderBy, $fieldAllows, $limit);
        // sử dụng khi dùng với middleware handle-query
        if (!empty($result->toArray())) {
            $result->appends([
                'orderBy' => null, 
                'pagination' => null, 
                'conditions' => null
            ]);
        }
        return $result;
    }

    public function getAll() {
        return $this->blogRepo->getAll();
    }

    public function find($id) {
        return $this->blogRepo->findOne(["id" => $id, "status" => 1]);
    }

    public function create($attributes = []) {

    }

    public function update($id, $attributes = []) {

    }
}