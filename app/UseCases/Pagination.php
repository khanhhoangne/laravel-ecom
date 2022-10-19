<?php

namespace App\UseCases;

class Pagination {
    private static $page = 1;
    private static $take = 8;
    private static $takeMax = 50;
    private static $order = 'desc';

    public static function paginate($pagination = []) {
        if (!empty($pagination['page'])) {
            if ($pagination['page'] > 0) {
                self::$page = round($pagination['page']);
            }
        }

        if (!empty($pagination['take'])) {
            if ($pagination['take'] > 0 && $pagination['take'] <= self::$takeMax) {
                self::$take = round($pagination['take']);
            }
        }

        return [
            'page' => self::$page,
            'take' => self::$take
        ];
    }   

    public static function sort($sortBy = []) {
        if (empty($sortBy['sort'])) {
            return [];
        }
        
        $array_field_sort = explode(',', $sortBy['sort']);
        $sort = [];
        $array_order_sort = []; 

        if (!empty($sortBy['order'])) {
            $array_order_sort = explode(',', $sortBy['order']);

            foreach ($array_order_sort as $key => $order) {
                if ($order !== 'asc' && $order !== 'desc') {
                    $array_order_sort[$key] = self::$order;
                }
            }
        }

        foreach ($array_field_sort as $key => $field) {
            $order = self::$order;
            if (!empty($array_order_sort[$key])) {
                $order = $array_order_sort[$key];
            }
            array_push($sort, [$field,$order]);
        }

        return $sort;
    } 
}
