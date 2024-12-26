<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductCustomerMyGoal;
use App\Models\SavdepProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Autodebit\LSBU\DaftarRekeningExport;
use App\Exports\Autodebit\LSBU\MonitoringExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Yajra\Datatables\Datatables;
use App\Models\SavdepTransaction;

class MonitoringController extends Controller
{
    public function indexRegular(){
        $data = [
            'title' => 'Monitoring',
            'desc' => 'Daftar Seluruh Rekening Autodebit Regular',
            'type' => 'Regular'
        ];
        return view('monitoring.index', $data);
    }
    
    public function indexLSBU(){
        $data = [
            'title' => 'Monitoring',
            'desc' => 'Daftar Seluruh Rekening LSBU',
            'type' => 'LSBU'
        ];
        return view('monitoring.index', $data);
    }
    
    public function indexMyGoals(){
        $data = [
            'title' => 'Monitoring',
            'desc' => 'Daftar Seluruh Rekening Autodebit MyGoals',
            'type' => 'MYGOALS'
        ];
        return view('monitoring.index', $data);
    }

    public function getBasicData(Request $request)
    {
        $query = DB::table('savdep_transactions')
                    ->join('savdep_product_customer_lsbu', 'savdep_transactions.sd_t_dep_acc', '=', 'savdep_product_customer_lsbu.sd_pc_dst_extacc')
                    ->select('savdep_transactions.*','savdep_product_customer_lsbu.sp_pc_dst_name');

        $type = $request['search_param']['type'];
        $query->where('savdep_transactions.sd_t_pid', $type);

        $date = explode('|', $request['search_param']['date']);

        $search = $request['search_param']['search'];
        if(!is_null($search)){
            $query->where('savdep_transactions.sd_t_dep_acc', 'ilike', "%" . $search . "%")
                ->orWhere('savdep_product_customer_lsbu.sp_pc_dst_name', 'ilike', "%" . $search . "%");
        }
        
        if(strlen($date[0]) > 0 && strlen($date[1]) > 0){
            $query->whereDate('savdep_transactions.sd_t_dt', '>=', "$date[0] 00:00:00");
            $query->whereDate('savdep_transactions.sd_t_dt', '<=', "$date[1] 23:59:59");
        } elseif(strlen($date[0]) > 0 && strlen($date[1] < 1)){
            $query->whereDate('savdep_transactions.sd_t_dt', '=', "$date[0]");
        }

        $status = $request['search_param']['status_category'];
        if($status == "Sukses") {
            $query->where('savdep_transactions.sd_t_rc', '=', '0000')
                ->orWhere('savdep_transactions.sd_t_rc', '=', 'R');
        } else {
            $query->where('savdep_transactions.sd_t_rc', '=', '0004')
                ->orWhere('savdep_transactions.sd_t_rc', '=', 'F');
        }

        $query->orderBy('savdep_transactions.sd_t_dt', 'DESC');

        $data = $query->get();
        return DataTables::of($data)->make(true);  
    }

    public function export(Request $request){
        dd($request->all());
        $type = $request->type;
        $date = date("Ymd-his");
        userActivities('Export', 'Melakukan export data', 'cl_user_activities', $type, Route::current()->getName());
        $request->nominal_start = str_replace('.', '', $request->nominal_start);
        $request->nominal_end = str_replace('.', '', $request->nominal_end);
        dd($request->all());
        return Excel::download(new MonitoringExport($request), 'daftar-monitoring-transaksi-' . $type . '-' . $date .'.xlsx');
    }
}
