<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SysApplication;
use App\Models\SysRole;
use App\Models\SysRolePermission;
use App\Models\SysPermission;
use App\Models\SysBranch;
use App\Models\MaterilizedViews\MvSummaryLsbu;
use App\Models\MaterilizedViews\MvClosingSummaryLsbu;
use App\Models\MaterilizedViews\MvSummaryMygoals;
use App\Models\MaterilizedViews\MvClosingSummaryMygoals;
use App\Models\Views\VSummaryLsbu;
use App\Models\Views\VKantorWilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(){
        // dd(Session::get('user'));
        $wilayah = VKantorWilayah::all();
        return view('dashboard', compact('wilayah'));
    }    

    public function haventPermission($name, $msg){
        return redirect()->route('dashboard')->with(
            $notification = array(
                // 'message' => "Maaf, anda tidak memiliki akses ke menu: $name",
                'message' => "Maaf, anda tidak memiliki akses ke menu: ". ($msg ? $msg : '') ." $name",
                'alert-type' => "danger"
            )
        );
    }

    public function lsbu(Request $request){
        $chart_kesalahan = MvClosingSummaryLsbu::where('tipe_closing', '=', 'Kesalahan Data');
        if(Session::get('user')->kodeKanwil == '0000'){
            if($request->kanwil == 'ALL'){
                $data = $chart_kesalahan->get();
            }else{
                $data = $chart_kesalahan->where('kode_wilayah', '=', $request->kanwil)->get();
            }
            
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $agst = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            foreach($data as $row){
                $jan    += $row->jan;
                $feb    += $row->feb;
                $mar    += $row->mar;
                $apr    += $row->apr;
                $mei    += $row->mei;
                $jun    += $row->jun;
                $jul    += $row->jul;
                $agst   += $row->agst;
                $sep    += $row->sep;
                $okt    += $row->okt;
                $nov    += $row->nov;
                $des    += $row->des;
            }
            $chart_kesalahan = [
                'jan'   => $jan,
                'feb'   => $feb,
                'mar'   => $mar,
                'apr'   => $apr,
                'mei'   => $mei,
                'jun'   => $jun,
                'jul'   => $jul,
                'agst'  => $agst,
                'sep'   => $sep,
                'okt'   => $okt,
                'nov'   => $nov,
                'des'   => $des
            ];
        }else{
            $chart_kesalahan = $chart_kesalahan->where('branch_code', '=', Session::get('user')->kodeCabang);
            $chart_kesalahan = $chart_kesalahan->first();
        }

        $chart_manual = MvClosingSummaryLsbu::where('tipe_closing', '=', 'Mid-Termination Manual');
        if(Session::get('user')->kodeKanwil == '0000'){
            if($request->kanwil == 'ALL'){
                $data = $chart_manual->get();
            }else{
                $data = $chart_manual->where('kode_wilayah', '=', $request->kanwil)->get();
            }
            
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $agst = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            foreach($data as $row){
                $jan    += $row->jan;
                $feb    += $row->feb;
                $mar    += $row->mar;
                $apr    += $row->apr;
                $mei    += $row->mei;
                $jun    += $row->jun;
                $jul    += $row->jul;
                $agst   += $row->agst;
                $sep    += $row->sep;
                $okt    += $row->okt;
                $nov    += $row->nov;
                $des    += $row->des;
            }
            $chart_manual = [
                'jan'   => $jan,
                'feb'   => $feb,
                'mar'   => $mar,
                'apr'   => $apr,
                'mei'   => $mei,
                'jun'   => $jun,
                'jul'   => $jul,
                'agst'  => $agst,
                'sep'   => $sep,
                'okt'   => $okt,
                'nov'   => $nov,
                'des'   => $des
            ];
        }else{
            $chart_manual = $chart_manual->where('branch_code', '=', Session::get('user')->kodeCabang);
            $chart_manual = $chart_manual->first();
        }

        $chart_otomatis = MvClosingSummaryLsbu::where('tipe_closing', '=', 'Mid-Termination Otomatis');
        if(Session::get('user')->kodeKanwil == '0000'){
            if($request->kanwil == 'ALL'){
                $data = $chart_otomatis->get();
            }else{
                $data = $chart_otomatis->where('kode_wilayah', '=', $request->kanwil)->get();
            }
            
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $agst = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            foreach($data as $row){
                $jan    += $row->jan;
                $feb    += $row->feb;
                $mar    += $row->mar;
                $apr    += $row->apr;
                $mei    += $row->mei;
                $jun    += $row->jun;
                $jul    += $row->jul;
                $agst   += $row->agst;
                $sep    += $row->sep;
                $okt    += $row->okt;
                $nov    += $row->nov;
                $des    += $row->des;
            }
            $chart_otomatis = [
                'jan'   => $jan,
                'feb'   => $feb,
                'mar'   => $mar,
                'apr'   => $apr,
                'mei'   => $mei,
                'jun'   => $jun,
                'jul'   => $jul,
                'agst'  => $agst,
                'sep'   => $sep,
                'okt'   => $okt,
                'nov'   => $nov,
                'des'   => $des
            ];
        }else{
            $chart_otomatis = $chart_otomatis->where('branch_code', '=', Session::get('user')->kodeCabang);
            $chart_otomatis = $chart_otomatis->first();
        }

        $chart_normal = MvClosingSummaryLsbu::where('tipe_closing', '=', 'Tutup Normal');
        if(Session::get('user')->kodeKanwil == '0000'){
            if($request->kanwil == 'ALL'){
                $data = $chart_normal->get();
            }else{
                $data = $chart_normal->where('kode_wilayah', '=', $request->kanwil)->get();
            }
            
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $mei = 0;
            $jun = 0;
            $jul = 0;
            $agst = 0;
            $sep = 0;
            $okt = 0;
            $nov = 0;
            $des = 0;
            foreach($data as $row){
                $jan    += $row->jan;
                $feb    += $row->feb;
                $mar    += $row->mar;
                $apr    += $row->apr;
                $mei    += $row->mei;
                $jun    += $row->jun;
                $jul    += $row->jul;
                $agst   += $row->agst;
                $sep    += $row->sep;
                $okt    += $row->okt;
                $nov    += $row->nov;
                $des    += $row->des;
            }
            $chart_normal = [
                'jan'   => $jan,
                'feb'   => $feb,
                'mar'   => $mar,
                'apr'   => $apr,
                'mei'   => $mei,
                'jun'   => $jun,
                'jul'   => $jul,
                'agst'  => $agst,
                'sep'   => $sep,
                'okt'   => $okt,
                'nov'   => $nov,
                'des'   => $des
            ];
        }else{
            $chart_normal = $chart_normal->where('branch_code', '=', Session::get('user')->kodeCabang);
            $chart_normal = $chart_normal->first();
        }

        $closing = MvClosingSummaryLsbu::select('jan as Januari', 'feb as Februari', 'mar as Maret', 'apr as April', 'mei as Mei', 'jun as Juni', 'jul as Juli', 'agst as Agustus', 'sep as September', 'okt as Oktober', 'nov as November', 'des as Desember')->first();

        $months  = ['Januari, Februari, Maret, April, Mei, Juni, Juli, Agustus, September, Oktober, November, Desember'];

        if($closing){
            $months = array_keys($closing->getAttributes());
        }

        $data = [
            'months'        => $months,
            'lengthData'    => count($months),
            'data'          => [
                [
                    'label' => 'Tutup Normal',
                    'color' => '#3498db',
                    'data'  => [
                        $chart_normal['jan'] ? $chart_normal['jan'] : 0,
                        $chart_normal['feb'] ? $chart_normal['feb'] : 0,
                        $chart_normal['mar'] ? $chart_normal['mar'] : 0,
                        $chart_normal['apr'] ? $chart_normal['apr'] : 0,
                        $chart_normal['mei'] ? $chart_normal['mei'] : 0,
                        $chart_normal['jun'] ? $chart_normal['jun'] : 0,
                        $chart_normal['jul'] ? $chart_normal['jul'] : 0,
                        $chart_normal['agst'] ? $chart_normal['agst'] : 0,
                        $chart_normal['sep'] ? $chart_normal['sep'] : 0,
                        $chart_normal['okt'] ? $chart_normal['okt'] : 0,
                        $chart_normal['nov'] ? $chart_normal['nov'] : 0,
                        $chart_normal['des'] ? $chart_normal['des'] : 0
                    ],
                ],
                [
                    'label' => 'Mid-Term',
                    'color' => '#f39c12',
                    'data'  => [
                        $chart_otomatis['jan'] ? $chart_otomatis['jan'] : 0,
                        $chart_otomatis['feb'] ? $chart_otomatis['feb'] : 0,
                        $chart_otomatis['mar'] ? $chart_otomatis['mar'] : 0,
                        $chart_otomatis['apr'] ? $chart_otomatis['apr'] : 0,
                        $chart_otomatis['mei'] ? $chart_otomatis['mei'] : 0,
                        $chart_otomatis['jun'] ? $chart_otomatis['jun'] : 0,
                        $chart_otomatis['jul'] ? $chart_otomatis['jul'] : 0,
                        $chart_otomatis['agst'] ? $chart_otomatis['agst'] : 0,
                        $chart_otomatis['sep'] ? $chart_otomatis['sep'] : 0,
                        $chart_otomatis['okt'] ? $chart_otomatis['okt'] : 0,
                        $chart_otomatis['nov'] ? $chart_otomatis['nov'] : 0,
                        $chart_otomatis['des'] ? $chart_otomatis['des'] : 0
                    ],
                ],
                [
                    'label' => 'Mid-Term Manual',
                    'color' => '#8e44ad',
                    'data'  => [
                        $chart_manual['jan'] ? $chart_manual['jan'] : 0,
                        $chart_manual['feb'] ? $chart_manual['feb'] : 0,
                        $chart_manual['mar'] ? $chart_manual['mar'] : 0,
                        $chart_manual['apr'] ? $chart_manual['apr'] : 0,
                        $chart_manual['mei'] ? $chart_manual['mei'] : 0,
                        $chart_manual['jun'] ? $chart_manual['jun'] : 0,
                        $chart_manual['jul'] ? $chart_manual['jul'] : 0,
                        $chart_manual['agst'] ? $chart_manual['agst'] : 0,
                        $chart_manual['sep'] ? $chart_manual['sep'] : 0,
                        $chart_manual['okt'] ? $chart_manual['okt'] : 0,
                        $chart_manual['nov'] ? $chart_manual['nov'] : 0,
                        $chart_manual['des'] ? $chart_manual['des'] : 0
                    ],
                ],
                [
                    'label' => 'Kesalahan Data',
                    'color' => '#34495e',
                    'data'  => [
                        $chart_kesalahan['jan'] ? $chart_kesalahan['jan'] : 0,
                        $chart_kesalahan['feb'] ? $chart_kesalahan['feb'] : 0,
                        $chart_kesalahan['mar'] ? $chart_kesalahan['mar'] : 0,
                        $chart_kesalahan['apr'] ? $chart_kesalahan['apr'] : 0,
                        $chart_kesalahan['mei'] ? $chart_kesalahan['mei'] : 0,
                        $chart_kesalahan['jun'] ? $chart_kesalahan['jun'] : 0,
                        $chart_kesalahan['jul'] ? $chart_kesalahan['jul'] : 0,
                        $chart_kesalahan['agst'] ? $chart_kesalahan['agst'] : 0,
                        $chart_kesalahan['sep'] ? $chart_kesalahan['sep'] : 0,
                        $chart_kesalahan['okt'] ? $chart_kesalahan['okt'] : 0,
                        $chart_kesalahan['nov'] ? $chart_kesalahan['nov'] : 0,
                        $chart_kesalahan['des'] ? $chart_kesalahan['des'] : 0
                    ],
                ]
            ]
        ];
        
        if(Session::get('user')->kodeKanwil == '0000'){
            $mv_summary = [];
            
            if($request->kanwil != 'ALL'){
                $summaries = VSummaryLsbu::where('kode_kanwil', $request->kanwil)->get();
            }else{
                $summaries = VSummaryLsbu::all();
            }
            
            $terdaftar      = 0;
            $aktif          = 0;
            $selesai        = 0;
            $regBulanLalu   = 0;
            $regBulanIni    = 0;
            $presentasi     = 0;
            foreach($summaries as $row){
                $terdaftar      += $row->autodebit_terdaftar;
                $aktif          += $row->autodebit_aktif;
                $selesai        += $row->autodebit_selesai;
                $regBulanLalu   += $row->reg_bulan_lalu;
                $regBulanIni    += $row->reg_bulan_ini;
                $presentasi     += $row->presentasi;
            }
            $mv_summary = [
                'autodebit_terdaftar'   => $terdaftar,
                'autodebit_aktif'       => $aktif,
                'autodebit_selesai'     => $selesai,
                'reg_bulan_lalu'        => $regBulanLalu,
                'reg_bulan_ini'         => $regBulanIni,
                'presentasi'            => $presentasi
            ];
        }else{
            $mv_summary = VSummaryLsbu::where('branch_code', Session::get('user')->kodeCabang)->first();
        }
        
        $response = [
            'months'        => $months,
            'mv_summary'    => $mv_summary,
            'charts'        => $data,
            'date'          => date('d-m-Y', strtotime(date('Y-m-d') . "-1 days"))
        ];
        return response()->json($response);
    }

    public function mygoals(){
        $chart_kesalahan = MvClosingSummaryMygoals::where([
            ['branch_code', '=', Session::get('user')->kodeCabang],
            ['tipe_closing', '=', 'Kesalahan Data']
        ])
        ->first();
        $chart_manual = MvClosingSummaryMygoals::where([
            ['branch_code', '=', Session::get('user')->kodeCabang],
            ['tipe_closing', '=', 'Mid-Termination Manual']
        ])
        ->first();
        $chart_otomatis = MvClosingSummaryMygoals::where([
            ['branch_code', '=', Session::get('user')->kodeCabang],
            ['tipe_closing', '=', 'Mid-Termination Otomatis']
        ])
        ->first();
        $chart_normal = MvClosingSummaryMygoals::where([
            ['branch_code', '=', Session::get('user')->kodeCabang],
            ['tipe_closing', '=', 'Tutup Normal']
        ])
        ->first();
        $closing = MvClosingSummaryMygoals::select('jan as Januari', 'feb as Februari', 'mar as Maret', 'apr as April', 'mei as Mei', 'jun as Juni', 'jul as Juli', 'agst as Agustus', 'sep as September', 'okt as Oktober', 'nov as November', 'des as Desember')->first();
        $months  = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if($closing){
            $months = array_keys($closing->getAttributes());
        }
        $data = [
            'months'        => $months,
            'lengthData'    => count($months),
            'data'          => [
                [
                    'label' => 'Tutup Normal',
                    'color' => '#3498db',
                    'data'  => [
                        $chart_normal ? $chart_normal['jan'] : 0,
                        $chart_normal ? $chart_normal['feb'] : 0,
                        $chart_normal ? $chart_normal['mar'] : 0,
                        $chart_normal ? $chart_normal['apr'] : 0,
                        $chart_normal ? $chart_normal['mei'] : 0,
                        $chart_normal ? $chart_normal['jun'] : 0,
                        $chart_normal ? $chart_normal['jul'] : 0,
                        $chart_normal ? $chart_normal['agst'] : 0,
                        $chart_normal ? $chart_normal['sep'] : 0,
                        $chart_normal ? $chart_normal['okt'] : 0,
                        $chart_normal ? $chart_normal['nov'] : 0,
                        $chart_normal ? $chart_normal['des'] : 0,
                    ],
                ],
                // [
                //     'label' => 'Mid-Term',
                //     'color' => '#f39c12',
                //     'data'  => [
                //         $chart_otomatis ? $chart_otomatis['jan'] : 0,
                //         $chart_otomatis ? $chart_otomatis['feb'] : 0,
                //         $chart_otomatis ? $chart_otomatis['mar'] : 0,
                //         $chart_otomatis ? $chart_otomatis['apr'] : 0,
                //         $chart_otomatis ? $chart_otomatis['mei'] : 0,
                //         $chart_otomatis ? $chart_otomatis['jun'] : 0,
                //         $chart_otomatis ? $chart_otomatis['jul'] : 0,
                //         $chart_otomatis ? $chart_otomatis['agst'] : 0,
                //         $chart_otomatis ? $chart_otomatis['sep'] : 0,
                //         $chart_otomatis ? $chart_otomatis['okt'] : 0,
                //         $chart_otomatis ? $chart_otomatis['nov'] : 0,
                //         $chart_otomatis ? $chart_otomatis['des'] : 0,
                //     ],
                // ],
                [
                    'label' => 'Mid-Term Manual',
                    'color' => '#8e44ad',
                    'data'  => [
                        $chart_manual ? $chart_manual['jan'] : 0,
                        $chart_manual ? $chart_manual['feb'] : 0,
                        $chart_manual ? $chart_manual['mar'] : 0,
                        $chart_manual ? $chart_manual['apr'] : 0,
                        $chart_manual ? $chart_manual['mei'] : 0,
                        $chart_manual ? $chart_manual['jun'] : 0,
                        $chart_manual ? $chart_manual['jul'] : 0,
                        $chart_manual ? $chart_manual['agst'] : 0,
                        $chart_manual ? $chart_manual['sep'] : 0,
                        $chart_manual ? $chart_manual['okt'] : 0,
                        $chart_manual ? $chart_manual['nov'] : 0,
                        $chart_manual ? $chart_manual['des'] : 0,
                    ],
                ],
                // [
                //     'label' => 'Kesalahan Data',
                //     'color' => '#34495e',
                //     'data'  => [
                //         $chart_kesalahan ? $chart_kesalahan['jan'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['feb'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['mar'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['apr'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['mei'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['jun'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['jul'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['agst'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['sep'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['okt'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['nov'] : 0,
                //         $chart_kesalahan ? $chart_kesalahan['des'] : 0,
                //     ],
                // ]
            ]
        ];
        $response = [
            'months'        => $months,
            'mv_summary'    => MvSummaryMygoals::where('branch_code', Session::get('user')->kodeCabang)->first(),
            'charts'        => $data,
            'date'          => date('d-m-Y', strtotime(date('Y-m-d') . "-1 days"))
        ];
        return response()->json($response);
    }


    /**
     * setup
     */

    // Log Activity
    public function logActivityUpdate($attributes, $originals){
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

        userActivities('Update', 'Melakukan update pada field: ' . $field, 'savdep_product_customer_mygoals', 'General', Route::current()->getName());
    }

    // fungsi untuk menambahkan module di role to permission
    public function insert_batch($application_id, $type){
        $application    = SysApplication::where('id', $application_id)->first();
        $applications   = SysApplication::where(function($query){
            $query->where('type', '<>', 0)
            ->where('parent_id', '<>', 0);
        })->get();
        if (!empty($application)) {
            $roles          = SysRole::all();
            $permissions    = SysPermission::all();
            DB::beginTransaction();
            try {
                foreach($roles as $role){
                    if(strtolower($type) == 'child'){
                        foreach($permissions as $permission){
                            $roleToPermissionShow = SysRolePermission::where([
                                ['role_id', '=', $role->id],
                                ['application_id', '=', $application_id],
                                ['permission_id', '=', $permission->id],
                            ])->first();
                            if(empty($roleToPermissionShow)){
                                $roleToPermission = new SysRolePermission();
                                $roleToPermission->isactive = $role->id == 1 ? true : false;
                                $roleToPermission->role_id = $role->id;
                                $roleToPermission->permission_id = $permission->id;
                                $roleToPermission->application_id = $application_id;
                                if($roleToPermission->save()){
                                    DB::commit();
                                }
                            }else{
                                DB::rollback();
                                echo json_encode('failed because (application_id = ' . $application_id . ') have been recorded in our system');
                                die;
                            }
                        }
                    }else{
                        $roleToPermissionShow = SysRolePermission::where([
                            ['role_id', '=', $role->id],
                            ['application_id', '=', $application_id]
                        ])->first();
                        if (empty($roleToPermissionShow)) {
                            $roleToPermission = new SysRolePermission();
                            $roleToPermission->isactive = $role->id == 1 ? true : false;
                            $roleToPermission->role_id = $role->id;
                            $roleToPermission->permission_id = 1;
                            $roleToPermission->application_id = $application_id;
                            if ($roleToPermission->save()) {
                                DB::commit();
                            }
                        } else {
                            DB::rollback();
                            echo json_encode('failed because (application_id = ' . $application_id . ') have been recorded in our system');
                            die;
                        }
                    }
                }
                echo json_encode('success tambah permission '. $application->name);
                die;
            } catch (\Throwable $e) {
                DB::rollback();
                echo json_encode($e);
                die;
            }
        } else {
            echo json_encode("failed because (modules_id = $application_id in sys_applications) haven't recorded in our system");
            die;
        }
    }

    // fungsi apabila ada permission baru
    public function insert_batch_permission($permission_id){
        $permission = SysPermission::where('id', $permission_id)->first();
        if(!empty($permission)){
            $roles          = SysRole::all();
            $applications   = SysApplication::where(function($query){
                $query->where('type', '<>', 0)
                ->where('parent_id', '<>', 0);
            })->get();
            DB::beginTransaction();
            try {
                foreach($roles as $role){
                    foreach($applications as $application){
                        $roleToPermissionShow = SysRolePermission::where([
                            ['role_id', '=', $role->id],
                            ['application_id', '=', $application->id],
                            ['permission_id', '=', $permission_id]
                        ])->first();
                        if(empty($roleToPermissionShow)){
                            $roleToPermission = new SysRolePermission();
                            $roleToPermission->isactive = false;
                            $roleToPermission->role_id = $role->id;
                            $roleToPermission->permission_id = $permission_id;
                            $roleToPermission->application_id = $application->id;
                            if ($roleToPermission->save()) {
                                DB::commit();
                            }
                        }else{
                            DB::rollback();
                            echo "failed because (permission_id = $permission_id) have been recorded in our system";
                        }
                    }
                }
                echo 'berhasil tambah role permission ' . $permission->name;
            } catch (\Throwable $e){
                DB::rollback();
                echo $e;
            }
        }else{
            echo "failed because (permission_id = $permission_id in sys_permissions) haven't recorded in our system";
        }
    }

}