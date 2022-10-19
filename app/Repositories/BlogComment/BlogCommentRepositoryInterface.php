<?php
namespace App\Repositories\BlogComment;

use App\Repositories\RepositoryInterface;

interface BlogCommentRepositoryInterface extends RepositoryInterface
{
    public function getAllBlogComment();
    public function getCommentsByBlogId($id, $conditions = [], $orderBy = [], $fieldAllows = [], $limit = []);
    public function getCommentsByParentId($blog_id, $parent_id);
}