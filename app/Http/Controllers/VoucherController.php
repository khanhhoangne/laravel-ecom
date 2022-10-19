<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Voucher\VoucherUseCase;

class VoucherController extends Controller
{
    protected $voucherUseCase;

    public function __construct(VoucherUseCase $voucherUseCase)
    {
        $this->voucherUseCase = $voucherUseCase;
    }

    public function index(Request $request)
    {
        try {   
            $vouchers = $this->voucherUseCase->getAllVoucher($request->all());

            if(!$vouchers) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            return response()->json(['code'=> 200, 'message' => 'success','data' => $vouchers], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {  
            $vouchers = $this->voucherUseCase->validateVoucher($request->all());

            if(!empty($vouchers['error'])) {
                return response()->json(['code'=> 400, 'message' => $vouchers['error']], 400);
            }
           
            return response()->json(['code'=> 201, 'message' => 'Recorded!', 'data' => $vouchers], 201);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

 
}
