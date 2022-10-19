<?php

namespace App\Http\Livewire\Vouchers;

use Livewire\Component;
use Illuminate\Http\Request;
use App\UseCases\Voucher\VoucherUseCase;
use Illuminate\Support\Facades\Config;

class AdminEditVoucherComponent extends Component
{
    private $voucherUseCase;
    public $voucher;
    public $voucher_code;
    public $voucher_name;
    public $voucher_des;
    public $voucher_price;
    public $voucher_max_uses;
    public $voucher_date_begin;
    public $voucher_date_end;
    public $voucher_type;
    public $voucher_slug;
    public $voucher_max_uses_user;




    protected $rules;
 
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

    public function mount(Request $request) {
        $slug = $request['voucher_slug'];
        $this->voucher = $this->voucherUseCase->getVoucherBySlug($slug)[0];
        $this->voucher_id = $this->voucher['id'];
      
        $this->voucher_type = $this->voucher['voucher_type'];
        $this->voucher_code = $this->voucher['voucher_code'];
        $this->voucher_name = $this->voucher['voucher_name'];
        $this->voucher_des = $this->voucher['description'];
        $this->voucher_price = $this->voucher['discount_value'];
        $this->voucher_max_uses = $this->voucher['max_uses'];
        $this->voucher_max_uses_user = $this->voucher['max_uses_user'];
        $this->voucher_date_begin = explode(' ', $this->voucher['start_date'])[0];
        $this->voucher_date_end = explode(' ', $this->voucher['end_date'])[0];
    }
    
    public function setRules() {
        return [
            'voucher_code' => 'required|unique:shop_vouchers,voucher_code,'.$this->voucher_id,
            'voucher_name' => 'required|unique:shop_vouchers,voucher_name,'.$this->voucher_id,
            'voucher_des' => 'required',
            'voucher_max_uses' => 'required',
            'voucher_type' => 'required',
            'voucher_date_begin' => 'required',
            'voucher_date_end' => 'required',
            'voucher_price' => 'required',
            'voucher_slug' => 'required|unique:shop_vouchers,voucher_slug,'.$this->voucher_id,
            'voucher_max_uses_user' => 'required'
        ];
        // return [
        //     'payment_name' => 'required',
        //     'payment_slug' => 'required|unique:shop_payment_types,payment_slug,' . $this->payment_id,
        // ];
    }

    // public function updated($fields) {   
    //     $this->rules = $this->setRules();
    //     $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    // }

    public function storeVoucher() {   
        $this->rules = $this->setRules();
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

        $this->voucherUseCase->update($this->voucher_id ,$voucher);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật mã khuyến mãi thành công!',
            'text' => ''
        ]);

    }

    public function render()
    {
        $pageTitle = 'Quản lý kho hàng';

       
        return view('livewire.vouchers.admin-edit-voucher-component')
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
