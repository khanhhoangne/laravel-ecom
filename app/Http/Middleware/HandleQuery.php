<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleQuery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $page = 1;
    protected $limit = 8;
    protected $limitMax = 50;
    protected $order = 'desc';

    public function handlePaginateQuery($request) {
        if (!empty($request->query('_page'))) {
            if ($request->query('_page') > 0) {
                $this->page = $request->query('_page');
            }
        }

        if (!empty($request->query('_limit'))) {
            if ($request->query('_limit') > 0 && $request->query('_limit') <= $this->limitMax) {
                $this->limit = $request->query('_limit');
            }
        }

        $request['pagination'] = [
            'page' => $this->page,
            'limit' => $this->limit,
        ];
    }

    public function handleSortByQuery($request) {
        if (!empty($request->query('_sort'))) {
            $array_field_sort = explode(',', $request->query('_sort'));
            $sort = [];
            $array_order_sort = []; 
    
            if (!empty($request->query('_order'))) {
                $array_order_sort = explode(',', $request->query('_order'));
    
                foreach ($array_order_sort as $key => $order) {
                    if ($order !== 'asc' && $order !== 'desc') {
                        $array_order_sort[$key] = 'desc';
                    }
                }
            }
    
            foreach ($array_field_sort as $key => $field) {
                $order = 'desc';
                if (!empty($array_order_sort[$key])) {
                    $order = $array_order_sort[$key];
                }
                $sort[$field] = $order;
            }

            $request['orderBy'] = $sort;
        }
    }

    public function handleQueryConditions($request) {
        $query = $request->query();
        $conditions = [];

        foreach ($query as $key => $value) {
            if ($key !== '_page' 
                && $key !== '_limit' 
                && $key !== '_sort' 
                && $key !== '_order' 
                && $key !== '_q') {
                if (preg_match('/_gte_$/', $key)) {
                    $newKey = str_replace('_gte_', '', $key);
                    array_push($conditions, "$newKey >= $value");
                    continue;
                }
                if (preg_match('/_lte_$/', $key)) {
                    $newKey = str_replace('_lte_', '', $key);
                    array_push($conditions, "$newKey <= $value");
                    continue;
                }
                if (preg_match('/_greater_$/', $key)) {
                    $newKey = str_replace('_greater_', '', $key);
                    array_push($conditions, "$newKey > $value");
                    continue;
                }
                if (preg_match('/_less_$/', $key)) {
                    $newKey = str_replace('_less_', '', $key);
                    array_push($conditions, "$newKey < $value");
                    continue;
                }
                if (preg_match('/_like_$/', $key)) {
                    $newKey = str_replace('_like_', '', $key);
                    array_push($conditions, "$newKey <=> $value");
                    continue;
                }
                if (preg_match('/_ne_$/', $key)) {
                    $newKey = str_replace('_ne_', '', $key);
                    array_push($conditions, "$newKey != $value");
                    continue;
                }
                if (preg_match('/_in_$/', $key)) {
                    $newKey = str_replace('_in_', '', $key);
                    array_push($conditions, "$newKey {in} $value");
                    continue;
                }

                array_push($conditions, "$key : $value");
            }
        }

        $request['conditions'] = $conditions;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->handleQueryConditions($request);

        $this->handlePaginateQuery($request);

        $this->handleSortByQuery($request);
        
        return $next($request);
    }
}
