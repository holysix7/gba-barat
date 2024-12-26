<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepLsbuUpdate;
use App\Models\SavdepProduct;
use App\Models\SysRole as Role;
use App\Models\SysUser;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Illuminate\Support\Facades\Config;
use Illuminate\Encryption\Encrypter;

class ApprovalController extends Controller
{
    public function index(){
        $role   = Role::where('id', Session::get('role')->id)
        ->where('name', 'ilike', Config::get('app.reject_spv'))
        ->first();
        return view('autodebit.lsbu.approval.index', compact('role'));
    }

    public function ajax_approval(Request $request){
        $query    = DB::table('savdep_product_customer_lsbu AS a')
        ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id');
        $query = $query->where(function($query) use($request){
            $query->where('a.sp_pc_approval_status', $request->approval_type);
        });
        $query = $query->where('a.sp_pc_branch_reg', Session::get('user')->kodeCabang);

        if($request->search){
            $query = $query->where(function($q) use($request){
                $q->where('a.sp_pc_dst_name', 'ilike', "%$request->search%")
            ->orWhere('a.sd_pc_dst_extacc', 'ilike', "%$request->search%");
            });
        }

        $query      = $query->orderBy('a.sp_pc_reg_date', 'DESC');
        $resCount   = $query->count();
        $query      = $query->skip($request->start)->take($request->length);
        $records    = $query->get();
        $no         = $request->start;
        foreach($records as $row){
            $row->id            = Crypt::encrypt($row->sd_pc_dst_extacc);
            $row->routeshow     = route('autodebit.lsbu.approval.show', $row->id);
            $row->routeedit     = route('autodebit.lsbu.approval.edit', $row->id);
        }
        $response = [
            "search"            => $request->search ? $request->search : null,
            "approval_type"     => $request->approval_type ? $request->approval_type : null,
            "approval_status"   => $request->approval_status ? $request->approval_status : null,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }

    public function edit($params){
        $record = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
        $record->sp_pc_settle_date_format = date('d-M-Y', strtotime($record->sp_pc_settle_date));
        if($record->sp_pc_approval_status == 1){
            $record->sp_pc_approval_status_desc = 'Approval Pendaftaran';
        }else if($record->sp_pc_approval_status == 2){
            $record->sp_pc_approval_status_desc = 'Approval Perubahan';
        }else if($record->sp_pc_approval_status == 3){
            $record->sp_pc_approval_status_desc = 'Approval Penutupan';
        }else{
            $record->sp_pc_approval_status_desc = 'Rejected';
        }
        
        $recordProduct    = DB::table('savdep_product_customer_lsbu AS a')
            ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where('a.sd_pc_dst_extacc', Crypt::decrypt($params))
            ->first();
        $recordProduct->minimalJangkaWaktu = $recordProduct->sp_pc_current_period < $recordProduct->sp_p_min_period ? $recordProduct->sp_p_min_period : $recordProduct->sp_pc_current_period + 2;
        $recordProduct->minimalSetoran     = $recordProduct->sp_p_min_period_amount;
        // dd($recordProduct);
        $days = [];
        for($i = 1; $i <= 25; $i++){
            array_push($days, $i);
        }

        return view('autodebit.lsbu.approval.index', compact('record', 'recordProduct', 'days'));
    }

    public function update($params, Request $request){
        DB::beginTransaction();
        try {
            $record = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
            $record->sp_pc_period           = $request->sp_pc_period;
            $record->sp_pc_period_date      = $request->sp_pc_period_date;
            $record->sp_pc_period_amount    = str_replace('.', '', $request->sp_pc_period_amount);
            $record->sp_pc_approval_status  = '1';

            if($record->save()){
                $message    = 'Berhasil request perubahan data '. Crypt::decrypt($params) .' silahkan lakukan approval';
                $alert      = 'success';
                DB::commit();
            }else{
                $message    = 'Gagal melakukan perubahan data!';
                $alert      = 'danger';
                DB::rollback();
            }
        } catch (\Thrown $e){
            $message    = $e;
            $alert      = 'danger';
            DB::rollback();
        }


        return redirect()->route('autodebit.lsbu.approval')->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }

    public function show($params){
        $role   = Role::where('id', Session::get('role')->id)
        ->where('name', 'ilike', Config::get('app.reject_spv'))
        ->first();
        $record = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
        $record->sp_pc_settle_date_format = date('d-M-Y', strtotime($record->sp_pc_settle_date));
        $record->sp_pc_reg_date = date('d-M-Y', strtotime($record->sp_pc_reg_date));
        if($record->sp_pc_approval_status == 1){
            $record->sp_pc_approval_status_desc = 'Approval Pendaftaran';
        }else if($record->sp_pc_approval_status == 2){
            $record->sp_pc_approval_status_desc = 'Approval Penutupan Permintaan Nasabah';
        }else if($record->sp_pc_approval_status == 3){
            $record->sp_pc_approval_status_desc = 'Approval Penutupan Kesalahan Data';
        }else if($record->sp_pc_approval_status == 4){
            $record->sp_pc_approval_status_desc = 'Data Ditolak';
        }else{
            $record->sp_pc_approval_status_desc = 'Perubahan Data';
        }
        $days = [];
        for($i = 1; $i < 32; $i++){
            if($i < 10){
                $i = '0' . $i;
            }
            array_push($days, $i);
        }
        $record->update_lsbu = null;
        if($record->sp_pc_approval_status == '5'){
            $updateLsbu = SavdepLsbuUpdate::where('sd_pc_dst_extacc', $record->sd_pc_dst_extacc)->first();
            $record->update_lsbu = $updateLsbu;
        }
        $penutupan                  = date('Y-m-d', strtotime($record->sp_pc_settle_date));
        $registrasi                 = date('Y-m-d', strtotime($record->sp_pc_reg_date));
        $selisih                    = strtotime($penutupan) - strtotime($registrasi);
        $selisihBulan               = intval(ceil($selisih / ((60 * 60 * 24 * 365) / 12)));
        
        $penutupanBaru              = date('-M-Y', strtotime("+$record->sp_pc_period months", strtotime($record->sp_pc_reg_date)));
        $newTanggal                 = $record->sp_pc_period_date . $penutupanBaru;
        $tglRegistrasi              = date('d', strtotime($record->sp_pc_reg_date));
        $record->statusEditApproved = false;
        $record->dataEditApproved   = null;
        if($penutupan != $penutupanBaru || $record->sp_pc_period_date != $tglRegistrasi){
            $record->statusEditApproved = true;
            $record->dataEditApproved = (object)[
                'sp_pc_period' => $selisihBulan,
                'sp_pc_settle_date_format' => $record->sp_pc_period_date . $penutupanBaru
            ];
        }
        
        return view('autodebit.lsbu.approval.index', compact('record', 'days', 'role'));
    }

    public function checking_spv(Request $request){
        $encrypter  = new Encrypter('yasOkRpyKE7qsBLsbp0Im7TbkKq1jpgs', 'AES-256-CBC');
        $data       = [
            "userId"    => $request->username,
            "password"  => $encrypter->encrypt($request->password),
            "appId"     => 251
        ];
        $result = sendAPIUim($data);
        $conditions = $result->rc == '00' ? true : false;
        if($conditions){
            if($result->response){
                $response       = $result->response; 
                $role           = Role::where('id_fungsi', $response->idFungsi)->first();
                if($role){
                    $roleName = $role->name;
                    if(strtolower($roleName) == 'supervisor'){
                        if($request->approval_type == '2'){
                            $approvalType = 'Penutupan Permintaan Nasabah';
                        }else if($request->approval_type == '3'){
                            $approvalType = 'Penutupan Kesalahan Data';
                        }else if($request->approval_type == '5'){
                            $approvalType = 'Perubahan Data';
                        }else{
                            $approvalType = 'Pembukaan';
                        }
                        if($request->status == 'true'){
                            $result = $this->updateStatus(json_decode($request->id), $request->approval_type, $response->userId);
                            // return response()->json($result['status']);
                            $condition = 'approved';
                        }else{
                            $result = $this->updateStatusORM(json_decode($request->id), $request->sp_pc_rejected_notes, $response->userId);
                            $condition = 'rejected';
                        }

                        if($result['status']){
                            $type       = 'berhasil';
                            $status     = 200;
                        }else{
                            $type       = 'gagal';
                            $status     = 200;
                        }

                        $message    = $result['message'];
                    }else{
                        $message    = 'User tersebut bukan supervisor!';
                        $type       = 'gagal';
                        $status     = 200;
                    }
                }else{
                    $message    = 'User tersebut tidak memiliki role!';
                    $type       = 'gagal';
                    $status     = 200;
                }
            }else{
                $message    = 'Gagal approval, user tersebut tidak ditemukan!';
                $type       = 'gagal';
                $status     = 200;
            }
        }else{
            $message    = $result->rc . ": " . $result->message;
            $type       = 'gagal';
            $status     = 200;
        }

        return response()->json([
            'status'    => $status,
            'type'      => $type,
            'message'   => $message
        ], $status);
    }
    
    public function updateStatusORM($sd_pc_dst_extacc, $sp_pc_rejected_notes, $userId){
        DB::beginTransaction();
        try {
            foreach($sd_pc_dst_extacc as $row){
                $record = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', $row)->first();
                $record->sp_pc_approval_status  = $record->sp_pc_approval_status == '1' ? '4' : '0';
                $record->sp_pc_rejected_notes   = $sp_pc_rejected_notes;
                $record->sp_pc_update_by        = $userId;
                if(!$record->save()){
                    DB::rollback();
                    return [
                        'status' => false,
                        'message'=> 'Data gagal di reject'
                    ];
                }
            }
            DB::commit();
            return [
                'status' => true,
                'message'=> 'Data berhasil di reject'
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            return [
                'status' => false,
                'message'=> 'Data gagal di approved'
            ];
        }
    }

    /**
     * API BE Mba Novi
     */
    public function updateStatus($sd_pc_dst_extacc, $approval_type, $userId){
        $elements = [];
        foreach($sd_pc_dst_extacc as $row){
            if($approval_type == 1){
                $el = [
                    "ACCEXTDST" => $row
                ];
                $mt     = "2400";
                $type   = "registration";
            }elseif($approval_type == 5){
                $el = [
                    "ACCEXTDST" => $row,
                ];
                $mt = "4000";
                $type   = "edit";
            }else{
                $el = [
                    "ACCEXTDST" => $row,
                    "STATUS"    => $approval_type
                ];
                $mt = "2500";
                $type   = "closing";
            }
            array_push($elements, $el);
        }
        $data = [
            'USERID'    => $userId,
            'MC'        => "50002",
            'MT'        => $mt,
            'PC'        => "LSBU",
            'CC'        => "0000",
            'MP'        => $elements
        ];
        $record = sendAPI($data, $type);
        
        if($record->RC == '0000'){
            $status = true;
        }else{
            $status = false;
        }
        $message = $record->RC_DESC;
        $result = [
            'status' => $status,
            'message' => $message,
        ];
        return $result;
    }
}