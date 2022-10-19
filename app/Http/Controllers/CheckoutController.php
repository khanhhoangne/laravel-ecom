<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private $gateway;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPayment(Request $request)
    {
        $data = $request->json()->all();
        if(empty($data['total_amount']) || empty($data['requestId']) || !$this->isUuid($data['requestId'])) {
            return response()->json([
                'code' => 400,
                'message' => 'Bad Request',
            ], 400);
        }

        $this->gateway = Omnipay::create('MoMo_AllInOne');
        $this->gateway->initialize([
            'accessKey' => 'E8HZuQRy2RsjVtZp',
            'partnerCode' => 'MOMO0HGO20180417',
            'secretKey' => 'fj00YKnJhmYqahaFWUgkg75saNTzMrbO',
        ]);
        $this->gateway->setTestMode(true);
        $response = $this->gateway->purchase([
            'amount' => intval($data['total_amount']),
            'returnUrl' => 'http://localhost:3333/success',
            'notifyUrl' => 'http://127.0.0.1:8000/api/notification',
            'orderId' => time() . "",
            'requestId' => $data['requestId'],
        ])->send();

        if ($response->isRedirect()) {
            $redirectUrl = $response->getRedirectUrl();  
            return response()->json([
                'code' => 200,
                'url' => $redirectUrl,
            ], 200);
        }
    }

    public function notification()
    {
        
    }

    private function gen_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    private function isUuid($uuid) {
        if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
            return false;
        }
        return true;
    }
}
