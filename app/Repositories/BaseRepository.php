<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements RepositoryInterface
{
    //model muốn tương tác
    protected $model;

   //khởi tạo
    public function __construct()
    {
        $this->setModel();
    }

    //lấy model tương ứng
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);

        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function updateMany($conditions = [], $fieldAllows = [], $attributes = []) {
        $table = $this->model->getTable();
        $query = DB::table($table);

        $this->handleConditions($conditions, $fieldAllows, $query);

        $query->update($attributes);

        return $query;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function removeByCondition($conditions = []) {
        $table = $this->model->getTable();
        $query = DB::table($table);

        if (!empty($conditions)) {
            foreach ($conditions as $field => $value) {
                $query->where($field, '=', $value);
            }
        }

        return $query->delete();
    }

    /**
     *  Lấy 1 bản ghi cho phép nhiều điều kiện
     *  Example: $findCate = $this->categoryRepo->findOne(['name' => 'Wolfhybrid', 'id' => 2]);
     */
    public function findOne($conditions = []) 
    {
        return $this->model->where($conditions)->first();
    }

    // lấy tất cả bản ghi cho phép nhiều điều kiện
    /**
     * Example: $products = $this->productRepo->findByField(["is_featured : Featured", "id >= 5"], "created_at : asc", "3 : 0"); 
     * 
     * Bảng mã
     *  <=>   |   LIKE
     *  >=    |   >=
     *  <=    |   <=
     *  !=    |   <>
     *  >     |   >
     *  <     |   <
     *  :     |   =
     *  {in}  |  WhereIn()
     * 
     *  Nếu không truyền $limit vào hoặc $limit = [] thì trả về không phân trang
     */
    

    public function findByFieldVersionOld ($conditions = [], $orderBy = '', $limit = '', $convert = false) {
        $table = $this->model->getTable();
        $query = DB::table($table);

        $arrayCompare = [
            '<=>', '>=' , '<=', '!=', '>', '<' , ':', '{in}'
        ];
        $compare = '';

        foreach($conditions as $condition) {
            foreach ($arrayCompare as $comp) {
                $find = strpos($condition, $comp);
                if ($find != false) {
                    $compare = $comp;
                    break;
                }
            } 

            $arr = explode($compare, $condition);
            $field = trim($arr[0]);
            $value = trim($arr[1]);

            if ($compare == ':') {
                $compare = '=';
            }

            if ($compare == '!=') {
                $compare = '<>';
            }

            if ($compare == '{in}') {
                $value = explode(",", $value);
                $query->whereIn($field, $value);
                continue;
            }

            if ($compare == '<=>') {
                $query->where($field, "LIKE" ,"%$value%");
                continue;
            }

            $query->where($field, $compare, $value);
        }

        if (!empty($orderBy)) {
            $arr = explode(':', $orderBy);
            $field = trim($arr[0]);
            $type = trim($arr[1]);

            $query->orderBy($field, $type);
        }

        if (!empty($limit)) {
            $arr = explode(':', $limit);
            $number = intval(trim($arr[0]));
            $offset = intval(trim($arr[1]));

            // dd($number, $offset);

            $query->skip($number * $offset)->take($number);
        }
        
        return !$convert ? $query->get() : json_decode(json_encode($query->get()->toArray()), true);
    }

    public function findByField($conditions = [], $orderBy = [], $fieldAllows = [], $limit = []) {
        $table = $this->model->getTable();
        $query = DB::table($table);

        $this->handleConditions($conditions, $fieldAllows, $query);

        $this->handleOrderBy($orderBy, $fieldAllows, $query);

        return $this->handleLimit($limit, $query);
    }

    // Đếm bản ghi cho phép nhiều điều kiện
    public function countIf($conditions = [], $fieldAllows = []) {
        $table = $this->model->getTable();
        $query = DB::table($table);

        $this->handleConditions($conditions, $fieldAllows, $query);
        
        return $query->count();
    }

    public function handleOrderBy($orderBy = [], $fieldAllows = [], $query) {
        if (!empty($orderBy)) {
            foreach ($orderBy as $field => $type) {
                if ($this->checkFieldAllow($field, $fieldAllows)) {
                    $query->orderBy($field, $type);
                }
            }
        }
    }

    public function handleLimit($limit = [], $query) {
        if (!empty($limit)) {
            return $query->paginate($limit['limit'], "*", "_page", $limit['page'])->withQueryString();
        }
        return $query->get();
    }

    public function checkFieldAllow($field, $fieldAllows = []) {
        $count = 0;
        if (!empty($fieldAllows)) {
            foreach ($fieldAllows as $allow) {
                if ($field === $allow) {
                    $count++;
                }
            }
        } else {
            return true;
        }

        if ($count === 0) {
            return false;
        }

        return true;
    }

    public function handleConditions($conditions = [], $fieldAllows = [], $query) {
        $arrayCompare = [
            '<=>', '>=' , '<=', '!=', '>', '<' , ':', '{in}'
        ];
        $compare = '';

        foreach($conditions as $condition) {
            foreach ($arrayCompare as $comp) {
                $find = strpos($condition, $comp);
                if ($find != false) {
                    $compare = $comp;
                    break;
                }
            } 

            $arr = explode($compare, $condition);
            $field = trim($arr[0]);
            $value = trim($arr[1]);

            if (!$this->checkFieldAllow($field, $fieldAllows)) {
                continue;
            }

            if ($compare == ':') {
                $compare = '=';
            }

            if ($compare == '!=') {
                $compare = '<>';
            }

            if ($compare == '{in}') {
                $value = explode(",", $value);
                $query->whereIn($field, $value);
                continue;
            }

            if ($compare == '<=>') {
                $query->where($field, "LIKE" ,"%$value%");
                continue;
            }
            
            $query->where($field, $compare, $value);
        }
    }
}