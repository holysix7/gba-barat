<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class DataWargaExport implements FromCollection, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithEvents
{
  private $request; 

  public function __construct($request){
    $this->request = $request;
  }

  public function columnFormats(): array{
    return [];
  }

  public function collection(){
    $data = User::ajax($this->request);
    return collect($data->records);
  }

  public function registerEvents(): array{
    return [];
  }

  public function headings(): array{
    $fields = [
      'No',
      'RT',
      'No Kartu Keluarga',
      'Kepala Keluarga',
      'Nama',
      'Tanggal Lahir',
      'Jenis Kelamin',
      'Alamat',
      'No Telepon (WA)',
    ];

    return $fields;
  }
}
