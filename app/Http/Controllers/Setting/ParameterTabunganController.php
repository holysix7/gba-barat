<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\SavdepProduct;
use App\Models\SavdepGroupAccount;
use App\Models\SavdepProductSpdefAccbank;
use App\Models\SavdepProductSpdef;

class ParameterTabunganController extends Controller
{
    public function index(){
        return view('setting.parameter-tabungan.index');
    }
    
    public function ajax(Request $request){
        $sql      = DB::table('savdep_product AS a');
        if($request->search){
            $search = $request->search;
            $sql = $sql->where(function($query) use($search){
                $query->where('a.sd_p_id', 'ilike', "%$search%")
                ->orWhere('a.sd_p_name', 'ilike', "%$search%")
                ->orWhere('a.sp_p_min_init_amount', 'ilike', "%$search%")
                ->orWhere('a.sp_p_min_period_amount', 'ilike', "%$search%")
                ->orWhere('a.sp_p_max_period_amount', 'ilike', "%$search%")
                ->orWhere('a.sp_p_denom_period_amount', 'ilike', "%$search%")
                ->orWhere('a.sp_p_min_period', 'ilike', "%$search%")
                ->orWhere('a.sp_p_max_period', 'ilike', "%$search%")
                ->orWhere('a.sp_p_max_period_fail', 'ilike', "%$search%")
                ->orWhere('a.sp_p_period_fail_penalty', 'ilike', "%$search%")
                ->orWhere('a.sp_p_mid_term_penalty', 'ilike', "%$search%")
                ->orWhere('a.sp_p_deposit_acc_type', 'ilike', "%$search%")
                ->orWhere('a.sp_p_closing_scheme', 'ilike', "%$search%")
                ->orWhere('a.sp_p_interest', 'ilike', "%$search%")
                ->orWhere('a.sp_p_admin', 'ilike', "%$search%")
                ->orWhere('a.sp_p_currency', 'ilike', "%$search%")
                ->orWhere('a.sp_p_product_status', 'ilike', "%$search%")
                ->orWhere('a.sp_p_period_fail_penalty_acc', 'ilike', "%$search%")
                ->orWhere('a.sp_p_mid_term_penalty_acc', 'ilike', "%$search%")
                ->orWhere('a.sp_p_admin_acc', 'ilike', "%$search%")
                ->orWhere('a.created_at', 'ilike', "%$search%")
                ->orWhere('a.updated_at', 'ilike', "%$search%")
                ->orWhere('a.sp_p_acc_bjbs', 'ilike', "%$search%");
            });
        }else{
            $query      = DB::table('savdep_product AS a')
            ->skip($request->start)
            ->take($request->length)
            ->orderBy('a.created_at', 'desc');
        }
        $resCount   = $sql->count();
        $result     = $sql->get();
        $no         = $request->start;
        foreach($result as $row){
            $row->rownum        = ++$no;
            $row->id            = Crypt::encrypt($row->sd_p_id);
            $row->route         = route('setting.parametertabungan.edit', $row->id);
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
        $record['groupAccounts'] = SavdepGroupAccount::all();
        $record['productSpdefs'] = SavdepProductSpdef::where('sd_ps_implement_type', 'SCAD')->get();
        // dd($record['productSpdefs'][0]->subprocess);
        return view('setting.parameter-tabungan.index', compact('record'));
    }

    public function create(Request $request){
        $validations = SavdepProduct::where('sd_p_id', strtoupper($request->sp_p_id))->first();
        
        if(empty($validations)){
            $record                                 = new SavdepProduct();
            $record->sd_p_id                        = strtoupper($request->sp_p_id);
            $record->sd_p_name                      = $request->sp_p_name;
            $record->sp_p_admin                     = $request->sp_p_admin;
            $record->sp_p_admin_acc                 = $request->sp_p_admin_acc;
            $record->sp_p_min_init_amount           = $request->sp_p_min_init_amount;
            $record->sp_p_min_period                = $request->sp_p_min_period;
            $record->sp_p_min_period_amount         = $request->sp_p_min_period_amount;
            $record->sp_p_max_period                = $request->sp_p_max_period;
            $record->sp_p_max_period_amount         = $request->sp_p_max_period_amount;
            $record->sp_p_group_account             = $request->sp_p_group_account;
            $record->sp_p_period_fail_penalty       = $request->sp_p_period_fail_penalty;
            $record->sp_p_denom_period_amount       = $request->sp_p_denom_period_amount;
            $record->sp_p_period_fail_penalty_acc   = $request->sp_p_period_fail_penalty_acc;
            $record->sp_p_mid_term_penalty          = $request->sp_p_mid_term_penalty;
            $record->sp_p_mid_term_penalty_acc      = $request->sp_p_mid_term_penalty_acc;
            $record->sp_p_max_period_fail           = $request->sp_p_max_period_fail;
            $record->sp_p_closing_scheme            = $request->sp_p_closing_scheme;
            $record->sp_p_currency                  = $request->sp_p_currency;
            $record->sp_p_external_admin            = $request->sp_p_external_admin;
            $record->sp_p_product_status            = $request->sp_p_product_status;
            $record->created_at                     = date('Y-m-d H:i:s');
            if($record->save()){
                userActivities('Create', 'Menambahkan data', 'savdep_product', 'General', Route::current()->getName());
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
        
        return redirect()->route('setting.parametertabungan')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function edit($id){
        $record['current']       = SavdepProduct::where('sd_p_id', 'ilike', Crypt::decrypt($id))->first();
        // dd($record['current']->sp_p_external_admin);
        $record['groupAccounts'] = SavdepGroupAccount::all();
        $record['productSpdefs'] = SavdepProductSpdef::all();

        return view('setting.parameter-tabungan.index', compact('record'));
    }

    public function update(Request $request){
        $record                                 = SavdepProduct::where('sd_p_id', Crypt::decrypt(request()->segment(4)))->first();
        $record->sd_p_id                        = $request->sd_p_id;
        $record->sd_p_name                      = $request->sd_p_name;
        $record->sp_p_min_init_amount           = $request->sp_p_min_init_amount;
        $record->sp_p_min_period_amount         = $request->sp_p_min_period_amount;
        $record->sp_p_max_period_amount         = $request->sp_p_max_period_amount;
        $record->sp_p_denom_period_amount       = $request->sp_p_denom_period_amount;
        $record->sp_p_min_period                = $request->sp_p_min_period;
        $record->sp_p_max_period                = $request->sp_p_max_period;
        $record->sp_p_max_period_fail           = $request->sp_p_max_period_fail;
        $record->sp_p_period_fail_penalty       = $request->sp_p_period_fail_penalty;
        $record->sp_p_mid_term_penalty          = $request->sp_p_mid_term_penalty;
        $record->sp_p_deposit_acc_type          = $request->sp_p_deposit_acc_type;
        $record->sp_p_closing_scheme            = $request->sp_p_closing_scheme;
        $record->sp_p_interest                  = $request->sp_p_interest;
        $record->sp_p_admin                     = $request->sp_p_admin;
        $record->sp_p_currency                  = $request->sp_p_currency;
        $record->sp_p_product_status            = $request->sp_p_product_status;
        $record->sp_p_period_fail_penalty_acc   = $request->sp_p_period_fail_penalty_acc;
        $record->sp_p_mid_term_penalty_acc      = $request->sp_p_mid_term_penalty_acc;
        $record->sp_p_admin_acc                 = $request->sp_p_admin_acc;
        $record->sp_p_group_account             = $request->sp_p_group_account;
        $record->sp_p_external_admin            = $request->sp_p_external_admin;
        $record->updated_at                     = date('Y-m-d H:i:s');
        
        if($record->save()){
            $attributes                         = $record->getAttributes();
            $originals                          = $record->getOriginal();
            $this->logActivityUpdate($attributes, $originals);
            $message    = 'Berhasil merubah data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal merubah data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.parametertabungan')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function show(Request $request){
        $record = SavdepProduct::where('sd_p_id', Crypt::decrypt($request->id))->first();
        return response()->json($record);
    }

    public function delete(Request $request){
        // dd($request->id);
        $record = SavdepProduct::where('sd_p_id', $request->id)->first();
        $record->sp_p_product_status = '0';
        if($record->save()){
            userActivities('Soft Delete', 'Menghapus data: ' . $request->id .' (soft)', 'savdep_product', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan delete data!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan delete data!';
            $alert      = 'danger';
        }
        
        return redirect()->route('setting.parametertabungan')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function ajax_new(Request $request){
        $data           = SavdepProductSpdef::where('sd_ps_abstract_type', $request->type)->first();
        if($data){
            if($data->sd_ps_implement_type){
                $records    = SavdepProductSpdefAccbank::where('sd_psa_implement_type', $data->sd_ps_implement_type)->get();
                $status     = 200;
                foreach($records as $record){
                    $record->subprocess = $record->subprocess;
                }
                $productSpdefs = SavdepProductSpdef::all();
                foreach($productSpdefs as $productSpdef){
                    $productSpdef->subprocess = $productSpdef->subprocess;
                }
            }else{
                $status     = 400;
                $records    = [];
            }
        }
        $result         = [
            'status'        => $status,
            'data'          => $records,
            'productSpdefs' => $productSpdefs
        ];
        return response()->json($result);
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_product', 'General', Route::current()->getName());
    }
}