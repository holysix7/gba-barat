<?php

namespace App\Exports;

use App\Models\IuranRt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class IuranRtExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  private $request; 

  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $data = IuranRt::ajax($this->request);
    return collect($data->records);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $fields = [
      'No',
      'Bulan',
      'Tahun',
      'RT',
      'Ketua RT',
      'Tagihan',
      'Status Bayar',
    ];

    return $fields;
  }
}
