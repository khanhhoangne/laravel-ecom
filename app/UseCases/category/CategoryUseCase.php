<?php

namespace App\UseCases\Category;

use App\UseCases\UseCaseInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryUseCase implements UseCaseInterface {

    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getAllByCondition($query = []) {

    }

    public function getAll() {
        $categories = $this->categoryRepo->getAllCategories()->toArray();

        $cates_temp = $categories;
        $cates_response = [];

        // xử lý danh mục cấp 1
        foreach ($cates_temp as $key => $cate) {
            if ($cate['parent_id'] === null) {
                $cate['submenu'] = [];
                array_push($cates_response, $cate);
                unset($cates_temp[$key]);
            }
        }

        // xử lý danh mục cấp 2
        for ($i = 0; $i < count($cates_response); $i++) {
            foreach ($cates_temp as $key => $cate) {
                if ($cate['parent_id'] === $cates_response[$i]['id']) {
                    $cate['submenu'] = [];
                    array_push($cates_response[$i]['submenu'], $cate);
                    unset($cates_temp[$key]);
                }
            }
        }

        if (count($cates_temp) === 0) {
            return $cates_response;
        }

        // xử lý danh mục cấp 3
        for ($i = 0; $i < count($cates_response); $i++) {
            if (count($cates_response[$i]['submenu']) > 0) {
                foreach ($cates_response[$i]['submenu'] as $index => $arr_sub) {
                    foreach ($cates_temp as $key => $cate) {
                        if ($cate['parent_id'] === $arr_sub['id']) {
                            $cate['submenu'] = [];
                            array_push($cates_response[$i]['submenu'][$index]['submenu'], $cate);
                            unset($cates_temp[$key]);
                        }
                    }
                }
            }
        }

        return $cates_response;
    }

    public function find($id) {

    }

    public function create($attributes = []) {

    }

    public function update($id, $attributes = []) {

    }
}