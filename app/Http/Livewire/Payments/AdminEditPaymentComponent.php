<?php

namespace App\Http\Livewire\Payments;

use App\UseCases\PaymentType\PaymentTypeUseCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Component;

class AdminEditPaymentComponent extends Component
{
    use WithFileUploads;
    protected $listeners = ['redirect' => 'redirectToListView'];

    public $payment_name;
    public $payment_slug;
    public $image;
    public $description;

    public $newImage;
    public $payment_id;

    protected $rules = [];

    private $paymentTypeUseCase;
 
    protected $messages = [
        'required' => ':attribute không được để trống.',
        'unique' => ':attribute này đã tồn tại. Vui lòng nhập lại.'
    ];
 
    protected $validationAttributes = [
        'payment_name' => 'Tên phương thức thanh toán',
        'payment_slug' => 'Liên kết tĩnh'
    ];

    public function setRules() {
        return [
            'payment_name' => 'required',
            'payment_slug' => 'required|unique:shop_payment_types,payment_slug,' . $this->payment_id,
        ];
    }

    public function boot(
        PaymentTypeUseCase $paymentTypeUseCase,
    ) {
        $this->paymentTypeUseCase = $paymentTypeUseCase;
    }  

    public function mount($paymenttype_slug) {
        $payment = $this->paymentTypeUseCase->getPayment(['payment_slug' => $paymenttype_slug]);

        $this->payment_id = $payment->id;
        $this->payment_name = $payment->payment_name;
        $this->payment_slug = $payment->payment_slug;
        $this->image = $payment->image;
        $this->description = $payment->description;
    }

    public function generateslug() {
        $this->payment_slug = Str::slug($this->payment_name);
    }

    public function updated($fields) {   
        $this->rules = $this->setRules();
        $this->validateOnly($fields, $this->rules, $this->messages, $this->validationAttributes);
    }

    public function updatePayment() {  
        $this->rules = $this->setRules();
        $this->validate($this->rules, $this->messages, $this->validationAttributes);

        $payment = [
            'payment_name' => $this->payment_name,
            'payment_slug' => $this->payment_slug,
            'description' => $this->description,
            'image' => $this->image,
        ];

        $this->paymentTypeUseCase->update($this->payment_id, $payment, $this->newImage);

        $this->dispatchBrowserEvent('swal:saveSuccess', [
            'type' => 'success',
            'title' => 'Cập nhật danh mục thành công!',
            'text' => ''
        ]);
    }

    public function redirectToListView() {
        return redirect()->route('payments');
    }

    public function render()
    {
        $pageTitle = 'Cập nhật phương thức thanh toán';

        return view('livewire.payments.admin-edit-payment-component')->layout('layouts.base', [
            'pageTitle' => $pageTitle,
            'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }
}
