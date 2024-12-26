<?php

namespace App\Http\Controllers\Autodebit\MyGoals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Autodebit\MyGoals\PenutupanExport;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepProductCustomerMyGoal;

class PenutupanController extends Controller
{
    public function index(){
        $maxDate = date('Y-m-d');
        return view('autodebit.mygoal.penutupan.index', compact('maxDate'));
    }

    public function ajax_goals(Request $request){
        if($request->start_date){
            $records    = DB::table('savdep_product_customer_mygoals AS a')
                ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                ->where('sp_pc_branch_reg', Session::get('user')->kodeCabang)
                ->where('sp_pc_user_reg', Session::get('user')->userId)
                ->where(function($query){
                    $query->where('a.sp_pc_status', 2)
                    ->orWhere('a.sp_pc_status', 4);
                })
                ->whereBetween('a.sp_pc_reg_date', ["$request->start_date 00:00:00", "$request->end_date 23:59:59"])
                ->orderBy('a.sp_pc_reg_date', 'ASC');
        }else{
            $records    = DB::table('savdep_product_customer_mygoals AS a')
                ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                ->where('sp_pc_branch_reg', Session::get('user')->kodeCabang)
                ->where('sp_pc_user_reg', Session::get('user')->userId)
                ->where(function($query){
                    $query->where('a.sp_pc_status', 2)
                    ->orWhere('a.sp_pc_status', 4);
                })
                ->orderBy('a.sp_pc_reg_date', 'ASC');
        }
        $resCount   = $records->count();
        $records    = $records->get();
        $no         = $request->start;
        foreach($records as $row){
            $row->rownum    = ++$no;
            $row->id        = Crypt::encrypt($row->sd_pc_src_intacc);
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }

    public function export(Request $request){
        $date = date("Ymd-his");
        userActivities('Export', 'Melakukan export data laporan penutupan', 'savdep_product_customer_mygoals', 'General', Route::current()->getName());
        return Excel::download(new PenutupanExport($request), 'laporan-penutupan-'. $date .'.xlsx');
    }
}