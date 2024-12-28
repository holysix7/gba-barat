<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RwTransaction extends Model
{
    protected $table = 'rw_transactions';
    protected $primaryKey   = 'id';
    use HasFactory;

    public static function formattedData($request){
        $skip       = data_get($request, 'start');
        $take       = data_get($request, 'length');
        $records    = self::skip($skip)->take($take)->get();
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

    public static function ajax($request){
        $records    = self::formattedData($request);
        $result     = (object)[
            'resCount'  => count($records),
            'records'   => $records
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

    public static function debit($request){
        $rw             = new self();
        $rw->name       = $request->name;
        $rw->nominal    = $request->nominal;
        $rw->is_debit   = true;
        $rw->is_kredit  = false;
        $rw->save();

        $keuangan           = Keuangan::first();
        $keuangan->saldo    = $keuangan->saldo + $request->nominal;
        $keuangan->save();
    }

    public static function kredit($request){
        $rw             = new self();
        $rw->name       = $request->name;
        $rw->nominal    = $request->nominal;
        $rw->is_debit   = false;
        $rw->is_kredit  = true;
        $rw->save();

        $keuangan           = Keuangan::first();
        $keuangan->saldo    = $keuangan->saldo - $request->nominal;
        $keuangan->save();
    }
}