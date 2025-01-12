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
        return $this->hasOne(Auth::class, 'user_id', 'id')->with(['role']);
    }

    public function rt(){
        return $this->belongsTo(Rt::class, 'rt_id', 'id');
    }
    
    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function families(){
        return $this->hasMany(Family::class, 'user_id', 'id');
    }

    public static function getAllWarga($pencarian, $start, $take){
        $warga = User::with([
            'auth.role',
            'address',
            'rt',
            'families' => function ($query) {
                $query->orderBy('tgl_lahir', 'asc');
            }
        ]);

        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $warga = $warga->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%'])
                    ->orWhereHas('address', function ($q2) use ($pencarian) {
                        $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
                    })
                    ->orWhereHas('rt', function ($q2) use ($pencarian) {
                        $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
                    })
                    ->orWhereRaw('LOWER(no_telp) LIKE ?', ['%' . strtolower($pencarian) . '%']);
            });
        }
        $counted_rows = $warga->count();
        if(!is_null($start) && !is_null($take)){
            $warga = $warga->skip($start)->take($take);
        }

        $warga = $warga->get();

        return [
            'resCount' => $counted_rows,
            'records' => self::formatList($warga)
        ];
    }

    public static function ajax($request, $type = null){
        $rt      = data_get($request, 'rt');
        if(!is_null($rt) || !isEmpty($rt)){
            $rt = str_replace('rt0', '', $rt);
        }

        if($rt === 'rw'){
            $data = self::getAllWarga(data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
        }else{
            if($type === 'kepala_keluarga'){
                $data = self::getKepalaKeluarga($rt, data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
            }else{
                $data = self::getWarga($rt, data_get($request, 'search.value'), data_get($request, 'start'), data_get($request, 'length'));
            }
        }
        // var_dump($data['records']); die;
        $result = (object)[
            'resCount'  => data_get($data, 'resCount', 0),
            'records'   => data_get($data, 'records', [])
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
        $counted_rows = $warga->count();
        if(!is_null($start) && !is_null($take)){
            $warga = $warga->skip($start)->take($take);
        }

        $warga = $warga->get();

        return [
            'resCount' => $counted_rows,
            'records' => self::formatList($warga)
        ];
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
        $counted_rows = $warga->count();
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

        return [
            'resCount' => $counted_rows,
            'records' => self::formatList($warga)
        ];
    }

    public static function formatList($warga, $has_family = true){
        $data   = [];
        $no     = 1;
        foreach($warga as $index => $row){
            if(data_get($row, 'address.name')){
                $address = data_get($row, 'address.name');
                if(data_get($row, 'address.status_rumah')){
                    $address .= ' ('. data_get($row, 'address.status_rumah') .')';
                }
            }else{
                $address = data_get($row, 'user.address.name');
                if(data_get($row, 'user.address.status_rumah')){
                    $address .= ' ('. data_get($row, 'user.address.status_rumah') .')';
                }
            }
            $data[$index] = [
                'no'              => $no,
                'rt'              => data_get($row, 'rt.name', data_get($row, 'user.rt.name')),
                'no_kk'           => $row->no_kk,
                'kepala_keluarga' => $row->kepala_keluarga ? true : false,
                'name'            => $row->name,
                'tgl_lahir'       => data_get($row, 'tgl_lahir'),
                'jenis_kelamin'   => data_get($row, 'jenis_kelamin'),
                'address'         => $address,
                'no_telp'         => data_get($row, 'no_telp'),
                'status_ktp'      => data_get($row, 'status_ktp'),
                'families'        => []
            ];
            $no++;
            $no_families = 1;
            if($has_family && !is_null(data_get($row, 'families'))){
                foreach($row->families as $family){
                    $data[$index]['families'][] = [
                        'no'              => $no_families,
                        'rt'              => data_get($row, 'rt.name', data_get($row, 'user.rt.name')),
                        'no_kk'           => $row->no_kk,
                        'kepala_keluarga' => $family->kepala_keluarga ? true : false,
                        'name'            => $family->name,
                        'tgl_lahir'       => data_get($family, 'tgl_lahir'),
                        'jenis_kelamin'   => data_get($family, 'jenis_kelamin'),
                        'address'         => $address,
                        'no_telp'         => data_get($family, 'no_telp', '-'),
                        'status_ktp'      => data_get($row, 'status_ktp'),
                    ];
                    $no_families++;
                }
            }
        }
        return $data;
    }
}
