<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MonitoringTransaksiExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
  public $request;

  public function __construct($request){
    $this->request = $request;
  }
  
  public function title(): string{
    $request = $this->request;
    if($request['sd_pc_status'] == 'R'){
      $nextTitle = 'Transaksi Sukses';
    }else{
      $nextTitle = 'Transaksi Gagal';
    }
    return $nextTitle;
  }

  public function columnFormats(): array{
    return [
      'C' => NumberFormat::FORMAT_NUMBER,
      'I' => NumberFormat::FORMAT_NUMBER,
      'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
    ];
  }

  public function collection(){
    $request    = $this->request;   
    $branchCode = $request['branch_code'];
    $statusRc   = $request['sd_pc_status'];
    $startDate  = $request['start_date'] ." 00:00:00";
    $endDate    = $request['end_date'] ." 23:59:59";
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
    
    $data = [];
    $no = 1;
    if($statusRc == 'R'){
      foreach ($records as $record) {
        $data[] = [
          'no'              => $no,
          'kode_cabang'     => $record->kode_cabang,
          'nama_cabang'     => $record->nama_cabang,
          'kode_induk'      => $record->kode_induk,
          'cabang_induk'    => $record->cabang_induk,
          'produk'          => $record->produk,
          'eksternal_sumber'=> $record->eksternal_sumber,
          'nama_pemilik'    => $record->nama_pemilik,
          'eksternal_tujuan'=> $record->eksternal_tujuan,
          'setoran_bulanan' => $record->setoran_bulanan,
          'tanggal_debet'   => $record->tanggal_debet,
          'total_periode'   => $record->total_periode,
          'jatuh_tempo'     => $record->jatuh_tempo,
          'fee'             => $record->fee
        ];
        $no++;
      }
    }else{
      foreach ($records as $record) {
        switch ($record->keterangan_gagal){
          case 'KSM5363':
            $keterangan = 'Account Inactive';
            break;
          
          case 'KSM0125':
            $keterangan = 'Account Blocked';
            break;

          case('KSM5362'):
            $keterangan = 'Account Closed';
            break;

          case 'KSM5417':
            $keterangan = 'Balance Not Available';
            break;
          
          case 'KSM2133':
            $keterangan = 'Negative Amount Not Allowed';
            break;

          case 'KSM4955':
            $keterangan = 'Amount Must Be Greater Than Zero';
            break;
          
          default:
            $keterangan = 'General Error';
            break;
        }
        $data[] = [
          'no'                => $no,
          'kode_cabang'       => $record->kode_cabang,
          'nama_cabang'       => $record->nama_cabang,
          'kode_induk'        => $record->kode_induk,
          'cabang_induk'      => $record->cabang_induk,
          'produk'            => $record->produk,
          'rek_sumber'        => $record->rek_sumber,
          'nama_pemilik'      => $record->nama_pemilik,
          'rek_tujuan'        => $record->rek_tujuan,
          'setoran_bulanan'   => $record->setoran_bulanan,
          'tanggal_debet'     => $record->tanggal_debet,
          'periode_gagal'     => $record->periode_gagal,
          'keterangan_gagal'  => $keterangan,
          'fee'               => $record->fee
        ];
        $no++;
      }
    }
    return collect($data);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $request    = $this->request;   
    $statusRc   = $request['sd_pc_status'];
    if($statusRc == 'R'){   
      $fields = [
        'No',
        'Kode Cabang',
        'Nama Cabang',
        'Kode Induk',
        'Cabang Induk',
        'Produk',
        'Eksternal Sumber',
        'Nama Pemilik',
        'Eksternal Tujuan',
        'Setoran Bulanan',
        'Tanggal Debet',
        'Total Periode',
        'Jatuh Tempo',
        'Fee'
      ];
    }else{
      $fields = [
        'No',
        'Kode Cabang',
        'Nama Cabang',
        'Kode Induk',
        'Cabang Induk',
        'Produk',
        'Rekening Sumber',
        'Nama Pemilik',
        'Rekening Tujuan',
        'Setoran Bulanan',
        'Tanggal Debet',
        'Periode Gagal',
        'Keterangan Gagal',
        'Fee'
      ];
    }

    return $fields;
  }
}