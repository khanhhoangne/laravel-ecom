<?php

namespace App\Http\Livewire\Payments;

use App\UseCases\PaymentType\PaymentTypeUseCase;
use Illuminate\Support\Facades\Config;
use Livewire\WithPagination;
use Livewire\Component;

class AdminPaymentComponent extends Component
{
    use WithPagination;

    protected $listeners = ['delete' => 'deletePayment'];
    private $paymentTypeUseCase;
    public $paymentTypes;

    public function boot(
        PaymentTypeUseCase $paymentTypeUseCase,
    ) {
        $this->paymentTypeUseCase = $paymentTypeUseCase;
        $this->paymentTypes = $this->paymentTypeUseCase->getAll();
    }  

    public function render()
    {
        $pageTitle = 'Danh sách phương thức thanh toán';

        return view('livewire.payments.admin-payment-component', [
            'payments' => $this->paymentTypes,
        ])->layout('layouts.base', [
            'pageTitle' => $pageTitle,
             'account' =>  Config::get('user'),
            'commandsOfUser' => Config::get('commands'),
            'permissionsOfUser' => Config::get('permissions')
        ]);
    }

    public function deleteConfirm($id) {
        $this->dispatchBrowserEvent('swal:confirmDelete', [
            'type' => 'warning',
            'title' => 'Bạn có chắc chắn muốn xóa?',
            'text' => '',
            'id' => $id,
        ]);
    }

    public function deletePayment($id) {
        $this->paymentTypeUseCase->delete($id);

        $this->paymentTypes = $this->paymentTypeUseCase->getAll();
    }
}
