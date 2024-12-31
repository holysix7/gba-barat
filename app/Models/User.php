<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class User extends Model
{
    protected $table        = 'users';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function auth(){
        return $this->hasOne(Auth::class, 'user_id', 'id');
    }

    public function rt(){
        return $this->hasOne(Rt::class, 'id', 'rt_id');
    }
    
    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function families(){
        return $this->hasMany(Family::class, 'user_id', 'id');
    }

    public static function getAllWarga($pencarian, $start, $take){
        $warga = User::with(['auth.role', 'address', 'families' => function ($query) {
            $query->orderBy('tgl_lahir', 'asc');
        }]);

        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $warga = $warga->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%'])
                ->orWhereRaw('rt LIKE ?', ['%'. strtolower($pencarian) .'%']);
            });
        }
        
        if(!is_null($start) && !is_null($take)){
            $warga = $warga->skip($start)->take($take);
        }

        $warga = $warga->get();
        return self::formatList($warga);
    }

    public static function ajax($request, $type = null){
        $rt      = data_get($request, 'rt');
        if(!is_null($rt) || !isEmpty($rt)){
            $rt = str_replace('rt0', '', $rt);
        }
// var_dump($rt); die;
        if($rt === 'rw'){
            $records = self::getAllWarga(data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
        }else{
            if($type === 'kepala_keluarga'){
                $records = self::getKepalaKeluarga($rt, data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
            }else{
                $records = self::getWarga($rt, data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
            }
        }
        $result = (object)[
            'resCount'  => count($records),
            'records'   => $records
        ];
        return $result;
    }

    public static function getKepalaKeluarga($rt = null, $pencarian = null, $start = null, $take = null){
        $warga = User::with(['auth.role', 'address']);

        if(!is_null($rt) || !isEmpty($rt)){
            $warga = $warga->where('rt_id', $rt);
        }

        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $warga = $warga->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
            });
        }
        
        if(!is_null($start) && !is_null($take)){
            $warga = $warga->skip($start)->take($take);
        }

        $warga = $warga->get();

        return self::formatList($warga, false);
    }

    public static function getWarga($rt = null, $pencarian = null, $start = null, $take = null){
        $warga = User::with(['auth.role', 'address', 'families' => function ($query) {
            $query->orderBy('tgl_lahir', 'asc');
        }]);

        if(!is_null($rt) || !isEmpty($rt)){
            $warga = $warga->where('rt_id', $rt);
        }

        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $warga = $warga->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
            });
        }
        
        if(!is_null($start) && !is_null($take)){
            $warga = $warga->skip($start)->take($take);
        }

        $warga = $warga->get();

        $has_family = true;
        if($warga->isEmpty()){
            $has_family = false;
            $warga = Family::whereRaw('LOWER(name) LIKE ?', ['%'. $pencarian .'%']);
            if(!is_null($start) && !is_null($take)){
                $warga = $warga->skip($start)->take($take);
            }
            $warga = $warga->get();
        }

        return self::formatList($warga, $has_family);
    }

    public static function formatList($warga, $has_family = true){
        $data   = [];
        $no     = 1;
        foreach($warga as $row){
            $data[] = [
                'no'              => $no,
                'rt'              => data_get($row, 'rt.name', data_get($row, 'user.rt.name')),
                'no_kk'           => $row->no_kk,
                'kepala_keluarga' => $row->kepala_keluarga ? true : false,
                'name'            => $row->name,
                'tgl_lahir'       => data_get($row, 'tgl_lahir'),
                'jenis_kelamin'   => data_get($row, 'jenis_kelamin'),
                'address'         => data_get($row, 'address.name', data_get($row, 'user.address.name')),
                'no_telp'         => data_get($row, 'no_telp'),
            ];
            $no++;
            if($has_family && !is_null(data_get($row, 'families'))){
                foreach($row->families as $family){
                    $data[] = [
                        'no'              => $no,
                        'rt'              => data_get($row, 'rt.name', data_get($row, 'user.rt.name')),
                        'no_kk'           => $row->no_kk,
                        'kepala_keluarga' => $family->kepala_keluarga ? true : false,
                        'name'            => $family->name,
                        'tgl_lahir'       => data_get($family, 'tgl_lahir'),
                        'jenis_kelamin'   => data_get($family, 'jenis_kelamin'),
                        'address'         => data_get($row, 'address.name', data_get($row, 'user.address.name')),
                        'no_telp'         => data_get($family, 'no_telp', '-'),
                    ];                
                    $no++;
                }
            }
        }
        return $data;
    }
}
