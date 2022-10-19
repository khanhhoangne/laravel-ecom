<?php

namespace App\Http\Livewire\Vouchers;

use App\UseCases\Voucher\VoucherUseCase;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class AdminAddVoucherComponent extends Component
{
    public $voucher_code;
    public $voucher_name;
    public $voucher_des;
    public $voucher_price;
    public $voucher_max_uses;
    public $voucher_date_begin;
    public $voucher_date_end;
    public $voucher_type = 'Money';
    public $voucher_slug;
    public $voucher_max_uses_user;
    private $voucherUseCase;



    protected $rules = [
        'voucher_code' => 'required|unique:shop_vouchers',
        'voucher_name' => 'required|unique:shop_vouchers',
        'voucher_des' => 'required',
        'voucher_max_uses' => 'required',
        'voucher_type' => 'required',
        'voucher_date_begin' => 'required',
        'voucher_date_end' => 'required',
        'voucher_price' => 'required',
        'voucher_slug' => 'required|unique:shop_vouchers',
        'voucher_max_uses_user' => 'required'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];

    protected $validationAttributes = [
        'voucher_code' => 'Mã giảm giá',
        'voucher_name' => 'Tên giảm giá',
        'voucher_des' => 'Mô tả',
        'voucher_max_uses' => 'Mục này',
        'voucher_type' => 'Mục này',
        'voucher_date_begin' => 'Ngày bắt đầu',
        'voucher_date_end' => 'Ngày kết thúc',
        'voucher_price' => 'Mục này',
        'voucher_slug' => 'Mục này',
        'voucher_max_uses_user' =>  'Mục này'
    ];

    public function boot(
        VoucherUseCase $voucherUseCase,
    ) {
        $this->voucherUseCase = $voucherUseCase;
    }  

    public function generateSlug() {
        $this->voucher_slug = Str::slug($this->voucher_name);
    }

    public function storeVoucher() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $voucher = [
            'voucher_code' => $this->voucher_code,
            'voucher_name' => $this->voucher_name,
            'voucher_slug' => $this->voucher_slug,
            'description'  => $this->voucher_des,
            'discount_value' => $this->voucher_price,
            'max_uses'=> $this->voucher_max_uses,
            'start_date' => $this->voucher_date_begin,
            'end_date'   => $this->voucher_date_end,
            'voucher_type' => $this->voucher_type,
            'max_uses_user' => $this->voucher_max_uses_user
        ];

        $this->voucherUseCase->create($voucher);
        $this->reset();

        

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm mã khuyến mãi thành công!',
            'text' => ''
        ]);
    }
 

    public function render()
    {
        $pageTitle = 'Quản lý mã giảm giá';

        return view('livewire.vouchers.admin-add-voucher-component')
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
