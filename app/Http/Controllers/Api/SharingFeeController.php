<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use QS;

class SharingFeeController extends Controller
{
    public function getMdrData(Request $request){
        try{
            $sofId = $request->sof_id;
            $paymentMethodId = $request->payment_method_id;
            // $sofId = 1;
            // $paymentMethodId = 3;

            $res = QS::SqlExec("merchant.selsharingfeemdr", ["sof_id" => $sofId, "payment_method_id" => $paymentMethodId]);

            //if(!$res['response']) throw new \Exception('Error query service');
            $mdr = ($res['response']) ? $res['data'] : [] ;

            $response = response()->json([
                "status" => true,
                "message" => 'Success',
                "data" => $mdr,
                "response_code" => 200
            ], 200);
        } catch (\Throwable $t) {
            $response = response()->json([
                "status" => false,
                "message" => $t->getMessage(),
                "data" => null,
                "response_code" => 500
            ], 500);
        }
        return $response;
    }
}
