<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepEq;

class SetupEqController extends Controller
{
    public function index(){
        return view('setting.setup-eq.index');
    }
    
    public function ajax(Request $request){
        $sql      = DB::table('savdep_eq AS a');
        if($request->search){
            $search = $request->search;
            $sql = $sql->where(function($query) use($search){
                $query->where('a.sd_e_id', 'ilike', "%$search%")
                ->orWhere('a.sd_e_name', 'ilike', "%$search%")
                ->orWhere('a.sd_e_merchant_code', 'ilike', "%$search%")
                ->orWhere('a.sd_e_debit_code', 'ilike', "%$search%")
                ->orWhere('a.sd_e_credit_code', 'ilike', "%$search%")
                ->orWhere('a.sd_e_audit_id', 'ilike', "%$search%")
                ->orWhere('a.sd_e_branch_code', 'ilike', "%$search%")
                ->orWhere('a.sd_e_supervisor_user', 'ilike', "%$search%")
                ->orWhere('a.sd_e_authority_user', 'ilike', "%$search%")
                ->orWhere('a.sd_e_description', 'ilike', "%$search%")
                ->orWhere('a.sd_e_created_at', 'ilike', "%$search%");
            });
        }else{
            $sql      = DB::table('savdep_eq AS a')
            ->skip($request->start)
            ->take($request->length)
            ->orderBy('a.sd_e_created_at', 'desc');
        }
        $resCount   = $sql->count();
        $result     = $sql->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->rownum        = ++$no;
            $row->encrypt_id    = Crypt::encrypt($row->sd_e_id);
            $row->route         = route('setting.setupeq.edit', $row->encrypt_id);
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
        return view('setting.setup-eq.index');
    }

    public function create(Request $request){
        $validations = SavdepEq::where('sd_e_id', strtoupper($request->sd_e_id))->first();
        
        if(empty($validations)){
            $record                                 = new SavdepEq();
            $record->sd_e_id                        = $request->sd_e_id;
            $record->sd_s_name                      = $request->sd_s_name;
            $record->sd_s_start_time                = $request->sd_s_start_time;
            $record->sd_s_end_time                  = $request->sd_s_end_time;
            $record->sd_s_description               = $request->sd_s_description;
            $record->sd_s_status                    = $request->sd_s_status;
            $record->created_by                     = Session::get('user')->userId;
            $record->sd_e_created_at                     = date('Y-m-d H:i:s');
            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_eq', 'General', Route::current()->getName());
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
        
        return redirect()->route('setting.setupeq')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function update(Request $request){
        $record                     = SavdepEq::where('sd_e_id', $request->sd_e_id)->first();
        $record->sd_e_name          = $request->sd_e_name;
        $record->sd_e_debit_code    = $request->sd_e_debit_code;
        $record->sd_e_credit_code   = $request->sd_e_credit_code;
        $record->sd_e_description   = $request->sd_e_description;
        $record->sd_e_updated_at    = date('Y-m-d H:i:s');
        
        if($record->save()){
            $attributes = $record->getAttributes();
            $originals  = $record->getOriginal();
            $this->logActivityUpdate($attributes, $originals);
            $message    = 'Berhasil merubah data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal merubah data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.setupeq')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = SavdepEq::where('sd_e_id', Crypt::decrypt($request->sd_e_id))->first();
        return response()->json($record);
    }

    public function delete(Request $request){
        $record = SavdepEq::where('sd_e_id', $request->sd_e_id)->first();
        if($record->delete()){
            userActivities('Delete', 'Menghapus data: ' . $request->sd_e_id, 'savdep_eq', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.setupeq')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    /**
     * Log Activity
     */

    Public function logActivityUpdate($attributes, $originals){
        $originals['sd_e_created_at'] = date('Y-m-d H:i:s');
        $originals['sd_e_updated_at'] = date('Y-m-d H:i:s');
        
        $field = '';
        foreach($attributes as $key => $value){
            foreach($originals as $oKey => $oValue){
                if($key != 'sd_e_created_at' && $oKey != 'sd_e_created_at' && $key != 'sd_e_updated_at' && $oKey != 'sd_e_updated_at'){
                    if($key == $oKey){
                        if($value != $oValue){
                            $field = $field != '' ? $field . ', ' . $key : $field . $key;
                        }
                    }
                }
            }
        }

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_eq', 'General', Route::current()->getName());
    }
}
