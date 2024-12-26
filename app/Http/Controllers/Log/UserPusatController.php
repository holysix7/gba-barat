<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Yajra\Datatables\Datatables;


class UserPusatController extends Controller
{
    public function index(){
        return view('log.index');
    }

    public function getBasicData(Request $request)
    {
        // $date = explode('|', $request['search_param']['date']);
        // if($date[0] == "" || $date[0] == Null || is_null($date[0])){
        $whereSearch = "";
        $keyword = $request['search_param']['search'];
        $whereSearch = "WHERE vla.deskripsi_log LIKE '%$keyword%'";   
        
        $status = $request['search_param']['status_category'];
        if($status <> "All"){
            $whereSearch .= " AND vla.kategori_log = '$status'";   
        }
        // }
        // elseif (count($date) === 1 && !is_null($date)) { 
        //     $whereSearch = "WHERE vtm.tanggal_autodebit LIKE '$date[0]'";
        // } elseif (count($date) === 2 && !is_null($date)) {
        //     $whereSearch = "WHERE vtm.tanggal_autodebit >= '" . $date[0] . " 00:00:00' AND vtm.tanggal_autodebit <= '" . $date[1] . " 23:59:59'";
        // } 

        $data = DB::select("SELECT * FROM public.v_log_activity_mygoals AS vla $whereSearch ORDER BY vla.tanggal_log DESC");
        
        return DataTables::of($data)->make(true);  
    }
}
