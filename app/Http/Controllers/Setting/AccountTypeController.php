<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductAccType;

class AccountTypeController extends Controller
{
    public function index(){
        return view('setting.account-type.index');
    }

    public function ajax(Request $request){
        if($request->search){
            $search = $request->search;
            $query      = DB::table('savdep_product_acc_type AS a')
            ->select('a.sd_pat_pid', 'a.sd_pat_acc_type', 'a.sd_pat_type')
            ->where(function($q) use($search){
                $q->where('a.sd_pat_pid', 'ilike', "%$search%")
                ->orWhere('a.sd_pat_acc_type', 'ilike', "%$search%");
            });
        }else{
            $query      = DB::table('savdep_product_acc_type AS a')
            ->select('a.sd_pat_pid', 'a.sd_pat_acc_type', 'a.sd_pat_type')
            ->skip($request->start)
            ->take($request->length);
        }
        $resCount   = SavdepProductAccType::all()->count();
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
        return view('setting.account-type.index');
    }

    public function create(Request $request){
        $sdPatId        = generateRandomString(16);
        $validations    = SavdepProductAccType::where('sd_pat_pid', $sd_pat_pid)->first();
        if(empty($validations)){
            $record                     = new SavdepProductAccType();
            $record->sd_pat_pid         = strtoupper($request->sd_pat_pid);
            $record->sd_pat_acc_type    = $request->sd_pat_acc_type;

            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_product_acc_type', 'General', Route::current()->getName());
                $message    = 'Berhasil menambahkan data!';
                $alert      = 'success';
            }else{
                $message    = 'Gagal menambahkan data!';
                $alert      = 'danger';
            }
        }else{
            $message    = 'Gagal menambahkan data karena data dengan kode tersebut sudah digunakan!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.accounttype')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = SavdepProductAccType::where('sd_pat_pid', $request->sd_pat_pid)->first();
        return response()->json($record);
    }

    public function update(Request $request){
        $record                     = SavdepProductAccType::where('sd_pat_pid', $request->sd_pat_pid)->first();
        $record->sd_pat_acc_type    = $request->sd_pat_acc_type;
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
        
        return redirect()->route('setting.accounttype')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function delete(Request $request){
        $record                     = SavdepProductAccType::where('sd_pat_pid', $request->sd_pat_pid)->first();
        if($record->delete()){
            userActivities('Delete', 'Menghapus data ' . $request->sd_pat_pid, 'savdep_product_periods', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan soft delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan soft delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.accounttype')->with([
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_product_acc_type', 'General', Route::current()->getName());
    }
}
