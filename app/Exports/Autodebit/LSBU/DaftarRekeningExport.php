<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DaftarRekeningExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  public $request;
  
  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){ 
    $request = $this->request;   
    $sql    = DB::table('savdep_product_customer_lsbu AS a')
      ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
      ->where('a.sp_pc_status', $request['sd_pc_status'])
      ->where('a.sp_pc_branch_reg', $request['branch_code'])
      ->where(function($query)use ($request){
        $query->whereBetween('a.sp_pc_reg_date', [
          $request['start_date'] ." 00:00:00", 
          $request['end_date'] ." 23:59:59"
        ]);
      });
    $sql        = $sql->orderBy('a.sp_pc_reg_date', 'ASC');
    $records    = $sql->get();
    $data = [];
    $no = 1;
    foreach ($records as $record) {
      $data[] = [
        'no'                => $no,
        'sd_pc_dst_extacc'  => $record->sd_pc_dst_extacc,
        'sp_pc_dst_name'    => $record->sp_pc_dst_name,
        'sd_p_name'         => $record->sd_p_name,
        'sp_pc_period_date' => $record->sp_pc_period_date,
        'sp_pc_period'      => $record->sp_pc_period,
        'sp_pc_status'      => $record->sp_pc_status,
        'sp_pc_reg_date'    => $record->sp_pc_reg_date
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
