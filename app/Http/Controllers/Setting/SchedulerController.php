<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepScheduler;

class SchedulerController extends Controller
{
    public function index(){
        return view('setting.scheduler.index');
    }
    
    public function ajax(Request $request){
        $sql      = DB::table('savdep_scheduler AS a');
        if($request->search){
            $search = $request->search;
            $sql = $sql->where(function($query) use($search){
                $query->where('a.sd_s_id', 'ilike', "%$search%")
                ->orWhere('a.sd_s_start_time', 'ilike', "%$search%")
                ->orWhere('a.sd_s_end_time', 'ilike', "%$search%")
                ->orWhere('a.sd_s_description', 'ilike', "%$search%")
                ->orWhere('a.sd_s_created_at', 'ilike', "%$search%")
                ->orWhere('a.sd_s_name', 'ilike', "%$search%");
            });
        }else{
            $sql = $sql->skip($request->start)
            ->take($request->length)
            ->orderBy('a.sd_s_created_at', 'desc');
        }
        $resCount   = $sql->count();
        $result     = $sql->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->rownum        = ++$no;
            $row->encrypt_id    = Crypt::encrypt($row->sd_s_id);
            $row->route         = route('setting.scheduler.edit', $row->encrypt_id);
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
        return view('setting.scheduler.index');
    }

    public function create(Request $request){
        $validations = SavdepScheduler::where('sd_s_id', strtoupper($request->sd_s_id))->first();
        
        if(empty($validations)){
            $record                                 = new SavdepScheduler();
            $record->sd_s_id                        = $request->sd_s_id;
            $record->sd_s_name                      = $request->sd_s_name;
            $record->sd_s_start_time                = $request->sd_s_start_time;
            $record->sd_s_end_time                  = $request->sd_s_end_time;
            $record->sd_s_description               = $request->sd_s_description;
            $record->sd_s_status                    = $request->sd_s_status;
            // dd($record);
            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_scheduler', 'General', Route::current()->getName());
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
        
        return redirect()->route('setting.scheduler')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function edit($sd_s_id){
        $record['current']      = SavdepScheduler::where('sd_s_id', Crypt::decrypt($sd_s_id))->first();
        return view('setting.scheduler.index', compact('record'));
    }

    public function update(Request $request){
        $record                                 = SavdepScheduler::where('sd_s_id', Crypt::decrypt(request()->segment(4)))->first();
        // dd([$request->all(), $record]);
        $record->sd_s_id                        = $request->sd_s_id;
        $record->sd_s_name                      = $request->sd_s_name;
        $record->sd_s_start_time                = $request->sd_s_start_time;
        $record->sd_s_end_time                  = $request->sd_s_end_time;
        $record->sd_s_description               = $request->sd_s_description;
        $record->sd_s_status                    = $request->sd_s_status;
        
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
        
        return redirect()->route('setting.scheduler')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = SavdepScheduler::where('sd_s_id', Crypt::decrypt($request->sd_s_id))->first();
        return response()->json($record);
    }

    public function delete(Request $request){
        $record = SavdepScheduler::where('sd_s_id', $request->sd_s_id)->first();
        if($record->delete()){
            userActivities('Delete', 'Menghapus data: ' . $request->sd_s_id, 'savdep_scheduler', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.scheduler')->with([
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_scheduler', 'General', Route::current()->getName());
    }
}
