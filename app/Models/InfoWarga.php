<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InfoWarga extends Model
{
    protected $table = 'info_warga';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public static function ajax($start, $limit)
    {
        $query = Self::where('isactive', true)
            ->with(['user'])
            ->orderBy('created_at', 'desc');
    
        $counted = $query->count();
    
        $data = $query->skip($start)->take($limit)->get();
    
        return [
            'counted' => $counted,
            'data'    => $data,
        ];
    }
    
    public static function create($request){
        try {
            DB::beginTransaction();

            $foto_arr = null;
            if ($request->hasFile('foto')) {
                $foto_arr = handleUploadFileWithPath($request->file('foto'), 'src/Timeline');
            }
            $data = new self();
            $data->judul = $request->judul;
            $data->deskripsi = $request->deskripsi;
            $data->created_by = getUserLoginId();
            $data->foto     = data_get($foto_arr, 'path');
            $data->save();
            
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}