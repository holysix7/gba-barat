<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoWarga extends Model
{
    protected $table = 'info_warga';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public static function ajax($request){
        $counted = Self::where('isactive', true)->count();

        $data = Self::where('isactive', true)
        ->with(['user'])
        ->orderBy('created_at', 'desc')
        ->skip($request->start)
        ->take(20)
        ->get();

        return [
            'counted' => $counted,
            'data' => $data
        ];
    }
}