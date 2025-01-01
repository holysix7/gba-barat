<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $table = 'rt';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'rt_id', 'id');
    }
    
    public function getKetuaRt(){
        return $this->belongsTo(User::class, 'ketua_rt', 'id');
    }
}