<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepProductSpdefAccbank;

class SetupRekeningController extends Controller
{
    public function index(){
        return view('setting.setup-rekening.index');
    }

    public function ajax(Request $request){
        $sql      = DB::table('savdep_product_spdef_accbank AS a');
        if($request->search){
            $search = $request->search;
            $sql = $sql->where(function($query) use($search){
                $query->where('a.sd_psa_type', 'ilike', "%$search%")
                ->orWhere('a.sd_psa_implement_type', 'ilike', "%$search%")
                ->orWhere('a.sd_psa_int_acc', 'ilike', "%$search%");
            });
        }else{
            $sql = $sql->skip($request->start)
            ->take($request->length);
        }
        $resCount   = $sql->count();
        $result     = $sql->get();
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

    public function new(Request $request){
        return view('setting.setup-rekening.index');
    }

    public function create(Request $request){
        $validations    = SavdepProductSpdefAccbank::where('sd_psa_type', $request->sd_psa_type)->first();
        if(empty($validations)){
            $validationImplement = SavdepProductSpdefAccbank::where('sd_psa_implement_type', strtoupper($request->sd_psa_implement_type))->first();
            if(empty($validationImplement)){
                $record                         = new SavdepProductSpdefAccbank();
                $record->sd_psa_type            = strtoupper($request->sd_psa_type);
                $record->sd_psa_implement_type  = strtoupper($request->sd_psa_implement_type);
                $record->sd_psa_int_acc         = $request->sd_psa_int_acc;
                $record->sd_psa_status          = 1;
                if($record->save()){
                    userActivities('Create', 'Menambahkan data', 'savdep_product_spdef_accbank', 'General', Route::current()->getName());
                    $message    = 'Berhasil menambahkan data!';
                    $alert      = 'success';
                }else{
                    $message    = 'Gagal menambahkan data!';
                    $alert      = 'danger';
                }
            }else{
                $message    = 'Gagal menambahkan data karena data dengan kode implement'. strtoupper($request->sd_psa_implement_type) .' sudah digunakan!';
                $alert      = 'danger';
            }
        }else{
            $message    = 'Gagal menambahkan data karena data dengan kode tersebut sudah digunakan!';
            $alert      = 'danger';
        }

        return redirect()->route('setting.setuprekening')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = SavdepProductSpdefAccbank::where('sd_psa_type', $request->sd_psa_type)->first();
        return response()->json($record);
    }

    public function update(Request $request){
        $record                         = SavdepProductSpdefAccbank::where('sd_psa_type', $request->sd_psa_type)->first();
        $record->sd_psa_implement_type  = strtoupper($request->sd_psa_implement_type);
        $record->sd_psa_int_acc         = $request->sd_psa_int_acc;
        $attributes = $record->getAttributes();
        $originals  = $record->getOriginal();

        if($record->save()){
            $this->logActivityUpdate($attributes, $originals);
            $message    = 'Berhasil merubah data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal merubah data!';
            $alert      = 'danger';
        }

        return redirect()->route('setting.setuprekening')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function delete(Request $request){
        $record                         = SavdepProductSpdefAccbank::where('sd_psa_type', $request->sd_psa_type)->first();        
        if($record->delete()){
            userActivities('Delete', 'Menghapus data: ' . $request->sd_psa_implement_type, 'savdep_product_spdef_accbank', 'General', Route::current()->getName());
            $message    = 'Berhasil menghapus data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal menghapus data!';
            $alert      = 'danger';
        }

        return redirect()->route('setting.setuprekening')->with([
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'sys_roles', 'General', Route::current()->getName());
    }
}
