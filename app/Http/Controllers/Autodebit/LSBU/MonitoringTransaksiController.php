<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepProduct;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Models\SavdepClosingTran;
use App\Models\MaterilizedViews\MvTransactionLsbu;
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
use App\Jobs\ExportingData;

class MonitoringTransaksiController extends Controller
{
    public function index(){
        $maxDate = date('Y-m-d');
        return view('autodebit.lsbu.monitoring-transaksi.index', compact('maxDate'));
    }

    public function ajax(Request $request){
        $query  = MvTransactionLsbu::where([
            ['status_transaksi', $request->status_category == 'R' ? 'Sukses' : 'Gagal'],
            ['cabang', Session::get('user')->kodeCabang]
        ]);
        if($request->search){
            $query = $query->where(function($q) use($request){
                $q->where('nomor_rekening', 'ilike', "%$request->search%")
                ->orWhere('nama_nasabah', 'ilike', "%$request->search%");
            });
        }
        if($request->start_date){
            $query = $query->whereBetween('tanggal', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }
        $sqlQuery   = $query->toSql();      
        $query      = $query->orderBy('tanggal', 'DESC');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        $response = [
            "sqlQuery"          => $sqlQuery,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }
    
    public function export(Request $request){
        $branchCode     = Session::get('user')->kodeCabang;
        $statusRc       = $request->sd_pc_status;
        $startDate      = $request->start_date ." 00:00:00";
        $endDate        = $request->end_date ." 23:59:59";
        $startNominal   = str_replace('.', '', $request->nominal_start);
        $endNominal     = str_replace('.', '', $request->nominal_end);
        
        if($statusRc == 'R'){
          $records = DB::select("SELECT 
              c.code as kode_cabang,
              c.name as nama_cabang,
              c.group_branch as kode_induk,
              c.kc_name as cabang_induk,
              a.sd_t_pid as produk,
              a.sd_t_src_acc as eksternal_sumber,
              b.sp_pc_src_name as nama_pemilik,
              a.sd_t_dep_acc as eksternal_tujuan,
              a.sd_t_amount as setoran_bulanan,
              a.sd_t_dt as tanggal_debet,
              b.sp_pc_period as total_periode,
              a.sd_t_settle_date as jatuh_tempo,
              a.sd_t_fee as fee
            FROM 
              savdep_transactions as a 
            LEFT JOIN
              savdep_product_customer_lsbu as b ON a.sd_t_dep_acc = b.sd_pc_dst_extacc
            LEFT JOIN
              sys_branches as c ON b.sp_pc_branch_reg = c.code
            WHERE
              a.sd_t_reg_lsbu = b.sp_pc_reg_id
              AND
                a.sd_t_branch = '$branchCode'
              AND
                a.sd_t_pid = 'LSBU'
              AND
                a.sd_t_rc = '$statusRc'
              AND (
                a.sd_t_dt BETWEEN '$startDate' AND '$endDate'
              )
              AND (
                a.sd_t_amount BETWEEN $startNominal AND $endNominal
              )
            
            UNION
            
            select 
              c.code as kode_cabang,
              c.name as nama_cabang,
              c.group_branch as kode_induk,
              c.kc_name as cabang_induk,
              a.sd_t_pid as produk,
              a.sd_t_src_acc as eksternal_sumber,
              b.sp_pc_src_name as nama_pemilik,
              a.sd_t_dep_acc as eksternal_tujuan,
              a.sd_t_amount as setoran_bulanan,
              a.sd_t_dt as tanggal_debet,
              b.sp_pc_period as total_periode,
              a.sd_t_settle_date as jatuh_tempo,
              a.sd_t_fee as fee
            from 
              savdep_transactions as a 
            LEFT JOIN
              savdep_product_customer_lsbu_close as b ON a.sd_t_dep_acc = b.sd_pc_dst_extacc
            LEFT JOIN
              sys_branches as c ON b.sp_pc_branch_reg = c.code
            WHERE
              a.sd_t_reg_lsbu = b.sp_pc_reg_id
            AND
              a.sd_t_branch = '$branchCode'
            AND
              a.sd_t_pid = 'LSBU'
            AND
              a.sd_t_rc = '$statusRc'
            AND (
              a.sd_t_dt BETWEEN '$startDate' AND '$endDate'
            )
            AND (
              a.sd_t_amount BETWEEN $startNominal AND $endNominal
            )
          ");
        }else{
          $records = DB::select("SELECT
              c.code as kode_cabang,
              c.name as nama_cabang,
              c.group_branch as kode_induk,
              c.kc_name as cabang_induk,
              sd_t_pid as produk,
              sd_t_src_acc as rek_sumber,
              sp_pc_src_name as nama_pemilik,
              sd_t_dep_acc as rek_tujuan,
              sd_t_amount as setoran_bulanan,
              sd_t_dt::date as tanggal_debet,
              sd_t_period as periode_gagal,
              sd_t_message_id as keterangan_gagal,
              sd_t_fee as fee
            FROM
              savdep_transactions a
            LEFT JOIN
              savdep_product_customer_lsbu b ON a.sd_t_dep_acc = b.sd_pc_dst_extacc
            LEFT JOIN
              sys_branches c ON b.sp_pc_branch_reg = c.code
            WHERE
              sd_t_rc = '$statusRc' 
              AND 
                sd_t_pid = 'LSBU' 
              AND 
                sd_t_reg_lsbu = sp_pc_reg_id 
              AND 
                sp_pc_branch_reg = '$branchCode'
              AND (
                a.sd_t_dt BETWEEN '$startDate' AND '$endDate'
              )
              AND (
                a.sd_t_amount BETWEEN $startNominal AND $endNominal
              )
            UNION ALL
            
            SELECT
              c.code as kode_cabang,
              c.name as nama_cabang,
              c.group_branch as kode_induk,
              c.kc_name as cabang_induk,
              sd_t_pid as produk,
              sd_t_src_acc as rek_sumber,
              sp_pc_src_name as nama_pemilik,
              sd_t_dep_acc as rek_tujuan,
              sd_t_amount as setoran_bulanan,
              sd_t_dt::date as tanggal_debet,
              sd_t_period as periode_gagal,
              sd_t_message_id as keterangan_gagal,
              sd_t_fee as fee
            FROM
              savdep_transactions a
            LEFT JOIN
              savdep_product_customer_lsbu_close b ON a.sd_t_dep_acc = b.sd_pc_dst_extacc
            LEFT JOIN
              sys_branches c ON b.sp_pc_branch_reg = c.code
            WHERE
              sd_t_rc = '$statusRc' 
              AND 
                sd_t_pid = 'LSBU' 
              AND 
                sd_t_reg_lsbu = sp_pc_reg_id 
              AND 
                sp_pc_branch_reg = '$branchCode'
              AND (
                a.sd_t_dt BETWEEN '$startDate' AND '$endDate'
              )
              AND (
                a.sd_t_amount BETWEEN $startNominal AND $endNominal
              )
          ");
        }
        $counted = count($records);
        if($counted > 0){
            $array = [
                "branch_code"   => $branchCode,
                "counted"       => $counted,
                "type"          => 'LSBU - Monitoring Transaksi',
                "request"       => $request->all()
            ];
            ExportingData::dispatch($array);
            userActivities('Export', 'Melakukan export data monitoring transaksi', 'savdep_transactions', 'General', Route::current()->getName());
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