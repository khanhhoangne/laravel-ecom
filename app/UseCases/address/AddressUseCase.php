<?php

namespace App\UseCases\Address;

use App\UseCases\UseCaseInterface;
use App\Repositories\Address\AddressRepositoryInterface;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AddressUseCase implements UseCaseInterface {

    protected $addressRepo;

    public function __construct(AddressRepositoryInterface $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAddressByUserId($customer_id) {
        return $this->addressRepo->findByField(["customer_id : $customer_id"]);
    }

    public function getAddressDefaultByUserId() {
        $customer = JWTAuth::User();
        return $this->addressRepo->findOne(["customer_id" => $customer->id, "is_default" => 1]);
    }

    public function getAll() {
        return $this->addressRepo->getAll();
    }

    public function find($id) {

    }

    public function create($attributes = []) {
        $id = $attributes['id'];
        $defaultAddress = $this->addressRepo->findOne(["customer_id" => $id, "is_default" => true]);
        unset($attributes['id']);
        if (empty($defaultAddress)) {
            $attributes['is_default'] = true;
        }

        return $this->addressRepo->create($attributes);
    }

    public function update($id, $attributes = []) {
        return $this->addressRepo->update($id, $attributes);
    }

    public function setDefault($id) {
        $address = $this->addressRepo->find($id);
        if (empty($address)) {
            throw new Exception('Address not found by ID ' . $id, 400);
        }
        $customer = JWTAuth::User();
        $conditions = ["customer_id : $customer->id"];
        $fieldAllows = [];
        $attributes = ['is_default' => false];
        $this->addressRepo->updateMany($conditions, $fieldAllows, $attributes);
        
        $setDefault = $this->addressRepo->update($id, ['is_default' => true]);

        return $setDefault;
    }

    public function delete($id) {
        $address = $this->addressRepo->find($id);
        if (empty($address)) {
            throw new Exception('Address not found by ID ' . $id, 400);
        }
        $customer = JWTAuth::User();
        if ($customer->id !== $address->customer_id) {
            throw new Exception('You can not delete this address', 400);
        }
        if ($address->is_default === 1) {
            $newDefaultAddress = $this->addressRepo->findByField([
                "id != $address->id",
                "customer_id : $customer->id"
            ]);
            if (!empty($newDefaultAddress->toArray())){
                $addressDefault = $newDefaultAddress->toArray()[0];
                $this->update($addressDefault->id, [
                    "is_default" => true
                ]);
            }
        }
        return $this->addressRepo->delete($id);
    }
}