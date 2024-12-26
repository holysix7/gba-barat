<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PenutupanExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
  public $request;

  public function __construct($request){
    $this->request = $request;
  }

  public function title(): string{
    return 'LAPORAN PENUTUPAN LSBU AUTODEBET';
  }

  public function columnFormats(): array{
    return [
      'J' => NumberFormat::FORMAT_NUMBER,
      'G' => NumberFormat::FORMAT_NUMBER
    ];
  }
  
  public function collection(){
    $request = $this->request;   
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
        sd_ct_dt");
    $data = [];
    $no = 1;
    foreach ($records as $record) {
      $data[] = [
        'no'                => $no,
        'kode_cabang'       => $record->kode_cabang,
        'nama_cabang'       => $record->nama_cabang,
        'kode_induk'        => $record->kode_induk,
        'cabang_induk'      => $record->cabang_induk,
        'produk'            => $record->produk,
        'rekening_sumber'   => $record->rekening_sumber,
        'jenis_rekening'    => $record->jenis_rekening,
        'nama_nasabah'      => $record->nama_nasabah,
        'rekening_tujuan'   => $record->rekening_tujuan,
        'jangka_waktu'      => $record->jangka_waktu,
        'setoran_bulanan'   => $record->setoran_bulanan,
        'tanggal_regis'     => $record->tanggal_regis,
        'jatuh_tempo'       => $record->jatuh_tempo,
        'tanggal_penutupan' => $record->tanggal_penutupan,
        'saldo_diterima'    => $record->saldo_diterima,
        'keterangan_tutup'  => $record->keterangan_tutup
      ];
      $no++;
    }
    return collect($data);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $fields = [
      'No',
      'Kode',
      'Cabang',
      'Kode Induk',
      'Cabang Induk',
      'Produk',
      'No. Rekening Tabungan Sumber Dana',
      'Jenis Rekening Tabungan Sumber Dana',
      'Nama Pemegang Rekening Tabungan Sumber Dana',
      'No Rekening Tujuan (BJBS)',
      'Jangka Waktu',
      'Setoran Bulanan',
      'Tanggal Pembukaan',
      'Tanggal Jatuh Tempo',
      'Tanggal Penutupan',
      'Saldo Yang Diterima',
      'Keterangan'
    ];

    return $fields;
  }
}