<?php

namespace App\Exports;

use App\Repositories\Customer\CustomerRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    } 

    public function collection()
    {
        return $this->customerRepo->getAllCustomers();
    }

    public function headings(): array
    {
        return [
            'id',
            'fullname',
            'email',
            'gender',
            'birthday',
            'avatar',
            'phone',
            'status',
            'address',
            'is_default',
        ];
    }
}