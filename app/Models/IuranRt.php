<?php

namespace App\Models;

use App\Http\Libraries\Security;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class IuranRt extends Model
{
    protected $table = 'iuran_rt';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function rt(){
        return $this->hasOne(Rt::class, 'id', 'rt_id');
    }

    public static function ajax($request){
        $rt      = data_get($request, 'rt');
        if(!is_null($rt) || !isEmpty($rt)){
            $rt = str_replace('rt', '', $rt);
        }

        $data = self::getIuran($request);

        $result = (object)[
            'resCount'  => data_get($data, 'resCount', 0),
            'records'   => data_get($data, 'records', [])
        ];
        return $result;
    }

    public static function getIuran($request){
        $pencarian  = data_get($request, 'search.value');
        $start      = data_get($request, 'start');
        $take       = data_get($request, 'length');
        $filter     = !is_null(data_get($request, 'filter')) ? json_decode(data_get($request, 'filter')) : null;
        $iuran      = Self::with(['rt']);
        $month      = null;
        $year       = null;
        if(!is_null(data_get($filter, 'month')) && !is_null(data_get($filter, 'year'))){
            $month = intval(data_get($filter, 'month'));
            $year = intval(data_get($filter, 'year'));
            $iuran = $iuran->where('bulan', $month)
            ->where('tahun', $year);
        }
        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $iuran = $iuran->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%'])
                    ->orWhereHas('rt', function ($q2) use ($pencarian) {
                        $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
                    });
            });
        }
        $counted_rows = $iuran->count();
        if(!is_null($start) && !is_null($take)){
            $iuran = $iuran->skip($start)->take($take);
        }

        $no     = 1;
        $data   = [];
        $iuran  = $iuran->get();
        foreach($iuran as $row){
            $data[] = [
                'no'            => $no,
                'bulan'         => $month,
                'tahun'         => $year,
                'rt_id'         => Security::encryptId($row->id),
                'rt'            => data_get($row, 'rt.name'),
                'ketua_rt'      => data_get($row, 'rt.getKetuaRt.name'),
                'tagihan'       => getRupiah($row->nominal),
                'status_bayar'  => $row->status_bayar ? 'Sudah Bayar' : 'Belum Bayar',
            ];
            $no++;
        }

        return [
            'resCount' => $counted_rows,
            'records' => $data,
        ];
    }

    public static function getRow($request){
        $id     = Security::decryptId($request[0]->rt_id);
        return self::find($id);
    }
}