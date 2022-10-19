<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\UseCases\Order\OrderUseCase;
use App\UseCases\OrderDetail\OrderDetailUseCase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{
    protected $orderUseCase;
    protected $orderDetailUseCase;

    public function __construct(OrderUseCase $orderUseCase, OrderDetailUseCase $orderDetailUseCase)
    {
        $this->orderUseCase = $orderUseCase;
        $this->orderDetailUseCase = $orderDetailUseCase;
    }

    public function index(Request $request)
    {   
        try {
            $orders  = $request->all();

            if(empty($orders['data']) 
            || is_string($orders['data'])
            || empty($orders['data']['order'])
            || empty($orders['data']['details'])
            || empty($orders))
            {
                return response()->json([
                    'code' => 400,
                    'message' => 'Bad Request',
                ], 400);
            }

            $orders['data']['order']['employee_id'] = 1;
            $this->orderUseCase->create($orders['data']['order']);

            $lastIndex = $this->orderUseCase->getLastIndex()['id'];
            $orderDetail = $orders['data']['details'];
            $total = 0;
            foreach ($orderDetail as $data) {
                $total += $data['quantity'] * $data['unit_price'] - $data['discount_amount'];
                $data['order_id'] = $lastIndex;
                $this->orderDetailUseCase->create($data);
            }

            $user = $request->user();

            $to_email = $user->email;
            $subject = 'Đặt hàng thành công';
            $view = "ordersuccess";
            $data = [
                'total' => $total,
                'fullname' => $user->fullname,
                'orderId' => $lastIndex,
            ];
            SendMailJob::dispatch($to_email, $subject, $view, $data);

            return response()->json([
                'code' => 201,
                'message' => 'Recorded',
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json(['code'=> 500,'error' => $e->getMessage()], 500);
        }
    }

    public function getListOrders(Request $request) {
        try {
            $customer = JWTAuth::User();
            $query = $request->query();
            $orders = $this->orderUseCase->getOrdersByCustomerId($customer->id, $query);
            return response()->json([
                'code' => 200,
                'message' => 'Get list orders by user successfully',
                'data' => $orders,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['code'=> 500,'error' => $e->getMessage()], 500);
        }
    } 

    public function show($id)
    {
        $order = $this->orderUseCase->find($id);

        return view('home.order', ['order' => $order]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        //... Validation here

        $order = $this->orderUseCase->create($data);

        return view('home.orders');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        //... Validation here

        $order = $this->orderUseCase->update($id, $data);

        return view('home.orders');
    }

    public function destroy($id)
    {
        // $this->orderUseCase->delete($id);
        
        return view('home.orders');
    }
}