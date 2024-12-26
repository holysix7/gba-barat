<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table        = 'users';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function auth(){
        return $this->hasOne(Auth::class, 'user_id', 'id');
    }
    
    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function families(){
        return $this->hasMany(Family::class, 'user_id', 'id');
    }

    public static function getWargaByRt($rt){
        $warga = self::where('rt', $rt)
        ->with(['auth.role', 'address', 'families' => function ($query) {
            $query->orderBy('tgl_lahir', 'asc');
        },])
        ->get();

        $data = [];
        foreach($warga as $row){
            $data_rt = [
                'name' => $row->name,
                'no_telp' => $row->no_telp,
                'tgl_lahir' => $row->tgl_lahir,
                'jenis_kelamin' => $row->jenis_kelamin,
                'address' => $row->address
            ];
            array_push($data, $data_rt);
            foreach($row->families as $family){
                $data_keluarga = [
                    'name' => $family->name,
                    'no_telp' => $family->no_telp,
                    'tgl_lahir' => $family->tgl_lahir,
                    'jenis_kelamin' => $family->jenis_kelamin,
                    'address' => $row->address
                ];
                array_push($data, $data_keluarga);
            }
        }
        return $data;
    }
}
