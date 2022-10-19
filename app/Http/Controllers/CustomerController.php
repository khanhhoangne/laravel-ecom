<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Http\Requests\RegisterRequest;
use App\UseCases\Customer\CustomerUseCase;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CustomerController extends Controller 
{
    protected $customerUseCase;

    public function __construct(CustomerUseCase $customerUseCase)
    {
        $this->customerUseCase = $customerUseCase;
    }
    
    public function export(CustomersExport $export) 
    {
        return Excel::download($export, 'customers.xlsx');
    }

    public function register(RegisterRequest $request){
        $attributes = [
            'fullname' => $request->get('fullname'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ];

        $customer = $this->customerUseCase->create($attributes);

        return response()->json([
            'status'=> 200,
            'message'=> 'customer created successfully',
            'data'=> new CustomerResource($customer)
        ]);
    }

    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json([
            "code" => 200,
            "message" => "customer login successfully",
            compact('token')    
        ]);
    }

    public function loginOrRegisterByGoogle(Request $request) {
        $customer = Customer::where(['email' => $request->get('email')])->first();
        if (empty($customer)) {
            $attributes = [
                'fullname' => $request->get('fullName'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('googleId'))
            ];

            $customer = $this->customerUseCase->create($attributes);
        }
        $token = null;
        try {
            if (!$token = JWTAuth::fromUser($customer)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        
        return response()->json([
            'status'=> 200,
            'message'=> "customer login successfully",
            compact('token')    
        ]);
    }

    public function show()
    {
        $customer = JWTAuth::User();

        return [
            "code" => 200,
            "message" => "Success",
            "data" => new CustomerResource($customer)
        ];
    }

    public function update(Request $request)
    {
        $avatar = $request->file('avatar');
        $id = $request->input('id');
        $attributes = $request->all();

        $customer = $this->customerUseCase->update($id, $attributes, $avatar);

        return [
            "code" => 200,
            "message" => "Success",
            "data" => new CustomerResource($customer)
        ];
    }
}