<?php

namespace App\Exports\Autodebit\LSBU;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMapping;

use App\Models\SavdepTransaction;


class MonitoringExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [
      'B' => NumberFormat::FORMAT_NUMBER,
    ];
}

  public function collection(){
    $query = DB::table('savdep_transactions')
                    ->join('savdep_product_customer_lsbu', 'savdep_transactions.sd_t_dep_acc', '=', 'savdep_product_customer_lsbu.sd_pc_dst_extacc')
                    ->select('savdep_transactions.*','savdep_product_customer_lsbu.sp_pc_dst_name');

    $type = $this->request->type;
    $query->where('savdep_transactions.sd_t_pid', $type);

    $date = explode('|', $this->request->date);

    $search = $this->request->search;
    if(!is_null($search)){
        $query->where('savdep_transactions.sd_t_dep_acc', "ilike", "%$search%")
            ->orWhere('savdep_product_customer_lsbu.sp_pc_dst_name', "ilike", "%$search%");
    }
    
    if(strlen($date[0]) > 0 && strlen($date[1]) > 0){
        $query->whereDate('savdep_transactions.sd_t_dt', '>=', "$date[0] 00:00:00");
        $query->whereDate('savdep_transactions.sd_t_dt', '<=', "$date[1] 23:59:59");
    } elseif(strlen($date[0]) > 0 && strlen($date[1] < 1)){
        $query->whereDate('savdep_transactions.sd_t_dt', '=', "$date[0]");
    }

    $status = $this->request->status_category;
    if($status == "Sukses") {
        $query->where('savdep_transactions.sd_t_rc', '=', '0000')
            ->orWhere('savdep_transactions.sd_t_rc', '=', 'R');
    } else {
        $query->where('savdep_transactions.sd_t_rc', '=', '0004')
            ->orWhere('savdep_transactions.sd_t_rc', '=', 'F');
    }

    $query->orderBy('savdep_transactions.sd_t_dt', 'DESC');
    
    $data = [];
    $no = 1;
    if($status == "Gagal"){
        foreach ($query->get() as $record) {
            $data[] = [
                'no'                => $no++,
                'sd_t_dep_acc'      => $record->sd_t_dep_acc,
                'sp_pc_dst_name'      => $record->sp_pc_dst_name,
                'sd_t_period'       => $record->sd_t_period,
                'sd_t_dt'           => $record->sd_t_dt,
                'sd_t_amount'       => $record->sd_t_amount,
            ];
        }
    } else {
        foreach ($query->get() as $record) {
            $data[] = [
                'no'                => $no++,
                'sd_t_dep_acc'      => $record->sd_t_dep_acc,
                'sp_pc_dst_name'      => $record->sp_pc_dst_name,
                'sd_t_pid'          => $record->sd_t_pid,
                'sd_t_amount'       => $record->sd_t_amount,
                'sd_t_dt'           => $record->sd_t_dt,
            ];
        }
    }

    return collect($data);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $status = $this->request->status_category;

    if($status == "Gagal"){
        $fields = [
            'No',
            'No Rekening',
            'Nama Pemegang Rekening',
            'Bulan Gagal Debit',
            'Tanggal Gagal Autodebit',
            'Jumlah',
        ];   
    } else {
        $fields = [
            'No',
            'No Rekening',
            'Nama Pemegang Rekening',
            'Produk',
            'Jumlah Terdebit',
            'Tanggal Autodebit'
        ];
    } 
    return $fields;
  }
}
