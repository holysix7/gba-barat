<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\ProductPeriod;

class JangkaWaktuController extends Controller
{
    public function index(){
        // dd(getPermissions(Session::get('role')->id, 'create'));
        return view('setting.jangka-waktu.index');
    }
    
    public function ajax(Request $request){
        if($request->search){
            $search = $request->search;
            $query      = DB::table('savdep_product_period AS a')
            ->select('a.sd_pp_code', 'a.sd_pp_desc', 'a.created_at', 'a.updated_at')
            ->where(function($query) use($search){
                $query->where('a.sd_pp_code', 'ilike', "%$search%")
                ->orWhere('a.sd_pp_code', 'ilike', "%$search%")
                ->orWhere('a.created_at', 'ilike', "%$search%")
                ->orWhere('a.sd_pp_desc', 'ilike', "%$search%");
            });
            $resCount   = ProductPeriod::where('a.sd_pp_code', 'ilike', "%$search%")
                ->orWhere('a.sd_pp_code', 'ilike', "%$search%")
                ->orWhere('a.created_at', 'ilike', "%$search%")
                ->orWhere('a.sd_pp_desc', 'ilike', "%$search%")
                ->count();
        }else{
            $query      = DB::table('savdep_product_period AS a')
            ->select('a.sd_pp_code', 'a.sd_pp_desc', 'a.created_at', 'a.updated_at')
            ->skip($request->start)
            ->take($request->length)
            ->orderBy('a.sd_pp_code', 'asc');
            $resCount   = ProductPeriod::all()->count();
        }
        $result     = $query->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->rownum        = ++$no;
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $result
        ];
    
        return response()->json($response);

    }

    public function new(){
        return view('setting.jangka-waktu.index');
    }

    public function create(Request $request){
        $validations = ProductPeriod::where('sd_pp_code', strtoupper($request->sd_pp_code))->first();
        
        if(empty($validations)){
            $record                     = new ProductPeriod();
            $record->sd_pp_code         = strtoupper($request->sd_pp_code);
            $record->sd_pp_desc         = $request->sd_pp_desc;
            $record->created_by         = Session::get('user')->userId;
            $record->created_at         = date('Y-m-d H:i:s');

            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_product_period', 'General', Route::current()->getName());
                $message    = 'Berhasil menyimpan data!';
                $alert      = 'success';
            }else{
                $message    = 'Gagal menyimpan data!';
                $alert      = 'danger';
            }
        }else{
            $message    = 'Gagal menyimpan data dikarenakan id tersebut sudah digunakan, harap coba kembali!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.jangkawaktu')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = ProductPeriod::where('sd_pp_code', $request->sd_pp_code)->first();
        return response()->json($record);
    }

    public function update(Request $request){
        $record                     = ProductPeriod::where('sd_pp_code', $request->sd_pp_code)->first();
        $record->sd_pp_desc         = $request->sd_pp_desc;
        $record->updated_by         = Session::get('user')->userId;
        $record->updated_at         = date('Y-m-d H:i:s');
        
        if($record->save()){
            $attributes             = $record->getAttributes();
            $originals              = $record->getOriginal();
            $this->logActivityUpdate($attributes, $originals);
            $message    = 'Berhasil merubah data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal merubah data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.jangkawaktu')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function delete(Request $request){
        $record = ProductPeriod::where('sd_pp_code', $request->sd_pp_code)->first();
        if($record->delete()){
            userActivities('Delete', 'Menghapus data: ' . $request->sd_pp_code, 'savdep_product_period', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.jangkawaktu')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }
    
    /**
     * Log Activity
     */

    Public function logActivityUpdate($attributes, $originals){
        $originals['created_at'] = date('Y-m-d H:i:s');
        $originals['updated_at'] = date('Y-m-d H:i:s');
        
        $field = '';
        foreach($attributes as $key => $value){
            foreach($originals as $oKey => $oValue){
                if($key != 'created_at' && $oKey != 'created_at' && $key != 'updated_at' && $oKey != 'updated_at'){
                    if($key == $oKey){
                        if($value != $oValue){
                            $field = $field != '' ? $field . ', ' . $key : $field . $key;
                        }
                    }
                }
            }
        }

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_product_period', 'General', Route::current()->getName());
    }
}
