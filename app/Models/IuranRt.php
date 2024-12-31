<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class IuranRt extends Model
{
    protected $table = 'rt';
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

        $records = self::getIuran(data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));

        $result = (object)[
            'resCount'  => count($records),
            'records'   => $records
        ];
        return $result;
    }

    public static function getIuran($pencarian, $start, $take){
        $iuran = Self::with(['rt']);

        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $iuran = $iuran->where(function ($query) use ($pencarian) {
                $query->rt->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%'])
                ->orWhereRaw('rt LIKE ?', ['%'. strtolower($pencarian) .'%']);
            });
        }
        
        if(!is_null($start) && !is_null($take)){
            $iuran = $iuran->skip($start)->take($take);
        }

        return $iuran->get();
    }
}