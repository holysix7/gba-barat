<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\QueryService\Facades\QueryServiceFacades as QS;
use App\ModelsMstFourEyes;
use App\ModelsMstFdsPreventionReport;

class FdsController extends Controller
{
    public function getSkemas(Request $request)
    {
        try {
            $skemaType = $request->type;
            if ($skemaType == 5) throw new \Exception('Skema type tidak valid, skema parameter testing');

            $reSkemas = QS::SqlExec("fds.selskemabyskematyperaw", ["skema_type" => $skemaType, "raw" => "ORDER BY skema_id DESC"]);

            if (!$reSkemas['response']) throw new \Exception('Error query service');
            $skemas = ($reSkemas['response']) ? $reSkemas['data'] : [];

            $response = response()->json([
                "status" => true,
                "message" => 'Success',
                "data" => $skemas,
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

    public function getSkemaParams(Request $request)
    {
        try {
            $skemaType = $request->type;
            $skemaId = $request->skema_id;

            if ($skemaType == 1) {
                $reTestObjects = QS::SqlExec("fds.selskemablacklistparamsraw", ["raw" => "WHERE s.skema_id=$skemaId"]);
            } elseif ($skemaType == 2) {
                $reTestObjects = QS::SqlExec("fds.selskemawhitelistparamsraw", ["raw" => "WHERE s.skema_id=$skemaId"]);
            } elseif ($skemaType == 3) {
                $reTestObjects = QS::SqlExec("fds.selskemasuspectparamsraw", ["raw" => "WHERE s.skema_id=$skemaId"]);
            } elseif ($skemaType == 4) {
                $reTestObjects = QS::SqlExec("fds.selskematranslimitparamsraw", ["raw" => "WHERE s.skema_id=$skemaId"]);
            } else {
                throw new \Exception('Skema type tidak ditemukan. ');
            }

            if (!$reTestObjects['response']) throw new \Exception('Error query service');
            $testObjects = ($reTestObjects['response']) ? $reTestObjects['data'] : [];


            $response = response()->json([
                "status" => true,
                "message" => 'Success',
                "data" => $testObjects,
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

    public function getListRiskCategory(Request $request)
    {
        try {
            // $res = QS::SqlExec("fds.selfdspreventionreport", ["filter_date" => $request->filter_date]);
            $res = QS::SqlExec("fds.selvfdspreventionreport", ["filter_date" => $request->filter_date]);
            if ($res['response']) {
                $response = response()->json([
                    "status" => true,
                    "message" => 'Success',
                    "data" => $res['data'],
                    "response_code" => 200
                ], 200);
            } else {
                $response = response()->json([
                    "status" => true,
                    "message" => 'Tidak ada data',
                    "data" => [],
                    "response_code" => 200
                ], 200);
            }
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

    public function getDetailRiskCategory(Request $request)
    {
        try {
            $data = [];
            $res = QS::SqlExec("fds.selfdspreventionreportdetail", ["id" => $request->id]);
            if ($res['response']) {
                $data['skema_id'] = $res['data'][0]['skema_id'];
                $data['skema_name'] = $res['data'][0]['skema_name'];
                $data['created_at'] = $res['data'][0]['created_at'];
                $resParam = QS::SqlExec("fds.selfdsparam", ["table" => $res['data'][0]['ovr_src'], "id" => $res['data'][0]['ovr_src_id']]);
                if ($resParam['response']) {
                    $data['unit'] = $resParam['data'][0]['unit'];
                    $data['frekeunsi'] = $resParam['data'][0]['frequency'];
                    $data['normal'] = $resParam['data'][0]['normal_value'];
                    $data['low'] = $resParam['data'][0]['lowrisk_value'];
                    $data['medium'] = $resParam['data'][0]['mediumrisk_value'];
                    $data['high'] = $resParam['data'][0]['highrisk_value'];
                    $data['param'] = isset($resParam['data'][0]['param_name']) ? $resParam['data'][0]['param_name'] : $resParam['data'][0]['param'];
                    switch ($data['param']) {
                        case 'phone_number':
                            $data['value'] = $res['data'][0]['phone_number'];
                            break;
                        case 'customer_email':
                            $data['value'] = $res['data'][0]['customer_email'];
                            break;
                        case 'sof_account_id':
                            $data['value'] = $res['data'][0]['sof_account_id'];
                            break;
                        case 'ref_number':
                            $data['value'] = $res['data'][0]['ref_number'];
                            break;
                        default:
                            $data['value'] = '-';
                            break;
                    }
                    $response = response()->json([
                        "status" => true,
                        "message" => 'Success',
                        "data" => $data,
                        "response_code" => 200
                    ], 200);
                } else {
                    $response = response()->json([
                        "status" => true,
                        "message" => 'Tidak ada data',
                        "data" => [],
                        "response_code" => 200
                    ], 200);
                }
            } else {
                $response = response()->json([
                    "status" => true,
                    "message" => 'Tidak ada data',
                    "data" => [],
                    "response_code" => 200
                ], 200);
            }
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

    public function storeParam(Request $request)
    {
        try {
            $data = [];
            switch ($request->param) {
                case 'phone_number':
                    $data['param'] = 'PHONE';
                    $data['value'] = $request->value;
                    break;
                case 'customer_email':
                    $data['param'] = 'EMAIL';
                    $data['value'] = $request->value;
                    break;
                case 'sof_account_id':
                    $data['param'] = 'MERCH_ID';
                    $data['value'] = $request->value;
                    break;
                case 'ref_number':
                    $data['param'] = 'CARDNO';
                    $data['value'] = $request->value;
                    break;
                case 'lat_lon':
                    $data['param'] = 'LATLON';
                    $data['value'] = $request->value;
                    break;
                default:
                    $data['value'] = '-';
                    break;
            }
            // $data['skema_id'] = $request->skema_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $request->created_by;
            if ($request->action == '1') {
                $data['skema_id'] = '50';
                $data['table'] = 'fds_blacklist_params';
            } else {
                $data['skema_id'] = '51';
                $data['table'] = 'fds_whitelist_params';
            }

            $res = QS::SqlExec("fds.insfdsparam", $data);
            if ($res['response']) {
                $response = response()->json([
                    "status" => true,
                    "message" => 'Data berhasil disimpan',
                    "data" => [],
                    "response_code" => 200
                ], 200);
            } else {
                $response = response()->json([
                    "status" => true,
                    "message" => 'Data gagal disimpan',
                    "data" => [],
                    "response_code" => 200
                ], 200);
            }
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
