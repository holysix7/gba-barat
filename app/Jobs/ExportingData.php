<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SavdepDownloadManager;
use App\Models\SavdepProductCustomerLsbu;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use \PDF;
use \Storage;
use App\Exports\Autodebit\LSBU\DaftarRekeningExport;
use App\Exports\Autodebit\LSBU\PendaftaranExport;
use App\Exports\Autodebit\LSBU\PenutupanExport;
use App\Exports\Autodebit\LSBU\MonitoringTransaksiExport;
use App\Exports\Autodebit\LSBU\FeeAdminExport;
use App\Models\ViewFeeLsbu;

class ExportingData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parameter;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->parameter = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $type                   = $this->parameter['type'];
        $newType                = explode(' - ', $type);
        $branch_code            = $this->parameter['branch_code'];
        $counted                = $this->parameter['counted'];
        $request                = $this->parameter['request'];
        $export_type            = $request['export_type'];
        $request['branch_code'] = $branch_code;
        $date                   = date("Ymd-his"); 
        if($export_type == '1'){
            if(strtolower($newType[0]) == 'lsbu'){
                if(strtolower($newType[1]) == 'daftar rekening'){
                    $fileName   = 'laporan-daftar-rekening-'. $date . '.xlsx';
                }
                if(strtolower($newType[1]) == 'pendaftaran'){
                    $fileName   = 'laporan-pendaftaran-'. $date . '.xlsx';
                }
                if(strtolower($newType[1]) == 'penutupan'){
                    $fileName   = 'laporan-penutupan-'. $date . '.xlsx';
                }
                if(strtolower($newType[1]) == 'monitoring transaksi'){
                    $fileName   = 'laporan-monitoring-transaksi-'. ($request['sd_pc_status'] == 'R' ? 'sukses-' : 'gagal-') . $date . '.xlsx';
                }
                if(strtolower($newType[1]) == 'fee'){
                    $fileName   = 'laporan-fee-transaksi-'. $date . '.xlsx';
                }
            }
        }else{
            if(strtolower($newType[0]) == 'lsbu'){
                if(strtolower($newType[1]) == 'daftar rekening'){
                    $fileName   = 'laporan-daftar-rekening-'. $date . '.pdf';
                }
                if(strtolower($newType[1]) == 'pendaftaran'){
                    $fileName   = 'laporan-pendaftaran-'. $date . '.pdf';
                }
                if(strtolower($newType[1]) == 'penutupan'){
                    $fileName   = 'laporan-penutupan-'. $date . '.pdf';
                }
                if(strtolower($newType[1]) == 'monitoring transaksi'){
                    $fileName   = 'laporan-monitoring-transaksi-'. ($request['sd_pc_status'] == 'R' ? 'sukses-' : 'gagal-') . $date . '.pdf';
                }
                if(strtolower($newType[1]) == 'fee'){
                    $fileName   = 'laporan-fee-transaksi-'. $date . '.pdf';
                }
            }
        }
        $extension = explode('.', $fileName);
        $dm = new SavdepDownloadManager();
        $dm->branch_code    = $branch_code;
        $dm->counted_record = $counted;
        $dm->document_type  = $type;
        $dm->path           = "app\\";
        $dm->filename       = $fileName;
        $dm->extension_file = '.' . $extension[1];
        $dm->save();
        if($export_type == '1'){
            //excel
            if(strtolower($newType[0]) == 'lsbu'){
                if(strtolower($newType[1]) == 'daftar rekening'){
                    $action = Excel::store(new DaftarRekeningExport($request), $fileName);
                }
                if(strtolower($newType[1]) == 'pendaftaran'){
                    $action = Excel::store(new PendaftaranExport($request), $fileName);
                }
                if(strtolower($newType[1]) == 'penutupan'){
                    $action = Excel::store(new PenutupanExport($request), $fileName);
                }
                if(strtolower($newType[1]) == 'monitoring transaksi'){
                    $action = Excel::store(new MonitoringTransaksiExport($request), $fileName);
                }
                if(strtolower($newType[1]) == 'fee'){
                    $action = Excel::store(new FeeAdminExport($request), $fileName);
                }
            }
        }else{
            //pdf
            if(strtolower($newType[0]) == 'lsbu'){
                if(strtolower($newType[1]) == 'daftar rekening'){
                    $records    = DB::table('savdep_product_customer_lsbu AS a')
                    ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                    ->where('a.sp_pc_status', $request['sd_pc_status'])
                    ->where('a.sp_pc_branch_reg', $branch_code)
                    ->where(function($query)use ($request){
                    $query->whereBetween('a.sp_pc_reg_date', [
                        $request['start_date'] ." 00:00:00", 
                        $request['end_date'] ." 23:59:59"
                    ]);
                    })
                    ->orderBy('a.sp_pc_reg_date', 'ASC')
                    ->get();
                    $rangeDate = (object)[
                      'start_date'    => date("d-m-Y", strtotime($request['start_date'])),
                      'end_date'      => date("d-m-Y", strtotime($request['end_date'])),
                    ];
                    $statusAutodebit = $request['sd_pc_status'];
                    $pdf = Pdf::loadView("/exports/pdf/daftar-rekening-lsbu", compact('records', 'rangeDate', 'statusAutodebit'));
                    $content = $pdf->download()->getOriginalContent();
                    file_put_contents(storage_path('app/'.$fileName), $content);
                }
                if(strtolower($newType[1]) == 'pendaftaran'){
                    $startDate  = $request['start_date'] ." 00:00:00";
                    $endDate    = $request['end_date'] ." 23:59:59";
                    $branchCode = $request['branch_code'];
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
                    $rangeDate = (object)[
                      'start_date'    => date("d-m-Y", strtotime($request['start_date'])),
                      'end_date'      => date("d-m-Y", strtotime($request['end_date'])),
                    ];
                    $pdf = Pdf::loadView("/exports/pdf/laporan-pendaftaran-lsbu", compact('records', 'rangeDate'))->setPaper('a3', 'landscape');
                    $content = $pdf->download()->getOriginalContent();
                    file_put_contents(storage_path('app/'.$fileName), $content);
                }
                if(strtolower($newType[1]) == 'penutupan'){
                    $startDate  = $request['start_date'] . " 00:00:00";
                    $endDate    = $request['end_date'] . " 23:59:59";
                    $branchCode = $request['branch_code'];
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
                    $rangeDate = (object)[
                      'start_date'    => date("d-m-Y", strtotime($request['start_date'])),
                      'end_date'      => date("d-m-Y", strtotime($request['end_date'])),
                    ];
                    $pdf = Pdf::loadView("/exports/pdf/laporan-penutupan-lsbu", compact('records', 'rangeDate'))->setPaper('a3', 'landscape');
                    $content = $pdf->download()->getOriginalContent();
                    file_put_contents(storage_path('app/'.$fileName), $content);
                }
                if(strtolower($newType[1]) == 'monitoring transaksi'){
                    $branchCode     = $request['branch_code'];
                    $statusRc       = $request['sd_pc_status'];
                    $startDate      = $request['start_date'] ." 00:00:00";
                    $endDate        = $request['end_date'] ." 23:59:59";
                    $startNominal   = str_replace('.', '', $request['nominal_start']);
                    $endNominal     = str_replace('.', '', $request['nominal_end']);
                    
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

                    $rangeDate = (object)[
                      'start_date'    => date("d-m-Y", strtotime($request['start_date'])),
                      'end_date'      => date("d-m-Y", strtotime($request['end_date'])),
                      'start_nominal' => $startNominal,
                      'end_nominal'   => $endNominal
                    ];

                    $sd_pc_status = $request['sd_pc_status'];
                    $pdf = Pdf::loadView("/exports/pdf/monitoring-transaksi-lsbu", compact('records', 'rangeDate', 'sd_pc_status'))->setPaper('a3', 'landscape');
                    $content = $pdf->download()->getOriginalContent();
                    file_put_contents(storage_path('app/'.$fileName), $content);
                }
                if(strtolower($newType[1]) == 'fee'){
                    $records    = DB::table('savdep_transactions AS a')
                    ->leftJoin('savdep_product_customer_lsbu AS b', 'a.sd_t_dep_acc', '=', 'b.sd_pc_dst_extacc')
                    ->leftJoin('sys_branches AS c', 'b.sp_pc_branch_reg', '=', 'c.code')
                    ->select('c.code AS kode_cabang', 'c.name AS nama_cabang', 'c.group_branch AS kode_induk', 'c.kc_name as cabang_induk', 'a.sd_t_pid AS produk', 'a.sd_t_src_acc AS eksternal_sumber', 'b.sp_pc_src_name AS nama_pemilik', 'a.sd_t_dep_acc AS eksternal_tujuan', 'a.sd_t_amount as setoran_bulanan', 'a.sd_t_dt AS tanggal_debet', 'b.sp_pc_period AS total_periode', 'a.sd_t_settle_date AS jatuh_tempo', 'a.sd_t_fee AS fee')
                    ->where([
                      ['a.sd_t_pid', '=', 'LSBU'],
                      ['b.sp_pc_branch_reg', '=', $request['branch_code']]
                    ])
                    ->where(function($query) use($request) {
                      $query->whereBetween('a.sd_t_dt', [$request['start_date'] ." 00:00:00", $request['end_date'] . " 23:59:59"]);
                    })
                    ->get();
                    $rangeDate = (object)[
                      'start_date'    => date("d-m-Y", strtotime($request['start_date'])),
                      'end_date'      => date("d-m-Y", strtotime($request['end_date'])),
                    ];
                    $pdf = Pdf::loadView("/exports/pdf/fee-transaksi-lsbu", compact('records', 'rangeDate'))->setPaper('a3', 'landscape');
                    $content = $pdf->download()->getOriginalContent();
                    file_put_contents(storage_path('app/'.$fileName), $content);
                }
            }
        }
    }
}