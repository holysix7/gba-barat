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
use App\Jobs\ExportingData;

class PenutupanController extends Controller
{
    public function index(){
        $maxDate = date('Y-m-d');
        return view('autodebit.lsbu.penutupan.index', compact('maxDate'));
    }

    public function ajax(Request $request){
        $query    = DB::table('savdep_product_customer_lsbu_close AS a')
        ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
        ->leftJoin('savdep_closing_tran AS c', 'a.sp_pc_reg_id', '=', 'c.sd_ct_reg_lsbu')
        ->where('a.sp_pc_branch_reg', Session::get('user')->kodeCabang)
        ->where('a.sd_pc_pid', 'ilike', '%LSBU%')
        ->whereBetween('c.sd_ct_dt', ["$request->start_date 00:00:00", "$request->end_date 23:59:59"]);

        $query      = $query->orderBy('c.sd_ct_dt', 'ASC');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        foreach($records as $row){
            $row->routeshow = route('autodebit.lsbu.penutupan.show', [Crypt::encrypt($row->sd_pc_dst_extacc), Crypt::encrypt($row->sp_pc_reg_id)]);
        }
        $no         = $request->start;
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
    
    public function show($params, $paramsDua){
        $maxDate = date('Y-m-d');
        $record  = DB::table('savdep_product_customer_lsbu_close AS a')
        ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
        ->leftJoin('savdep_closing_tran AS c', 'a.sp_pc_reg_id', '=', 'c.sd_ct_reg_lsbu')
        ->where([
            ['a.sd_pc_dst_extacc', Crypt::decrypt($params)],
            ['a.sp_pc_reg_id', Crypt::decrypt($paramsDua)]
        ])
        ->first();
        // dd(Crypt::decrypt($paramsDua));
        $record->progress       = intval(($record->sp_pc_current_period_sukses / $record->sp_pc_period) * 100);
        $record->routeRiwayat   = route('autodebit.lsbu.daftar-rekening.transaksi', $params);
        return view('autodebit.lsbu.penutupan.index', compact('record', 'maxDate'));
    }

    public function export(Request $request){
        $startDate  = $request->start_date . " 00:00:00";
        $endDate    = $request->end_date . " 23:59:59";
        $branchCode = Session::get('user')->kodeCabang;
        $records = DB::select("SELECT
            sp_pc_branch_reg as kode_cabang,
            b.name as nama_cabang,
            b.group_branch as kode_induk,
            b.kc_name as cabang_induk,
            sd_pc_pid as produk,
            sd_pc_src_extacc as rekening_sumber,
            sd_pc_dst_prodid as jenis_rekening,
            sp_pc_src_name as nama_nasabah,
            sd_pc_dst_extacc as rekening_tujuan,
            sp_pc_period as jangka_waktu,
            sp_pc_period_amount as setoran_bulanan,
            sp_pc_reg_date as tanggal_regis,
            sp_pc_settle_date as jatuh_tempo,
            sd_ct_dt as tanggal_penutupan,
            sp_pc_debet_total_amount as saldo_diterima,
            CASE 
                WHEN c.sd_ct_type = '2' THEN 'Tutup Normal'
                WHEN c.sd_ct_type = '3' THEN '3x Gagal Debet'
                WHEN c.sd_ct_type = '4' THEN 'Tutup Manual'
                WHEN c.sd_ct_type = '5' THEN 'Tutup karena kesalahan data'
                ELSE NULL
            END as keterangan_tutup
            FROM
                savdep_product_customer_lsbu_close a
            LEFT JOIN
                sys_branches b ON a.sp_pc_branch_reg = b.code
            LEFT JOIN
                savdep_closing_tran c ON a.sd_pc_dst_extacc = sd_ct_dep_acc
            WHERE
                    (a.sp_pc_reg_date BETWEEN '$startDate' AND '$endDate')
                AND
                    a.sp_pc_branch_reg = '$branchCode' 
                AND 
                    a.sp_pc_reg_id = c.sd_ct_reg_lsbu
            ORDER BY
            sd_ct_dt"
        );
        
        $counted = count($records);
        if($counted > 0){
            $array = [
                "branch_code"   => $branchCode,
                "counted"       => $counted,
                "type"          => 'LSBU - Penutupan',
                "request"       => $request->all()
            ];
            ExportingData::dispatch($array);
            userActivities('Export', 'Melakukan export data laporan penutupan', 'savdep_closing_tran', 'General', Route::current()->getName());
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