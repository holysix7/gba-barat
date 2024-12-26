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

class PendaftaranExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
  public $request;

  public function __construct($request){
    $this->request = $request;
  }

  public function title(): string{
    return 'LAPORAN PEMBUKAAN LSBU AUTODEBET';
  }

  public function columnFormats(): array{
    return [
      'J' => NumberFormat::FORMAT_NUMBER,
      'G' => NumberFormat::FORMAT_NUMBER
    ];
  }

  public function collection(){
    $request = $this->request;   
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
    $data = [];
    $no = 1;
    foreach ($records as $record) {
      $data[] = [
        'no'              => $no,
        'kode_cabang'     => $record->kode_cabang,
        'nama_cabang'     => $record->nama_cabang,
        'kode_induk'      => $record->kode_induk,
        'cabang_induk'    => $record->cabang_induk,
        'produk'          => $record->produk,
        'rekening_sumber' => $record->rekening_sumber,
        'tipe_rek_tujuan' => $record->tipe_rek_tujuan,
        'nama_nasabah'    => $record->nama_nasabah,
        'rek_tujuan'      => $record->rek_tujuan,
        'jangka_waktu'    => $record->jangka_waktu,
        'setoran_bulanan' => $record->setoran_bulanan,
        'tanggal_debet'   => $record->tanggal_debet,
        'jatuh_tempo'     => $record->jatuh_tempo
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
      'Tanggal Pendebetan',
      'Jatuh Tempo'
    ];

    return $fields;
  }
}