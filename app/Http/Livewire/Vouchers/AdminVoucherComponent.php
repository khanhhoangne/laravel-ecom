<?php

namespace App\Http\Livewire\Vouchers;

use Livewire\Component;
use App\UseCases\Voucher\VoucherUseCase;
use Illuminate\Support\Facades\Config;

class AdminVoucherComponent extends Component
{
    private $voucherUseCase;
    public $vouchers;
    public $time;

   

    public function boot(
        VoucherUseCase $voucherUseCase,
    ) {
        $this->voucherUseCase = $voucherUseCase;

        $this->vouchers = $this->voucherUseCase->getAll();
        $this->timeExpired($this->vouchers);
    } 

    public function timeExpired(array $vouchers){
        foreach ($vouchers as $key => $voucher) {
            $this->vouchers[$key]['is_expired'] = false;
            $start = strtotime(date('Y-m-d H:i:s'));
            $end = strtotime($voucher['end_date']);

            $time = intval($end - $start);
            if($time <= 0) {
                $this->vouchers[$key]['is_expired'] = true;
            }
            
        }
    }

    public function removeItem($id) {
        $this->voucherUseCase->delete($id);
        $this->dispatchBrowserEvent('alert', 
            ['type' => 'success',  'message' => 'Xóa dữ liệu thành công!']);
        $this->vouchers = $this->voucherUseCase->getAll();
    }

    public function render()
    {
        $pageTitle = 'Quản lý mã giảm giá';

        return view('livewire.vouchers.admin-voucher-component')
            ->layout(
                'layouts.base',
                [
                    'pageTitle' => $pageTitle,
                    'commandsOfUser' => Config::get('commands'),
                    'account' =>  Config::get('user'),
                ]
            );
    }
}
