<?php

namespace App\Http\Controllers\Autodebit\MyGoals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavdepProductCustomerMyGoal;
use App\Models\SavdepProductCustomerMyGoalTemp;
use App\Models\SavdepProduct;
use App\Models\SysRole as Role;
use App\Models\SysUser;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Autodebit\MyGoals\PendaftaranExport;
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
        return view('autodebit.mygoal.approval.index', compact('role'));
    }

    public function ajax_approval(Request $request){
        $records    = DB::table('savdep_product_customer_mygoals AS a');
        if($request->approval_type == 1){
            $records    = DB::table('savdep_product_customer_mygoals_temp AS a');
        }
        $records    = $records->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where(function($query) use($request){
                $query->where('sd_pc_dst_extacc', 'ilike', "%$request->search%")
                ->orWhere('sp_pc_dst_name', 'ilike', "%$request->search%");
            });
        if($request->approval_type != 1){
            $records    = $records->where('a.sp_pc_approval_status', $request->approval_type);
        }

        $records        = $records->orderBy('a.sp_pc_reg_date', 'ASC');
        $no             = $request->start;
        $resCount       = $records->count();
        $records        = $records->skip($request->start)->take($request->length);
        $records        = $records->get();
        $typeApproval   = true;
        if($request->approval_type == 1){
            $typeApproval = false;
        }
        foreach($records as $row){
            $row->rownum        = ++$no;
            $row->id            = Crypt::encrypt($row->sd_pc_dst_extacc);
            $row->routeshow     = route('autodebit.mygoals.approval.show', [$row->id, $request->approval_type]);
            $row->routeapproved = route('autodebit.mygoals.approval.update', [
                'params' => $row->id,
                'action' => 'approved'
            ]);
            $row->routerejected = route('autodebit.mygoals.approval.update', [
                'params' => $row->id,
                'action' => 'rejected'
            ]);
            $row->typeApproval  = $typeApproval;
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records,
            "search"            => $request->search ? $request->search : null,
            "approval_type"     => $request->approval_type ? $request->approval_type : null
        ];
    
        return response()->json($response);
    }

    public function update($params, $action, Request $request){
        $record = SavdepProductCustomerMyGoal::where('id', Crypt::decrypt($params))->first();
        // dd($record);
        if($action == 'approved'){
            if($record->sp_pc_approval_status == 3){
                $record->sp_pc_status   = 4;
            }
            $record->sp_pc_approval_status  = 0;
            $record->sd_pc_rejected_notes   = null;
        }else{
            $record->sp_pc_approval_status  = 4;
            $record->sd_pc_rejected_notes   = $request->sd_pc_rejected_notes;
        }
        $record->updated_by     = Session::get('user')->userId;
        $record->updated_at     = date('Y-m-d h:i:s');

        if($record->save()){
            $message    = 'Berhasil melakukan '. $action .'!';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan '. $action .'!';
            $alert      = 'danger';
        }

        return redirect()->route('autodebit.approval')->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }

    public function show($params, $approval_type){
        $role   = Role::where('id', Session::get('role')->id)
        ->where('name', 'ilike', Config::get('app.reject_spv'))
        ->first();
        if($approval_type == 1){
            $record = SavdepProductCustomerMyGoalTemp::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
        }else{
            $record = SavdepProductCustomerMyGoal::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
        }
        // dd($record->sp_pc_notif_flag);
        $record->sp_pc_notif_flag_name = $record->sp_pc_notif_flag > 0 ? $record->sp_pc_notif_flag > 1 ? $record->sp_pc_notif_flag > 3 ? 'SMS dan Email' : 'Email' : 'SMS' : 'Tidak Aktif';
        $record->sp_pc_jenis_period_name = $record->sp_pc_jenis_period > 0 ? $record->sp_pc_notif_flag > 1 ? 'Mingguan' : 'Harian' : 'Bulanan';
        $record->routeapproved = route('autodebit.mygoals.approval.update', [
            'params' => Crypt::encrypt($record->sd_pc_dst_extacc),
            'action' => 'approved'
        ]);
        $record->routerejected = route('autodebit.mygoals.approval.update', [
            'params' => Crypt::encrypt($record->sd_pc_dst_extacc),
            'action' => 'rejected'
        ]);
        $typeApproval   = true;
        if($approval_type == 1){
            $typeApproval = false;
        }
        $record->approval_type = $approval_type;
        $record->typeApproval = $typeApproval;
        $days = [];
        for($i = 1; $i < 32; $i++){
            if($i < 10){
                $i = '0' . $i;
            }
            array_push($days, $i);
        }
        return view('autodebit.mygoal.approval.index', compact('record', 'days', 'role'));
    }

    public function checking_spv(Request $request){
        $encrypter  = new Encrypter('yasOkRpyKE7qsBLsbp0Im7TbkKq1jpgs', 'AES-256-CBC');
        $data       = [
            "userId"    => $request->username,
            "password"  => $encrypter->encrypt($request->password),
            "appId"     => 260
            // "appId"     => 251
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
                        if($request->status == 'true'){
                            $result = $this->updateStatus($request->id, $request->approval_type, $response->userId, 
                            $request->sp_pc_jenis_lanjut);
                            // return $result;
                            $condition = 'approved';
                        }else{
                            $result = $this->updateStatusORM($request->id, $request->sp_pc_rejected_notes, $response->userId);
                            // return response()->json($result);
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
            $record = SavdepProductCustomerMygoalTemp::where('sd_pc_dst_extacc', $sd_pc_dst_extacc)->first();
            if(!$record->delete()){
                DB::rollback();
                return [
                    'status' => false,
                    'message'=> 'Data gagal di reject'
                ];
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
    public function updateStatus($sd_pc_dst_extacc, $approval_type, $userId, $sp_pc_jenis_lanjut){
        $elements['ACCEXTDST'] = $sd_pc_dst_extacc;
        // foreach($sd_pc_dst_extacc as $row){
        //     if($approval_type == 1){
        //         $el = [
        //             "ACCEXTDST" => $row
        //         ];
        //         $mt     = "2400";
        //         $type   = "registration";
        //     }elseif($approval_type == 5){
        //         $el = [
        //             "ACCEXTDST" => $row,
        //         ];
        //         $mt = "4000";
        //         $type   = "edit";
        //     }else{
        //         $el = [
        //             "ACCEXTDST" => $row,
        //             "STATUS"    => $approval_type
        //         ];
        //         $mt = "2500";
        //         $type   = "closing";
        //     }
        //     array_push($elements, $el);
        // }
        
        if($approval_type == 1){
            $mt     = "2400";
            $type   = "registration";
        }elseif($approval_type == 5){
            $mt = "4000";
            $type   = "edit";
        }elseif($approval_type == 2){
            $mt = "3100";
            $type   = "edit";
        }elseif($approval_type == 4){
            $mt = "3200";
            $type   = "edit";
            $elements['JENIS_LANJUT'] = $sp_pc_jenis_lanjut;
        }else{
            $mt = "2500";
            $type   = "closing";
        }
        // return $elements;
        $data = [
            'USERID'    => $userId,
            'MC'        => "50001",
            'MT'        => $mt,
            'PC'        => "MYGOALS",
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