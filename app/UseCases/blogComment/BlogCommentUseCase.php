<?php

namespace App\UseCases\BlogComment;

use App\UseCases\UseCaseInterface;
use App\Repositories\BlogComment\BlogCommentRepositoryInterface;

class BlogCommentUseCase implements UseCaseInterface {

    protected $blogCommentRepo;

    public function __construct(BlogCommentRepositoryInterface $blogCommentRepo)
    {
        $this->blogCommentRepo = $blogCommentRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        return $this->blogCommentRepo->getAll();
    }

    public function getCommentsByBlogId($id, $query = []) {
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
            "blog_id", "customer_id", "comment_status", 
            "parent_id", "created_at", "id"
        ];

        $result = $this->blogCommentRepo->getCommentsByBlogId($id, $conditions, $orderBy, $fieldAllows, $limit);

        if (!empty($result->toArray())) {
            $result->appends([
                'orderBy' => null, 
                'pagination' => null, 
                'conditions' => null
            ]);
        }
        return $result;
    }

    public function getCommentsByParentId($blog_id, $parent_id) {
        return $this->blogCommentRepo->getCommentsByParentId($blog_id, $parent_id);
    }

    public function find($id) {
        
    }

    public function create($attributes = []) {
        return $this->blogCommentRepo->create($attributes);
    }

    public function update($id, $attributes = []) {

    }
}