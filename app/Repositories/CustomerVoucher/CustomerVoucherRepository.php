<?php
namespace App\Repositories\CustomerVoucher;

use App\Repositories\BaseRepository;

class CustomerVoucherRepository extends BaseRepository implements CustomerVoucherRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\CustomerVoucher::class;
    }
}