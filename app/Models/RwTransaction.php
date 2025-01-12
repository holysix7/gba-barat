<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwTransaction extends Model
{
    protected $table = 'rw_transactions';
    protected $primaryKey   = 'id';
    use HasFactory;

    public static function getExport(){
        $records    = self::where('isactive', true)->get();
        $data = [];
        $no = 1;
        foreach($records as $row){
            $data[] = [
                'no'        => $no++,
                'tanggal'   => $row->tanggal,
                'name'      => $row->name,
                'debit'     => data_get($row, 'is_debit') ? getRupiah($row->nominal) : getRupiah(0),
                'kredit'    => data_get($row, 'is_kredit') ? getRupiah($row->nominal) : getRupiah(0),
                'total'     => getRupiah($row->total)
            ];
        }

        return $data;
    }

    public static function formattedData($request){
        $skip       = data_get($request, 'start');
        $take       = data_get($request, 'length');
        $records    = self::where('isactive', true);
        $counted_rows = $records->count();
        $records    = $records->skip($skip)->take($take)->get();
        $data = [];
        $no = 1;
        foreach($records as $row){
            $data[] = [
                'no'        => $no++,
                'tanggal'   => $row->tanggal,
                'name'      => $row->name,
                'debit'     => data_get($row, 'is_debit') ? getRupiah($row->nominal) : getRupiah(0),
                'kredit'    => data_get($row, 'is_kredit') ? getRupiah($row->nominal) : getRupiah(0),
                'total'     => getRupiah($row->total)
            ];
        }

        return [
            'records' => $data,
            'resCount' => $counted_rows,
        ];
    }

    public static function ajax($request){
        $records    = self::formattedData($request);
        $result     = (object)[
            'resCount'  => data_get($records, 'resCount'),
            'records'   => data_get($records, 'records')
        ];
        return $result;
    }

    public static function transaction($request, $type){
        switch ($type) {
            case 'debit':
                return self::debit($request);
                break;
            case 'kredit':
                return self::kredit($request);
                break;
        }
    }

    protected static function debit($request){
        $keuangan           = Keuangan::first();
        $saldo              = $keuangan->saldo + data_get($request, 'nominal', 0);
        $keuangan->saldo    = $saldo;
        $keuangan->save();
        
        $rw             = new RwTransaction();
        $rw->name       = data_get($request, 'name');
        $rw->nominal    = data_get($request, 'nominal', 0);
        $rw->is_debit   = true;
        $rw->is_kredit  = false;
        $rw->tanggal    = date('Y-m-d');
        $rw->total      = $saldo;
        $rw->save();

        return $rw;
    }

    protected static function kredit($request){
        $keuangan           = Keuangan::first();
        $saldo              = $keuangan->saldo - data_get($request, 'nominal', 0);
        $keuangan->saldo    = $saldo;
        $keuangan->save();

        $rw             = new self();
        $rw->name       = data_get($request, 'name');
        $rw->nominal    = data_get($request, 'nominal', 0);
        $rw->is_debit   = false;
        $rw->is_kredit  = true;
        $rw->tanggal    = date('Y-m-d');
        $rw->total      = $saldo;
        $rw->save();

        return $rw;

    }
}