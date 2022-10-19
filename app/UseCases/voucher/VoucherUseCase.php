<?php

namespace App\UseCases\Voucher;
use App\Models\Voucher;
use App\UseCases\UseCaseInterface;
use App\UseCases\Pagination;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\CustomerVoucher\CustomerVoucherRepositoryInterface;


class VoucherUseCase implements UseCaseInterface
{
    private $voucherRepo;
    private $customerVoucherRepo;
 

    public function __construct(
        VoucherRepositoryInterface $voucherRepo,
        CustomerVoucherRepositoryInterface $customerVoucherRepo
    ) {
        $this->voucherRepo = $voucherRepo;
        $this->customerVoucherRepo = $customerVoucherRepo;
    }

    public function getVoucherBySlug($slug) {
        return $this->voucherRepo->findByFieldVersionOld(['voucher_slug: '. $slug],'', '', true);
    }

    public function getAllVoucher($code){
        return $this->voucherRepo->findByFieldVersionOld([],'', '', true);
    }

    public function validateVoucher($res) {
        if(!array_key_exists('voucher_code', $res) || !array_key_exists('customer_id', $res)) {
            return [
                'error' => 'Đã có lỗi xảy ra'
            ];
        }
        
        $voucher = $this->voucherRepo->findByFieldVersionOld(['voucher_code: '. $res['voucher_code']],'', '', true);
        
        if(empty($voucher)){
            return [
                'error' => 'Không tìm thấy voucher'
            ];
        }

        $voucher = $voucher[0];

        $start = strtotime(date('Y-m-d H:i:s'));
        $end = strtotime($voucher['end_date']);

        $time = intval($end - $start);

        $time_start = intval(strtotime($voucher['start_date']) - $start);

        if($time_start > 0) {
            return [
                'error' => 'Voucher chưa có hiệu lực trong khoảng thời gian này!!'
            ];
        }

        if($time <= 0) {
            return [
                'error' => 'Mã voucher đã hết hạn!!'
            ];
        }

        if($voucher['max_uses'] == $voucher['uses']) {
            return [
                'error' => 'Mã voucher đã hết!!'
            ];
        }
   
        $customerVoucher = $this->customerVoucherRepo->findByFieldVersionOld(['voucher_id : '. $voucher['id'], 'customer_id : '. $res['customer_id']], '', '', true);
      
        if(count($customerVoucher) >= $voucher['max_uses_user']) {
            return [
                'error' => 'Người dùng đã sử dụng tối đa lượt cho phép!!'
            ];
        }
        $voucher['uses'] += 1;

        $this->voucherRepo->update($voucher['id'], $voucher);
        $this->customerVoucherRepo->create(['customer_id' => $res['customer_id'], 'voucher_id' => $voucher['id']]);

        return $voucher;

    }

   

    public function getAllByCondition($pagination = [], $sort = [], $filter = [], $search = null)
    {
     
    }


    public function getAll()
    {
        return $this->voucherRepo->findByFieldVersionOld ([], $orderBy = '', $limit = '', true);
    }

    public function find($id)
    {
       
    }

    

    public function create($attributes = [])
    {
        return $this->voucherRepo->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        return $this->voucherRepo->update($id, $attributes);
    }


    public function delete($id) {
        return $this->voucherRepo->delete($id);
    }
}
