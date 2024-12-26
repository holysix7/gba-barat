<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\ViewFeeLsbu;

class FeeAdminExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
  public $request;

  public function __construct($request){
    $this->request = $request;
  }

  public function title(): string{
    return 'LAPORAN FEE LSBU';
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $request = $this->request;   

    $records = DB::table('savdep_transactions AS a')
      ->leftJoin('savdep_product_customer_lsbu AS b', 'a.sd_t_dep_acc', '=', 'b.sd_pc_dst_extacc')
      ->leftJoin('sys_branches AS c', 'b.sp_pc_branch_reg', '=', 'c.code')
      ->select('c.code AS kode_cabang', 'c.name AS nama_cabang', 'c.group_branch AS kode_induk', 'c.kc_name as cabang_induk', 'a.sd_t_pid AS produk', 'a.sd_t_src_acc AS eksternal_sumber', 'b.sp_pc_src_name AS nama_pemilik', 'a.sd_t_dep_acc AS eksternal_tujuan', 'a.sd_t_amount as setoran_bulanan', 'a.sd_t_dt AS tanggal_debet', 'b.sp_pc_period AS total_periode', 'a.sd_t_settle_date AS jatuh_tempo', 'a.sd_t_fee AS fee')
      ->where([
        ['a.sd_t_pid', '=', 'LSBU'],
        ['b.sp_pc_branch_reg', '=', $request['branch_code']]
      ])
      ->where(function($query) use($request) {
        $query->whereBetween('a.sd_t_dt', [$request['start_date'] . " 00:00:00", $request['end_date'] . " 23:59:59"]);
      })
      ->get();
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
    return collect($data);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
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

    return $fields;
  }
}