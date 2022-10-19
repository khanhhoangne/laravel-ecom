<?php
namespace App\Repositories\Customer;

use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Customer::class;
    }

    public function getAllCustomers($pagination = [], $sortBy = [], $filter = [], $search = null)
    {
        $prepare_query =  $this->model->select('shop_customers.id', 'shop_customers.fullname', 
        'shop_customers.email', 'shop_customers.gender', 'shop_customers.birthday', 'shop_customers.avatar',
        'shop_customers.phone','shop_customers.status', 'shop_customer_address.address', 
        'shop_customer_address.is_default')
            ->leftjoin('shop_customer_address', 'shop_customer_address.customer_id', '=', 'shop_customers.id')
            ->where('shop_customer_address.is_default', '=', 1)
            ->orWhere('shop_customer_address.is_default', '=', null);

        if (!empty($filter)) {
            foreach ($filter as $field => $value) {
                $prepare_query->where($field, '=', $value);
            }
        }
        
        if (!empty($search)) {
            $prepare_query->where('fullname', 'like', "{$search}%");
        }

        if (!empty($sortBy)) {
            foreach ($sortBy as $item) {
                $prepare_query->orderBy($item[0], $item[1]);
            }
        }

        if (!empty($pagination)) {
            $totalItem = $prepare_query->count();
    
            $pageCount = ceil($totalItem/$pagination['take']);
    
            $prepare_query->skip($pagination['take'] * ($pagination['page']-1))->take($pagination['take']);
        }

        $data = $prepare_query->get();
        
        if (empty($pagination)) {
            return $data;
        }

        return [
            "pagination" => [
                'pageCount' => intval($pageCount),
                'curPage' => intval($pagination['page']),
                'itemCount' => intval($pagination['take']),
            ],
            'elements' => $data
        ];
    }

    // public function getAllCustomers($pagination = [], $sortBy = [])
    // {
    //     return $this->model->select('shop_customers.fullname', 'shop_customers.gender', 
    //     'shop_customers.email', 'shop_customers.id', 'shop_customers.birthday', 'shop_customers.avatar',
    //     'shop_customers.phone','shop_customers.status', 'shop_customer_address.address', 
    //     'shop_customer_address.is_default')
    //         ->leftjoin('shop_customer_address', 'shop_customer_address.customer_id', '=', 'shop_customers.id')
    //         ->where('shop_customer_address.is_default', '=', 1)
    //         ->orWhere('shop_customer_address.is_default', '=', null)
    //         ->paginate($pagination['take']);
    // }
}