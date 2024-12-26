<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;

class ApprovalExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $columns    = $this->request->fields;
    $pencarian  = $this->request->pencarian ? $this->request->pencarian : '';
    $status     = $this->request->sd_pc_status ? $this->request->sd_pc_status : '';

    if($pencarian != '' && $status != ''){
      $conditions = 1; //export by pencarian and status
    }else if($pencarian != '' && $status == ''){
      $conditions = 2; //export by pencarian only
    }else if($pencarian == '' && $status != ''){
      $conditions = 3; //export by status only
    }else{
      $conditions = 4; //export without conditions
    }

    $records = DB::table('savdep_product_customer_lsbu AS a')
    ->leftJoin('savdep_products AS b', 'a.sd_pc_id', '=', 'b.sp_p_id');
    if($conditions == 1){
      $records->where('a.sd_pc_status', '=', $status)
      ->where(function($records) use ($pencarian) {
        $records->where("a.sd_pc_dst_extacc", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_dst_name", "ilike", "%$pencarian%")
        ->orWhere("b.sp_p_name", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_period_date", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_period", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_reg_date", "ilike", "%$pencarian%");
      });
    }else if($conditions == 3){
      $records->where('a.sd_pc_status', '=', $status);
    }else if($conditions == 2){
      $records->where(function($records) use ($pencarian) {
        $records->where("a.sd_pc_dst_extacc", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_dst_name", "ilike", "%$pencarian%")
        ->orWhere("b.sp_p_name", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_period_date", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_period", "ilike", "%$pencarian%")
        ->orWhere("a.sd_pc_reg_date", "ilike", "%$pencarian%");
      });
    }else{
    }
    $records->orderBy('a.id', 'asc')->get();
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
