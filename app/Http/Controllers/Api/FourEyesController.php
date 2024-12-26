<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use QS;
use App\ModelsMstFourEyes;

class FourEyesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data = [];
        $page = $request->page ? $request->page : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $jumlah_number = 1;
        $four_eyes = QS::SqlExec("foureyes.seldatafoureyes", ["code" => "flag_req_type", "isactive" => true, "limit" => 10, "offset" => $start]);
        if($four_eyes['response'] == true){
            $jumlah_page = ceil($four_eyes['data'][0]['counted_id'] / $limit);
            $data = [
                'status' => 'success',
                'page' => $page,
                'limit_start' => $start,
                'page_limit' => $jumlah_page,
                'next_page' => $page < $jumlah_page ? $page + 1 : $jumlah_page,
                'fetched' => count($four_eyes['data']),
                'total_record' => $four_eyes['data'][0]['counted_id'],
                'start_number' => intval($page > $jumlah_number ? $page - $jumlah_number : 1),
                'end_number' => intval($page < (intval($jumlah_page) - $jumlah_number) ? $page + $jumlah_number : intval($jumlah_page)),
                'data' => $four_eyes['data']
            ];
        }
        return response()->json($data, 200);
    }

    public function show(Request $request){
        $data = [];
        $page = $request->page ? $request->page : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $jumlah_number = 1;
        $header = QS::SqlExec("foureyes.seldatafoureyesdetailheader", ["skema_id" => $request->skema_id ? $request->skema_id : 1]);
        $item = QS::SqlExec("foureyes.seldatafoureyesdetail", ["skema_id" => $request->skema_id ? $request->skema_id : 1, "isactive" => true, "limit" => 10, "offset" => $start]);
        $four_eyes['header'] = $header;
        $four_eyes['detail'] = $item;
        
        if($header['response'] == true){
            $jumlah_page = 0;
            if($four_eyes['detail']['response'] == true){
                if($four_eyes['detail']['data']){
                    $jumlah_page = ceil($four_eyes['detail']['data'][0]['counted_id'] / $limit);
                }
            }
            $data = [
                'status' => 'success',
                'page' => $page,
                'limit_start' => $start,
                'page_limit' => $jumlah_page,
                'next_page' => $page < $jumlah_page ? $page + 1 : $jumlah_page,
                'fetched' => count($four_eyes['detail']['data']),
                'total_record' => $four_eyes['detail'] ? count($four_eyes['detail']['data']) : 0,
                'start_number' => intval($page > $jumlah_number ? $page - $jumlah_number : 1),
                'end_number' => intval($page < (intval($jumlah_page) - $jumlah_number) ? $page + $jumlah_number : intval($jumlah_page)),
                'data' => $four_eyes
            ];
        }
        return response()->json($data, 200);
    }

    public function edit(Request $request){
        $status     = false;
        $message    = 'Error';
        $records    = null;
        $four_eyes  = QS::SqlExec("foureyes.seldatafoureyesedit", ["skema_id" => ($request->skema_id ? $request->skema_id : 1)]);
        if($four_eyes['response'] == true){
            $status  = true;
            $message = 'Success';
            $records = $four_eyes['data'][0];
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $records
        ], 200);
    }

    public function like(Request $request){
        $data = [];
        $page = $request->page ? $request->page : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $jumlah_number = 1;
        $four_eyes = QS::SqlExec("foureyes.seldatafoureyessearch", ["code" => "flag_req_type", "isactive" => true, "limit" => 10, "offset" => $start, "search" => $request->search]);
        if($four_eyes['response'] == true){
            $jumlah_page = ceil($four_eyes['data'][0]['counted_id'] / $limit);
            $data = [
                'status' => 'success',
                'page' => $page,
                'limit_start' => $start,
                'page_limit' => $jumlah_page,
                'next_page' => $page < $jumlah_page ? $page + 1 : $jumlah_page,
                'fetched' => count($four_eyes['data']),
                'total_record' => $four_eyes['data'][0]['counted_id'],
                'start_number' => intval($page > $jumlah_number ? $page - $jumlah_number : 1),
                'end_number' => intval($page < (intval($jumlah_page) - $jumlah_number) ? $page + $jumlah_number : intval($jumlah_page)),
                'data' => $four_eyes['data']
            ];
        }
        return response()->json($data, 200);
    }

    public function show_new(Request $request){
        $status             = false;
        $message            = 'Error';
        $records            = null;
        $four_eyes          = QS::SqlExec("foureyes.seldatafoureyesdetailnew", ["skema_id" => $request->skema_id]);
        $dropdown['aktor']              = QS::SqlExec("foureyes.seldatafoureyesdetailactor", ["code" => 'flag_aktor']);
        $dropdown['on_approve_action']  = QS::SqlExec("foureyes.seldatafoureyesdetailapprove", ["code" => 'flag_4eyes_action_approve']);
        $dropdown['on_reject_action']   = QS::SqlExec("foureyes.seldatafoureyesdetailreject", ["code" => 'flag_4eyes_action_reject']);
        if($four_eyes['response'] == true){
            $status  = true;
            $message = 'Success';
            $records = [
                'header'    => $four_eyes['data'][0],
                'dropdown'  => $dropdown
            ];
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $records
        ], 200);        
    }

    public function show_new_params(Request $request){
        $status                         = false;
        $message                        = 'Error';
        $records                        = null;
        $dropdown['pilih_tujuan']  = QS::SqlExec("foureyes.seldatafoureyesdetailakses", [
            "code" => 'flag_apv_4_eyes',
            "parameter_code" => 'aksi_4_eyes_'.$request->action_id
        ]);
        if($dropdown['pilih_tujuan']){
            $status  = true;
            $message = 'Success';
            $records = [
                'dropdown'  => $dropdown
            ];
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $records
        ], 200);        
    }

    public function show_edit(Request $request){
        $status             = false;
        $message            = 'Error';
        $records            = null;
        $four_eyes          = QS::SqlExec("foureyes.seldatafoureyesdetailedit", ["skema_detail_id" => $request->skema_detail_id]);
        $dropdown['aktor']  = QS::SqlExec("foureyes.seldatafoureyesdetailactor", ["code" => 'flag_aktor']);
        $dropdown['akses']  = QS::SqlExec("foureyes.seldatafoureyesdetailakses", [
            "code" => 'flag_apv_4_eyes', 
            "parameter_code" => 'menu_access_'.$four_eyes['data'][0]['actor_type']
        ]);
        $dropdown['pilih_tujuan']       = QS::SqlExec("foureyes.seldatafoureyesdetailtujuan", ["code" => 'flag_apv_4_eyes']);
        $dropdown['on_approve_action']  = QS::SqlExec("foureyes.seldatafoureyesdetailapprove", ["code" => 'flag_4eyes_action_approve']);
        $dropdown['on_reject_action']   = QS::SqlExec("foureyes.seldatafoureyesdetailreject", ["code" => 'flag_4eyes_action_reject']);
        // echo json_encode($four_eyes); die;
        if($four_eyes['response'] == true){
            $status  = true;
            $message = 'Success';
            $records = [
                'header'    => $four_eyes['data'][0],
                'dropdown'  => $dropdown
            ];
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $records
        ], 200);
    }

    public function show_edit_akses(Request $request){
        $status     = false;
        $message    = 'Error';
        $records    = null;
        $dropdown['akses']  = QS::SqlExec("foureyes.seldatafoureyesdetailakses", [
            "code" => 'flag_apv_4_eyes', 
            "parameter_code" => 'menu_access_'.$request->aktor
        ]);
        // echo json_encode($four_eyes); die;
        if($dropdown['akses']){
            $status  = true;
            $message = 'Success';
            $records = [
                'dropdown'  => $dropdown
            ];
        }
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data'    => $records
        ], 200);
    }

    public function show_like(Request $request){
        $data = [];
        $page = $request->page ? $request->page : 1;
        $limit = 10;
        $start = ($page - 1) * $limit;
        $jumlah_number = 1;
        $four_eyes = QS::SqlExec("foureyes.seldatafoureyesdetailsearch", ["skema_id" => $request->skema_id, "isactive" => true, "limit" => 10, "offset" => $start, "search" => $request->search]);
        if($four_eyes['response'] == true){
            $jumlah_page = ceil($four_eyes['data'][0]['counted_id'] / $limit);
            $data = [
                'status' => 'success',
                'page' => $page,
                'limit_start' => $start,
                'page_limit' => $jumlah_page,
                'next_page' => $page < $jumlah_page ? $page + 1 : $jumlah_page,
                'fetched' => count($four_eyes['data']),
                'total_record' => count($four_eyes['data']),
                'start_number' => intval($page > $jumlah_number ? $page - $jumlah_number : 1),
                'end_number' => intval($page < (intval($jumlah_page) - $jumlah_number) ? $page + $jumlah_number : intval($jumlah_page)),
                'data' => $four_eyes['data']
            ];
        }
        return response()->json($data, 200);
    }
}