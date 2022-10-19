<?php
namespace App\Repositories\Import;

use App\Repositories\RepositoryInterface;

interface ImportRepositoryInterface extends RepositoryInterface
{
    public function getLastIndex();
    public function getAllImport($date, $sort, $by);
}