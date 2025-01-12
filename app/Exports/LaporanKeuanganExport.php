<?php

namespace App\Exports;

use App\Models\RwTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LaporanKeuanganExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  private $request; 

  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $data = RwTransaction::getExport();
    return collect($data);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $fields = [
      'No',
      'Tanggal',
      'Deskripsi',
      'Debit',
      'Kredit',
      'Total',
    ];

    return $fields;
  }
}
