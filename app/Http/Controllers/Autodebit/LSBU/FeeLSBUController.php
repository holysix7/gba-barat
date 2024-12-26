<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepProduct;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Models\ViewFeeLsbu;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Config;
use App\Exports\Autodebit\LSBU\FeeAdminExport;
use Illuminate\Support\Facades\Route;
use App\Jobs\ExportingData;

class FeeLSBUController extends Controller
{
    public function index(){
        $maxDate = date('Y-m-d');
        return view('autodebit.lsbu.fee-lsbu.index', compact('maxDate'));
    }

    public function ajax(Request $request){
        $query    = ViewFeeLsbu::where(function($query){
            $query->where('kantor_cabang', Session::get('user')->kodeCabang);
        });
        $query      = $query->orderBy('tanggal', 'desc');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        $no         = $request->start;
        foreach($records as $row){
            $row->rownum    = ++$no;
        }
        $response = [
            "start"             => $request->start_date,
            "end"               => $request->end_date,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }
    
    public function export(Request $request){
        $counted = 0;
        $counted = DB::table('savdep_transactions AS a')
          ->leftJoin('savdep_product_customer_lsbu AS b', 'a.sd_t_dep_acc', '=', 'b.sd_pc_dst_extacc')
          ->leftJoin('sys_branches AS c', 'b.sp_pc_branch_reg', '=', 'c.code')
          ->where([
            ['a.sd_t_pid', '=', 'LSBU'],
            ['b.sp_pc_branch_reg', '=', Session::get('user')->kodeCabang]
          ])
          ->where(function($query) use($request) {
            $query->whereBetween('a.sd_t_dt', ["$request->start_date 00:00:00", "$request->end_date 23:59:59"]);
          })
          ->count();
        // dd($counted->toSql());
        if($counted > 0){
            $array = [
                "branch_code"   => Session::get('user')->kodeCabang,
                "counted"       => $counted,
                "type"          => 'LSBU - Fee',
                "request"       => $request->all()
            ];
            ExportingData::dispatch($array);
            userActivities('Export', 'Melakukan export data laporan fee lsbu', 'v_fee_lsbu', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan export silahkan klik link <a href="'. route("download-manager") .'">ini</a>';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan export karena tidak ada data pada tanggal: <b>'. $request->start_date .' - '. $request->end_date . '</b>';
            $alert      = 'danger';
        }
        return redirect()->back()->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }
}