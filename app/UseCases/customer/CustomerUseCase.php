<?php

namespace App\UseCases\Customer;

use App\UseCases\UseCaseInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\UseCases\Pagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CustomerUseCase implements UseCaseInterface {

    protected $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    } 

    public function getAll() {

    }

    public function getAllByCondition($pagination = [], $sortBy = [], $filter = [], $search = null) {
        $pagination = Pagination::paginate($pagination);
        $sort = Pagination::sort($sortBy);

        return $this->customerRepo->getAllCustomers($pagination, $sort, [], $search);
    }

    public function find($id) { 
        return $this->customerRepo->find($id);
    }

    public function create($attributes = []) {
        return $this->customerRepo->create($attributes);
    }

    public function update($id, $attributes = [], $image = null) {
        if (!empty($image)) {
            $imageName = "avatar" . Carbon::now()->timestamp . '.' .$image->extension();
            $image ->storeAs('public/uploads/customers', $imageName);
            
            $attributes['avatar'] = $imageName;
        }
        unset($attributes['id']);

        return $this->customerRepo->update($id, $attributes);
    }

    public function login($credentials = []) {
        $user = $this->customerRepo->findOne(['email' => $credentials['email']]);

        if (!$user) {
            return false;
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        return $user;
    }

    public function findByEmail($email) {
        return $this->customerRepo->findByField(["email : $email"]);
    }
}