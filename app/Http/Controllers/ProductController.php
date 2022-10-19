<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCases\Product\ProductUseCase;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
    protected $productUseCase;

    public function __construct(ProductUseCase $productUseCase)
    {
        $this->productUseCase = $productUseCase;
    }

    public function index(Request $request)
    {
        try {   
            if (empty($data = $request->all())) {
                $products = $this->productUseCase->getAllByCondition();
            } else {
                unset($data['_page'], $data['_limit'], $data['_sort'], $data['_order']);
                $products = $this->productUseCase->getAllByCondition(
                (!empty($request->input('_page')) || !empty($request->input('_limit'))) ? ['page'  => $request->input('_page'), 'take'  => $request->input('_limit')] : []
               ,(!empty($request->input('_sort')) || !empty($request->input('_order'))) ? ['sort'  => $request->input('_sort'), 'order' => $request->input('_order')] : []
               ,['filter' => $data]
               , $request->input('q'));
            }

            if(!$products) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            return response()->json(['code'=> 200, 'message' => 'success','data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function discount(Request $request) {
        try {   
            $products = $this->productUseCase->getProductDiscount(
                (!empty($request->input('_page')) || !empty($request->input('_limit'))) ? ['page'  => $request->input('_page'), 'take'  => $request->input('_limit')] : []
            );
            

            if(!$products) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            return response()->json(['code'=> 200, 'message' => 'success','data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {  
            if(!is_numeric($id)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            } 
            $product = $this->productUseCase->find($id);
            return response()->json(['code'=> 200, 'message' => 'success','data' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }     
    }

    public function getTopSell(Request $request) {
        $query = $request->query();
        try {
            $topsell  = $this->productUseCase->getTopSell($query);

            return response()->json([
                'code'=> 200, 
                'message' => 'success',
                'data' => $topsell
            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                ['code' => $e->getCode(), 
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {  
            if(empty($data)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            } 
            $this->productUseCase->createProduct($data);
            return response()->json(['code'=> 201, 'message' => 'Recorded!'], 201);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function reviews(Request $request) {
       
        try {   
            $products = $this->productUseCase->getProductReviews($request->input('product'),
                (!empty($request->input('_page')) || !empty($request->input('_limit'))) ? ['page'  => $request->input('_page'), 'take'  => $request->input('_limit')] : []
            );
            

            if(!$products) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            return response()->json(['code'=> 200, 'message' => 'success','data' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function storeReviews(Request $request){
        try {   
            $reviews = $request->all();
            
            $this->productUseCase->createReview($reviews);

         

            return response()->json(['code'=> 201, 'message' => 'Recorded!'], 201);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $product = $this->productUseCase->update($id, $data);

        return view('home.products');
    }

    public function destroy($id)
    {
        // $this->productUseCase->delete($id);

        return view('home.products');
    }
}
