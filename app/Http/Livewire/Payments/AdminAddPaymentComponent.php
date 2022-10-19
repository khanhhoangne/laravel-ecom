<?php

namespace App\Http\Livewire\Payments;

use App\UseCases\PaymentType\PaymentTypeUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Component;

class AdminAddPaymentComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $payment_name;
    public $payment_slug;
    public $image;
    public $description;

    public $payment_id;

    private $paymentTypeUseCase;

    protected $rules = [
        'payment_name' => 'required',
        'payment_slug' => 'required|unique:shop_payment_types'
    ];
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'payment_name' => 'Tên phương thức thanh toán',
        'payment_slug' => 'Liên kết tĩnh'
    ];

    public function boot(
        PaymentTypeUseCase $paymentTypeUseCase,
    ) {
        $this->paymentTypeUseCase = $paymentTypeUseCase;
    }  

    public function generateslug() {
        $this->payment_slug = Str::slug($this->payment_name);
    }

    public function updated($fields) {   
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function storePayment() {   
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $payment = [
            'payment_name' => $this->payment_name,
            'payment_slug' => $this->payment_slug,
            'description' => $this->description,
            'image' => $this->image,
        ];

        $this->paymentTypeUseCase->create($payment);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Thêm phương thức thanh toán thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('payments');
    }

    public function render()
    {
        $pageTitle = 'Thêm mới phương thức thanh toán';

        return view('livewire.payments.admin-add-payment-component')->layout('layouts.base',[
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
