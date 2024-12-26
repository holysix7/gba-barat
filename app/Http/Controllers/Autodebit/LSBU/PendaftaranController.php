<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepProduct;
use App\Models\SysRole;
use App\Models\SysUser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Config;
use App\Exports\Autodebit\LSBU\PendaftaranExport;
use Illuminate\Support\Facades\Route;
use \PDF;
use App\Jobs\ExportingData;

class PendaftaranController extends Controller
{
    public function index(){
        $maxDate = date('Y-m-d');
        // $startDate = $request['start_date'] 00:00:00
        $startDate = '2022-12-01' . ' 00:00:00';
        // $endDate = $request['end_date'] 23:59:59
        $endDate = '2022-12-05' . ' 00:00:00';
        $records    = DB::select("SELECT
            b.code AS kode_cabang,
            b.name AS nama_cabang,
            b.group_branch AS kode_induk,
            b.kc_name AS cabang_induk,
            sd_pc_pid AS produk,
            sd_pc_src_extacc AS rekening_sumber,
            sd_pc_dst_prodid AS tipe_rek_tujuan,
            sp_pc_src_name AS nama_nasabah,
            sd_pc_dst_extacc AS rek_tujuan,
            sp_pc_period AS jangka_waktu,
            sp_pc_period_amount AS setoran_bulanan,
            sp_pc_period_date AS tanggal_debet,
            sp_pc_settle_date AS jatuh_tempo
        FROM
            savdep_product_customer_lsbu a
        LEFT JOIN
            sys_branches b ON a.sp_pc_branch_reg = b.code
        WHERE 
            (sp_pc_reg_date BETWEEN '$startDate' AND '$endDate')
            AND 
                sp_pc_branch_reg = '0114'
        UNION ALL
            SELECT
                b.code AS kode_cabang,
                b.name AS nama_cabang,
                b.group_branch AS kode_induk,
                b.kc_name AS cabang_induk,
                sd_pc_pid AS produk,
                sd_pc_src_extacc AS rekening_sumber,
                sd_pc_dst_prodid AS tipe_rek_tujuan,
                sp_pc_src_name AS nama_nasabah,
                sd_pc_dst_extacc AS rek_tujuan,
                sp_pc_period AS jangka_waktu,
                sp_pc_period_amount AS setoran_bulanan,
                sp_pc_period_date AS tanggal_debet,
                sp_pc_settle_date AS jatuh_tempo
            FROM
                savdep_product_customer_lsbu_close a
            LEFT JOIN
                sys_branches b ON a.sp_pc_branch_reg = b.code
            WHERE 
                (sp_pc_reg_date BETWEEN '$startDate' AND '$endDate')
                AND 
                    sp_pc_branch_reg = '0114'
        ");
        // dd($records);
        return view('autodebit.lsbu.pendaftaran.index', compact('maxDate'));
    }

    public function ajax(Request $request){
        
        $kodeCabang = Session::get('user')->kodeCabang;

        $records    = DB::select("SELECT * FROM (SELECT * FROM savdep_product_customer_lsbu a LEFT JOIN savdep_product b ON a.sd_pc_pid = b.sd_p_id WHERE sp_pc_branch_reg = '$kodeCabang' AND (sp_pc_reg_date BETWEEN '$request->start_date 00:00:00' AND '$request->end_date 23:59:59') UNION SELECT * FROM savdep_product_customer_lsbu_close a LEFT JOIN savdep_product b ON a.sd_pc_pid = b.sd_p_id WHERE sp_pc_branch_reg = '$kodeCabang' AND (sp_pc_reg_date BETWEEN '$request->start_date 00:00:00' AND '$request->end_date 23:59:59')) AS newSql LIMIT $request->length OFFSET $request->start");
        
        $counted   = DB::select("SELECT count(sd_pc_dst_extacc) FROM savdep_product_customer_lsbu a LEFT JOIN savdep_product b ON a.sd_pc_pid = b.sd_p_id WHERE sp_pc_branch_reg = '$kodeCabang' AND (sp_pc_reg_date BETWEEN '$request->start_date 00:00:00' AND '$request->end_date 23:59:59') UNION SELECT count(sd_pc_dst_extacc) FROM savdep_product_customer_lsbu_close a LEFT JOIN savdep_product b ON a.sd_pc_pid = b.sd_p_id WHERE sp_pc_branch_reg = '$kodeCabang' AND (sp_pc_reg_date BETWEEN '$request->start_date 00:00:00' AND '$request->end_date 23:59:59')");
        
        $resCount = 0;
        foreach($counted as $row){
            $resCount += $row->count;
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
        $startDate  = $request->start_date ." 00:00:00";
        $endDate    = $request->end_date ." 23:59:59";
        $branchCode = Session::get('user')->kodeCabang;
        $records    = DB::select("SELECT
            b.code AS kode_cabang,
            b.name AS nama_cabang,
            b.group_branch AS kode_induk,
            b.kc_name AS cabang_induk,
            sd_pc_pid AS produk,
            sd_pc_src_extacc AS rekening_sumber,
            sd_pc_dst_prodid AS tipe_rek_tujuan,
            sp_pc_src_name AS nama_nasabah,
            sd_pc_dst_extacc AS rek_tujuan,
            sp_pc_period AS jangka_waktu,
            sp_pc_period_amount AS setoran_bulanan,
            sp_pc_period_date AS tanggal_debet,
            sp_pc_settle_date AS jatuh_tempo
          FROM
            savdep_product_customer_lsbu a
          LEFT JOIN
            sys_branches b ON a.sp_pc_branch_reg = b.code
          WHERE 
            (sp_pc_reg_date BETWEEN '$startDate' AND '$endDate')
            AND 
              sp_pc_branch_reg = '$branchCode'
          UNION ALL
          SELECT
            b.code AS kode_cabang,
            b.name AS nama_cabang,
            b.group_branch AS kode_induk,
            b.kc_name AS cabang_induk,
            sd_pc_pid AS produk,
            sd_pc_src_extacc AS rekening_sumber,
            sd_pc_dst_prodid AS tipe_rek_tujuan,
            sp_pc_src_name AS nama_nasabah,
            sd_pc_dst_extacc AS rek_tujuan,
            sp_pc_period AS jangka_waktu,
            sp_pc_period_amount AS setoran_bulanan,
            sp_pc_period_date AS tanggal_debet,
            sp_pc_settle_date AS jatuh_tempo
          FROM
            savdep_product_customer_lsbu_close a
          LEFT JOIN
            sys_branches b ON a.sp_pc_branch_reg = b.code
          WHERE 
            (sp_pc_reg_date BETWEEN '$startDate' AND '$endDate')
            AND 
            sp_pc_branch_reg = '$branchCode'
        ");

        $counted = count($records);
        if($counted > 0){
            $array = [
                "branch_code"   => $branchCode,
                "counted"       => $counted,
                "type"          => 'LSBU - Pendaftaran',
                "request"       => $request->all()
            ];
            ExportingData::dispatch($array);
            userActivities('Export', 'Melakukan export data laporan pendaftaran', 'savdep_product_customer_lsbu', 'General', Route::current()->getName());
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