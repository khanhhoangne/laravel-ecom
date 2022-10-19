<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\PaymentType\PaymentTypeUseCase;

class PaymentTypeController extends Controller
{
    protected $PaymentTypeUseCase;

    public function __construct(PaymentTypeUseCase $PaymentTypeUseCase)
    {
        $this->PaymentTypeUseCase = $PaymentTypeUseCase;
    }

    public function index()
    {
        $payments = $this->PaymentTypeUseCase->getAll();
        
        return [
            'code' => 200,
            'message' => 'Success',
            'data' => $payments
        ];
    }

    public function show($id)
    {
        $PaymentType = $this->PaymentTypeUseCase->find($id);

        return view('home.PaymentType', ['PaymentType' => $PaymentType]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $PaymentType = $this->PaymentTypeUseCase->create($data);

        return view('home.payments');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $PaymentType = $this->PaymentTypeUseCase->update($id, $data);

        return view('home.payments');
    }

    public function destroy($id)
    {
        // $this->PaymentTypeUseCase->delete($id);
        
        return view('home.PaymentTypes');
    }
}