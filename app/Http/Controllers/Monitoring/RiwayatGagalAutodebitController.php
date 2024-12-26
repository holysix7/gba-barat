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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Yajra\Datatables\Datatables;

class RiwayatGagalAutodebitController extends Controller
{
    public function index(){
        return view('monitoring.riwayatgagal.index');
    }

    public function ajax_goals(Request $request){
        // if($request->search != null || $request->status_category != null){
            $search = $request->search;

            $query    = DB::table('public.v_transaction_mygoals AS a')
                    ->select('a.*');
                    // ->where('a.rekening_sumber', $request->search)
                    // ->orwhere('a.rekening_tujuan', $request->search)
                    // ->where('a.status_transaksi', $request->status_category)
                    // ->orderBy('a.id_transaksi', 'ASC');

            $records = $query->get();
            $resCount = $query->count();
                    
        $no             = $request->start;
        foreach($records as $row){
            $row->rownum    = ++$no;
            $row->routeshow = route('monitoring.transaksi.daftar-rekening.show', Crypt::encrypt($row->id_transaksi));
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
        return response()->json($response);
        }


    public function show($params){
        $record                             = DB::table('public.v_transaction_mygoals')->where('sd_pc_src_intacc', Crypt::decrypt($params))->first();
        $record->product                    = $record->product ? $record->product : null;
        $record->counted_success            = DB::table('public.v_transaction_mygoals')->where('status_transksi != "Sukses"', FALSE);
        $record->counted_fail               = DB::table('public.v_transaction_mygoals')->where('status_transaksi', 'Sukses')->count();
        $record->saldo_berjangka            = ($record->sd_pc_period_amount * $record->counted_success) + $record->sd_pc_init_amount;
        $record->saldo_success_autodebet    = $record->sd_pc_period_amount * $record->counted_success;
        $record->saldo_fail_autodebet       = $record->sd_pc_debet_fail_count * $record->sd_pc_period_amount;
        $record->transactions               = $record->transactions ? $record->transactions : [];
        if($record->sd_pc_period_interval == 0){
            $record->sd_pc_period_interval_text = 'Bulanan';
        }elseif($record->sd_pc_period_interval == 1){
            $record->sd_pc_period_interval_text = 'Harian';
        }else{
            $record->sd_pc_period_interval_text = 'Mingguan';
        }
        return view('monitoring.transaksi.daftar-rekening.show', compact('record'));
    }

    public function ajax_show_goals(Request $request){
        $record = SavdepProductCustomerMyGoal::where('sd_pc_src_intacc', $request->sd_pc_src_intacc)->first();
        return response()->json($record);
    }

    // yajra
    public function getBasicData(Request $request)
    {
        $date = explode('|', $request['search_param']['date']);
        if($date[0] == "" || $date[0] == Null || is_null($date[0])){
            $whereSearch = "";
        }
        elseif (count($date) === 1 && !is_null($date)) { 
            $whereSearch = "WHERE vtm.tanggal_autodebit LIKE '$date[0]'";
        } elseif (count($date) === 2 && !is_null($date)) {
            $whereSearch = "WHERE vtm.tanggal_autodebit >= '" . $date[0] . " 00:00:00' AND vtm.tanggal_autodebit <= '" . $date[1] . " 23:59:59'";
        } 

        $data = DB::select("SELECT * FROM public.v_transaction_mygoals AS vtm $whereSearch ORDER BY vtm.tanggal_autodebit DESC");
        
        return DataTables::of($data)->make(true);  
    }
}
