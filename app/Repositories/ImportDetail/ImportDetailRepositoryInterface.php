<?php
namespace App\Repositories\ImportDetail;

use App\Repositories\RepositoryInterface;

interface ImportDetailRepositoryInterface extends RepositoryInterface
{
    public function getImportDetail($id);
    public function getAllImportDetail();
    public function getAllImportDetailByProduct($id, $option);
}