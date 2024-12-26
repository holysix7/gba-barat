<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepGroupAccount;
use App\Models\SavdepGroupAccountType;
use App\Models\SavdepProductAccType;

class GroupAccountController extends Controller
{
    public function index(){
        return view('setting.group-account.index');
    }
    
    public function ajax(Request $request){
        $sql      = DB::table('savdep_group_account AS a');
        if($request->search){
            $search = $request->search;
            $sql    = $sql->where(function($query) use($search){
                $query->where('a.sd_ga_id', 'ilike', "%$search%")
                ->orWhere('a.sd_ga_name', 'ilike', "%$search%")
                ->orWhere('a.created_at', 'ilike', "%$search%");
            });
        }else{
            $sql      = DB::table('savdep_group_account AS a')
            ->select('a.sd_ga_id', 'a.sd_ga_name', 'a.sd_ga_desc', 'a.created_at', 'a.updated_at')
            ->orderBy('a.created_at', 'desc');
        }
        $resCount   = $sql->count();
        $sql        = $sql->skip($request->start)->take($request->length);
        $result     = $sql->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->rownum        = ++$no;
            $row->routedetail   = route('setting.groupaccount.shows', Crypt::encrypt($row->sd_ga_id));
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
        return view('setting.group-account.index');
    }

    public function create(Request $request){
        $sdGaId = generateRandomString(15);
        $validations = SavdepGroupAccount::where('sd_ga_id', strtoupper($request->sd_ga_id))->first();
        if(empty($validations)){
            $record                     = new SavdepGroupAccount();
            $record->sd_ga_id           = strtoupper($request->sd_ga_id);
            $record->sd_ga_name         = ucwords($request->sd_ga_name);
            $record->sd_ga_desc         = $request->sd_ga_desc;

            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_group_account', 'General', Route::current()->getName());
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
        
        return redirect()->route('setting.groupaccount')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show_ajax(Request $request){
        $record = SavdepGroupAccount::where('sd_ga_id', $request->sd_ga_id)->first();
        return response()->json($record);
    }

    public function update(Request $request){
        $record                     = SavdepGroupAccount::where('sd_ga_id', $request->sd_ga_id)->first();
        $record->sd_ga_name         = ucwords($request->sd_ga_name);
        $record->sd_ga_desc         = $request->sd_ga_desc;
        
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
        
        return redirect()->route('setting.groupaccount')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function delete(Request $request){
        $record = SavdepGroupAccount::where('sd_ga_id', $request->sd_ga_id)->first();
        if($record->delete()){
            userActivities('Delete', 'Menghapus data: ' . $request->sd_ga_id, 'savdep_product_periods', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.groupaccount')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show($params){
        $sdGaId     = Crypt::decrypt($params);
        $record     = SavdepGroupAccount::where('sd_ga_id', $sdGaId)->first();
        $record->ajaxRoute = route('setting.groupaccount.shows', $params);
        //gat_type = 0 => ditolak; 1 => diizinkan
        //gat_type_rekening = 1 => sumber; 2 => tujuan 
        
        $recordGa   = SavdepGroupAccountType::select('sd_gat_aid')->where('sd_gat_gaid', $sdGaId)->get();
        $recordAcc  = SavdepProductAccType::all();
        $groups     = [];
        $types      = [];
        $filtered   = [];
        $after      = [];
        foreach($recordGa as $row){
            array_push($groups, $row->sd_gat_aid);
        }
        foreach($recordAcc as $rowAcc){
            array_push($types, $rowAcc->sd_pat_pid);
        }
        foreach($types as $row){
            if(!in_array($row, $groups)){
                array_push($after, $row);
            }
        }
        
        foreach($after as $row){
            $accRow  = SavdepProductAccType::where('sd_pat_pid', $row)->first();
            array_push($filtered, $accRow);
        }
        // dd($filtered);
        return view('setting.group-account.index', compact('record', 'filtered'));
    }

    public function ajax_type($params, Request $request){
        $sql        = SavdepGroupAccountType::where('sd_gat_gaid', Crypt::decrypt($params));
        $resCount   = $sql->count();
        $sql        = $sql->skip($request->start)->take($request->length);
        $result     = $sql->get();
        foreach($result as $row){
            $row->sd_pat_acc_type = $row->acc_type['sd_pat_acc_type'];
        }
        $no         = $request->start;
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $result
        ];
        return response()->json($response);
    }

    public function delete_type($params, Request $request){
        $sql    = 'DELETE FROM savdep_group_account_type WHERE sd_gat_gaid = ? AND sd_gat_aid = ?';
        if(DB::delete($sql, [$params, $request->sd_gat_aid])){
            $message    = 'Berhasil menghapus data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal menghapus data!';
            $alert      = 'danger';
        }
        
        return redirect()->back()->with([
            'message'   => $message,
            'alert-type'=> $alert
        ]);
    }
    
    public function ajax_shows_type($params, Request $request){
        $record     = SavdepGroupAccountType::select('sd_gat_aid')->where('sd_gat_gaid', $request->sd_ga_id)->get();
        $recordAcc  = SavdepProductAccType::all();
        $groups     = [];
        $types      = [];
        $filtered   = [];
        $after      = [];
        foreach($record as $row){
            array_push($groups, $row->sd_gat_aid);
        }
        foreach($recordAcc as $rowAcc){
            array_push($types, $rowAcc->sd_pat_pid);
        }
        foreach($types as $row){
            if(!in_array($row, $groups)){
                array_push($after, $row);
            }
        }
        
        foreach($after as $row){
            $accRow  = SavdepProductAccType::where('sd_pat_pid', $row)->first();
            array_push($filtered, $accRow);
        }
        $data       = [
            "filtered" => $filtered
        ];
        
        return response()->json($data);
    }

    public function create_type(Request $request){
        $record     = new SavdepGroupAccountType();
        $record->sd_gat_gaid            = $request->sd_gat_gaid;
        $record->sd_gat_aid             = $request->sd_gat_aid;
        $record->sd_gat_type            = $request->sd_gat_type;
        $record->sd_gat_type_rekening   = $request->sd_gat_type_rekening;
        if($record->save()){
            $message    = 'Berhasil menyimpan data';
            $alert      = 'success';
        }else{
            $message    = 'Gagal menyimpan data';
            $alert      = 'danger';
        }

        return redirect()->back()->with([
            'message'   => $message,
            'alert-type'=> $alert
        ]);
    }

    public function update_type(Request $request){
        // $record     = SavdepGroupAccountType::where([
        //     ['sd_gat_gaid', $request->sd_gat_gaid],
        //     ['sd_gat_aid', explode(' ', $request->sd_gat_aid)[0]]
        // ])->first();
        // $record->sd_gat_type            = intval($request->sd_gat_type);
        // $record->sd_gat_type_rekening   = $request->sd_gat_type_rekening;
        $sql    = 'UPDATE savdep_group_account_type SET sd_gat_type = ?, sd_gat_type_rekening = ? WHERE sd_gat_gaid = ? AND sd_gat_aid = ?';
        if(DB::update($sql, [intval($request->sd_gat_type), $request->sd_gat_type_rekening, $request->sd_gat_gaid, explode(' ', $request->sd_gat_aid)[0]])){
            $message    = 'Berhasil merubah data';
            $alert      = 'success';
        }else{
            $message    = 'Gagal merubah data';
            $alert      = 'danger';
        }

        return redirect()->back()->with([
            'message'   => $message,
            'alert-type'=> $alert
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_group_account', 'General', Route::current()->getName());
    }
}