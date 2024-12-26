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

use App\Models\UserActivity;


class LogController extends Controller
{
    public function index(){
        return view('log.index');
    }

    public function indexMyGoals(){
        $data = [
            'title' => 'Log',
            'desc' => 'Daftar Log Autodebit MyGoals',
            'type' => 'MyGoals'
        ];
        return view('log.index', $data);
    }

    public function indexRegular(){
        $data = [
            'title' => 'Log',
            'desc' => 'Daftar Log Autodebit Regular',
            'type' => 'Regular'
        ];
        return view('log.index', $data);   
    }
    
    public function getBasicData(Request $request)
    {
        $data = UserActivity::orderBy('cua_dt','DESC');

        $keyword = $request['search_param']['search'];
        $status = $request['search_param']['status_category'];
        $type = $request['search_param']['type'];
        
        if(!is_null($keyword)){
            $data->where('cua_desc', 'like', "%$keyword%");
        }
        if($status <> "All"){
            $data->where('cua_act', "$status");   
        }
        $data = $data->where('cua_type', "$type");
        $result = $data->get();
        
        return DataTables::of($result)->make(true);  
    }
}
