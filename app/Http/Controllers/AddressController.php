<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\UseCases\Address\AddressUseCase;

class AddressController extends Controller
{
    protected $addressUseCase;

    public function __construct(AddressUseCase $addressUseCase)
    {
        $this->addressUseCase = $addressUseCase;
    }

    public function index()
    {
        
    }

    public function show($customer_id)
    {
        $addresses = $this->addressUseCase->getAddressByUserId($customer_id);

        return [
            "code" => 200,
            "message" => "success",
            "data" => $addresses
        ];
    }

    public function default()
    {
        $addresses = $this->addressUseCase->getAddressDefaultByUserId();

        return [
            "code" => 200,
            "message" => "success",
            "data" => $addresses
        ];
    }

    public function store(AddressRequest $request)
    {
        $data = $request->all();

        $address = $this->addressUseCase->create($data);

        return [
            "code" => 200,
            "message" => "Create new address successfully",
            "data" => $address
        ];
    }

    public function update(AddressRequest $request, $id)
    {
        $data = $request->all();
        unset($data['id']);

        $address = $this->addressUseCase->update($id, $data);

        return [
            "code" => 200,
            "message" => "Update address successfully",
            "data" => $address
        ];
    }

    public function setDefault($id) {
        try {
            $setDefault = $this->addressUseCase->setDefault($id);
    
            return [
                "code" => 200,
                "message" => "Set this address to be default successfully",
                "data" => $setDefault
            ];
        } catch (\Exception $e) {
            return response()->json(
                ['code' => $e->getCode(), 
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function destroy($id)
    {
        $this->addressUseCase->delete($id);

        return [
            "code" => 200,
            "message" => "Delete address successfully"
        ];
    }
}
