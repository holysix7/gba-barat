<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepProduct;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Models\SavdepClosingTran;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Config;
use App\Exports\Autodebit\LSBU\PenutupanExport;
use Illuminate\Support\Facades\Route;
use \PDF;
use App\Models\UserActivity;

class LogActivityController extends Controller
{
    public function index(){
        return view('autodebit.lsbu.log-activity.index');
    }

    public function ajax(Request $request){
        $query    = DB::table('cl_user_activities AS a')
        ->where('a.branch_code', Session::get('user')->kodeCabang)
        ->where('a.cua_by_uid', 'ilike', Session::get('user')->userId);
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
                ->orWhere('cua_type', 'ilike', "%$request->search%");
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
}