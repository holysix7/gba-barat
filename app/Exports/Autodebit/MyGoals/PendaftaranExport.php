<?php

namespace App\Exports\Autodebit\MyGoals;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;

class PendaftaranExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $columns    = $this->request->fields;
    $start_date = $this->request->start_date;
    $end_date   = $this->request->end_date;
    if($start_date){
      $records = DB::table('savdep_product_customer_mygoals AS a')
      ->leftJoin('savdep_products AS b', 'a.sd_pc_id', '=', 'b.sp_p_id')
      ->where(function($query){
        $query->where('a.sd_pc_status', 1)
        ->orWhere('a.sd_pc_status', 5)
        ->orWhere('a.sd_pc_status', 9);
      })
      ->whereBetween('a.sd_pc_reg_date', ["$start_date 00:00:00", "$end_date 23:59:59"])
      ->orderBy('a.id', 'asc')->get();
    }else{
      $records = DB::table('savdep_product_customer_mygoals AS a')
      ->leftJoin('savdep_products AS b', 'a.sd_pc_id', '=', 'b.sp_p_id')
      ->where(function($query){
        $query->where('a.sd_pc_status', 1)
        ->orWhere('a.sd_pc_status', 5)
        ->orWhere('a.sd_pc_status', 9);
      })
      ->orderBy('a.id', 'asc')->get();
    }
    $data = [];
    $no = 1;
    foreach ($records as $record) {
      $data[] = [
        'no'                => $no,
        'sd_pc_dst_extacc'  => $record->sd_pc_dst_extacc,
        'sd_pc_dst_name'    => $record->sd_pc_dst_name,
        'sp_p_name'         => $record->sp_p_name,
        'sd_pc_period_date' => $record->sd_pc_period_date,
        'sd_pc_period'      => $record->sd_pc_period,
        'sd_pc_status'      => $record->sd_pc_status,
        'sd_pc_reg_date'    => $record->sd_pc_reg_date
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
      'No Rekening',
      'Nama Pemegang Rekening',
      'Produk',
      'Tanggal Debet',
      'Periode',
      'Status',
      'Buka Rekening'
    ];

    return $fields;
  }
}
