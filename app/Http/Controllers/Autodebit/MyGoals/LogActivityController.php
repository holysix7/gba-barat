<?php

namespace App\Http\Controllers\Autodebit\MyGoals;

use App\Http\Controllers\Controller;
use App\Models\SysBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogActivityController extends Controller
{
    public function index(){
        $branchs = SysBranch::where('isactive', true)->get();
        return view('autodebit.mygoal.log-activity.index', compact('branchs'));
    }

    public function ajaxCoba(Request $request){
        var_dump(Session::get('user'));
        dd(Session::get('role'));
        DB::enableQueryLog();
        $query    = DB::table('cl_user_activities AS a')
        ->where('cua_desc', 'ilike', '%my goals%')
        ->where('a.branch_code', Session::get('user')->kodeCabang);
        if(Session::get('role')->name != 'Supervisor'){
            $query->where('a.cua_by_uid', 'ilike', Session::get('user')->userId);
        }
        if($request->search){
            $query  = $query->where(function($q) use($request) {
                $q->where('cua_id', 'ilike', "%$request->search%")
                ->orWhere('cua_act', 'ilike', "%$request->search%")
                ->orWhere('cua_desc', 'ilike', "%$request->search%")
                ->orWhere('cua_status', 'ilike', "%$request->search%")
                ->orWhere('cua_dt', 'ilike', "%$request->search%")
                ->orWhere('cua_session', 'ilike', "%$request->search%")
                ->orWhere('cua_ip', 'ilike', "%$request->search%")
                ->orWhere('cua_user_agent', 'ilike', "%$request->search%")
                ->orWhere('cua_act_id', 'ilike', "%$request->search%")
                ->orWhere('cua_type', 'ilike', "%$request->search%")
                ->orWhere('cua_by_uid', 'ilike', "%$request->search%");
            });
        }
        $query      = $query->orderBy('a.cua_dt', 'DESC');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        $no         = $request->start;
        $response = [
            "start"             => $request->search,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }

    public function ajax(Request $request){
        DB::enableQueryLog();
        $query    = DB::table('cl_user_activities AS cua')->where('cua_desc', 'ilike', '%my goals%');
        $userPusat = [1, 2, 3, 5, 7];
        if(!in_array(Session::get('role')->id, $userPusat)){
            $query->where('cua.branch_code', Session::get('user')->kodeCabang);
        }
        if($request->branch_code){
            $query->where('cua.branch_code', $request->branch_code);
        }

        if($request->search){
            $query  = $query->where(function($q) use($request) {
                $q->where('cua_id', 'ilike', "%$request->search%")
                ->orWhere('cua_act', 'ilike', "%$request->search%")
                ->orWhere('cua_desc', 'ilike', "%$request->search%")
                ->orWhere('cua_status', 'ilike', "%$request->search%")
                ->orWhere('cua_dt', 'ilike', "%$request->search%")
                ->orWhere('cua_session', 'ilike', "%$request->search%")
                ->orWhere('cua_ip', 'ilike', "%$request->search%")
                ->orWhere('cua_user_agent', 'ilike', "%$request->search%")
                ->orWhere('cua_act_id', 'ilike', "%$request->search%")
                ->orWhere('cua_type', 'ilike', "%$request->search%")
                ->orWhere('cua_by_uid', 'ilike', "%$request->search%");
            });
        }
        $query      = $query->orderBy('cua_dt', 'DESC');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        $no         = $request->start;
        $response = [
            "start"             => $request->search,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }
}