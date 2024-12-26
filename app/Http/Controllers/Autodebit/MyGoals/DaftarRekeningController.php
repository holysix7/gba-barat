<?php

namespace App\Http\Controllers\Autodebit\MyGoals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductCustomerMyGoal;
use App\Models\SavdepProductCustomerMyGoalTemp;
use App\Models\SavdepProduct;
use App\Models\SysApplication;
use App\Models\SavdepTransaction;
use App\Models\Views\ViewSourceMyGoals;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Autodebit\MyGoals\DaftarRekeningExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\MyGoalsTrait;

class DaftarRekeningController extends Controller
{
    use MyGoalsTrait;

    public function index(){
        return view('autodebit.mygoal.daftar-rekening.index');
    }

    public function ajax_goals(Request $request){
        $records = $this->ajaxList($request);
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $records->resCount,
            "recordsFiltered"   => $records->resCount,
            "data"              => $records->records
        ];
    
        return response()->json($response);
    }

    public function show($params){
        $record = $this->showRecord($params);
        
        return view('autodebit.mygoal.daftar-rekening.index', compact('record'));
    }

    public function show_inquiry($params){
        // dd(Crypt::decrypt($params));
        $record    = DB::table('savdep_product_customer_mygoals AS a')
            ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where('a.sd_pc_dst_extacc', Crypt::decrypt($params))
            ->first();
        $dataTransaksi      = SavdepTransaction::select('sd_t_dt')
            ->where('sd_t_dep_acc', $record->sd_pc_dst_extacc)
            ->orderBy('sd_t_dt', 'asc');
        $counted = $dataTransaksi->count();
        $tglMulaiAutodebit = $dataTransaksi->first();
        $record->routeshow          = route('autodebit.lsbu.daftar-rekening.show', $params);
        $record->tglReg             = date('d M Y', strtotime($record->sp_pc_reg_date));
        $record->tglMulai           = $tglMulaiAutodebit ? date('d M Y', strtotime($tglMulaiAutodebit->sd_t_dt)) : null;
        $record->sd_t_dt            = $tglMulaiAutodebit ? $tglMulaiAutodebit->sd_t_dt : null;
        $record->transactionDone    = $counted ? $counted : 0;
        $record->saldoTercapai      = $record->sp_pc_debet_total_amount;
        $record->formSubmit         = route('autodebit.mygoals.daftar-rekening.show-inquiry', $params);
        $maxDate = date('Y-m-d');
        // dd($record->sd_t_dt);
        return view('autodebit.mygoal.daftar-rekening.index', compact('record', 'maxDate'));
    }

    public function ajax_show_goals(Request $request){
        $record = SavdepProductCustomerMyGoal::where('sd_pc_dst_extacc', $request->sd_pc_dst_extacc)->first();
        return response()->json($record);
    }

    public function new(){
        // $days = [];
        // $daysOfMonth = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        // for($i = 1; $i <= $daysOfMonth; $i++){
        //     array_push($days, $i);
        // }
        
        $daysName = [];
        for($i = 1; $i < 8; $i++){
            $i = '0' . $i;
            $row = [
                'id'    => $i,
                'name'  => $i != '01' ? $i != '02' ? $i != '03' ? $i != '04' ? $i != '05' ? $i != '06' ? 'Sabtu' : 'Jumat' : 'Kamis' : 'Rabu' : 'Selasa' : 'Senin' : 'Minggu'
            ];
            array_push($daysName, $row);
        }
        $bornMax = date('Y-m-d', strtotime('-17 years'));
        // dd($bornMax);
        $days = [];
        for($i = 1; $i <= 25; $i++){
            array_push($days, $i);
        }
        $days   = json_encode($days);
        $daysName   = json_encode($daysName);
        // dd($daysName);
        
        $product = SavdepProduct::where('sd_p_id', 'MYGOALS')->first();
        
        return view('autodebit.mygoal.daftar-rekening.index', compact('days', 'daysName', 'bornMax', 'product'));
    }

    public function confirm(Request $request){
        $clearCache     = Cache::flush();
        $cached         = Cache::put('newRekening', $request->all());
        $message        = 'Success, berhasil mengisi form pendaftaran!';
        $alert          = 'success';
        $route          = 'autodebit.mygoals.daftar-rekening.confirm-menu';
        $params         = Crypt::encrypt(Cache::get('newRekening'));
        return redirect()->route($route, $params)->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }

    public function form_confirm($params){
        $record = Crypt::decrypt($params);
        $child = [];
        foreach($record['sd_pc_dst_extacc'] as $key => $sd_pc_dst_extacc){
            foreach($record['sp_pc_aim'] as $key2 => $sp_pc_aim){
                foreach($record['sp_pc_target_amount'] as $key3 => $sp_pc_target_amount){
                    foreach($record['sp_pc_init_amount'] as $key4 => $sp_pc_init_amount){
                        foreach($record['sp_pc_jenis_period'] as $key5 => $sp_pc_jenis_period){
                            foreach($record['sp_pc_period_date'] as $key6 => $sp_pc_period_date){
                                foreach($record['sd_pc_period_amount'] as $key7 => $sd_pc_period_amount){
                                    foreach($record['sd_pc_period'] as $key8 => $sd_pc_period){
                                        foreach($record['sd_pc_period_amount_last'] as $key9 => $sd_pc_period_amount_last){
                                            foreach($record['sd_pc_notif_flag'] as $key10 => $sd_pc_notif_flag){
                                                foreach($record['sd_pc_notif_phone'] as $key11 => $sd_pc_notif_phone){
                                                    foreach($record['sd_pc_notif_email'] as $key12 => $sd_pc_notif_email){
                                                        foreach($record['sp_pc_misi_utama'] as $key13 => $sp_pc_misi_utama){
                                                            if($key == $key2 && $key2 == $key3 && $key3 == $key4 && $key4 == $key5 && $key5 == $key6 && $key6 == $key7 && $key7 == $key8 && $key8 == $key9 && $key9 == $key10 && $key10 == $key11 && $key11 == $key12 && $key12 == $key13){
                                                                $row = [
                                                                    'sd_pc_dst_extacc'          => $sd_pc_dst_extacc,
                                                                    'ACCINTDST'                 => $record['ACCINTDST'][0],
                                                                    'ACCDST_TYPE'               => $record['ACCDST_TYPE'][0],
                                                                    'ACCDST_CIF'                => $record['ACCDST_CIF'][0],
                                                                    'ACCDST_NAME'               => $record['ACCDST_NAME'][0],
                                                                    'ACCDST_BRANCH'             => $record['ACCDST_BRANCH'][0],
                                                                    'ACCEXTDST'                 => $record['ACCEXTDST'][0],
                                                                    'ACCDST_CURRENCY'           => $record['ACCDST_CURRENCY'][0],
                                                                    'sp_pc_misi_utama'          => ucwords($sp_pc_misi_utama),
                                                                    'sp_pc_aim'                 => ucwords($sp_pc_aim),
                                                                    'sp_pc_target_amount'       => $sp_pc_target_amount,
                                                                    'sp_pc_init_amount'         => $sp_pc_init_amount,
                                                                    'sp_pc_jenis_period'        => $sp_pc_jenis_period,
                                                                    'sp_pc_jenis_period_nama'   => $this->jenisPeriod($sp_pc_period_date),
                                                                    'sp_pc_period_date'         => $sp_pc_period_date,
                                                                    'sp_pc_period_date_nama'    => $this->namaHari($sp_pc_period_date, $sp_pc_jenis_period),
                                                                    'sd_pc_period_amount'       => $sd_pc_period_amount,
                                                                    'sd_pc_period'              => $sd_pc_period,
                                                                    'sd_pc_period_amount_last'  => $sd_pc_period_amount_last,
                                                                    'sd_pc_notif_flag'          => $sd_pc_notif_flag,
                                                                    'sd_pc_notif_flag_nama'     => $this->namaNotif($sd_pc_notif_flag),
                                                                    'sd_pc_notif_phone'         => $sd_pc_notif_phone,
                                                                    'sd_pc_notif_email'         => $sd_pc_notif_email
                                                                ];
                                                                array_push($child, $row);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $record['mygoals'] = json_encode($child);
        // dd([
        //     'record'=> $record,
        //     'child' => $child
        // ]);
        $days = [];
        $daysOfMonth = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
        $daysName = [];
        for($i = 1; $i <= $daysOfMonth; $i++){
            array_push($days, $i);
        }
        // dd($record);
        return view('autodebit.mygoal.daftar-rekening.index', compact('record', 'days'));
    }

    public function create(Request $request){
        $result = $this->pengajuanRegistrasi($request->all());
        if($result == true){
            userActivities('Create', 'Menambahkan data', 'savdep_product_customer_mygoals', 'General', Route::current()->getName());
            $message    = 'Success, berhasil menambahkan data!';
            $alert      = 'success';
            $route      = 'autodebit.mygoals.daftar-rekening.result';
            return redirect()->route($route, Crypt::encrypt($request->all()))->with(
                $notification = array(
                    'message' => $result['message'],
                    'alert-type' => $alert
                )
            );
        }else{
            $message    = 'Error, ketika menambahkan data!';
            $alert      = 'danger';
            $route      = 'autodebit.mygoals.daftar-rekening.new';
            return redirect()->route($route)->with(
                $notification = array(
                    'message' => $result['message'],
                    'alert-type' => $alert
                )
            );
        }
    }

    public function result($params){
        $element = Crypt::decrypt($params);
        $record  = SavdepProductCustomerMyGoalTemp::where('sd_pc_src_extacc', $element['sd_pc_src_extacc'])->first();
        $routeVerifNow = route('autodebit.mygoals.approval');

        return view('autodebit.mygoal.daftar-rekening.index', compact('routeVerifNow'));
    }

    public function update(Request $request){
        $record = SavdepProductCustomerMyGoal::where('sd_pc_dst_extacc', $request->sd_pc_dst_extacc)->first();
        if($request->condition > 0){
            if($record->sp_pc_approval_status == 0){
                $record->sp_pc_approval_status  = 2;
                if($request->condition_lanjut == 1){
                    $record->sp_pc_approval_status  = 4;
                }
                $record->sp_pc_jenis_lanjut = $request->JENIS_LANJUT;
                if($record->save()){
                    $attributes = $record->getAttributes();
                    $originals  = $record->getOriginal();
                    $this->logActivityUpdate($attributes, $originals);
                    $message    = 'Success, berhasil melakukan update status '. $request->sd_pc_dst_extacc .' !';
                    $alert      = 'success';
                }else{
                    $message    = 'Error, ketika melakukan update status '. $request->sd_pc_dst_extacc .' !';
                    $alert      = 'danger';
                }
            }else{
                if($record->sp_pc_approval_status == 1){
                    $message    = 'Error, selesaikan approval pendaftaran:'. $request->sd_pc_dst_extacc .' !';
                    $alert      = 'danger';
                }else if($record->sp_pc_approval_status == 2){
                    $message    = 'Error, selesaikan approval perubahan status:'. $request->sd_pc_dst_extacc .' !';
                    $alert      = 'danger';
                }else{
                    $message    = 'Error, selesaikan approval penutupan:'. $request->sd_pc_dst_extacc .' !';
                    $alert      = 'danger';
                }
            }
        }else{
            $record->sp_pc_approval_status  = 3;
            if($record->save()){
                $message    = 'Success, berhasil melakukan pengajuan penutupan: '. $request->sd_pc_dst_extacc .' !';
                $alert      = 'success';
            }else{
                $message    = 'Error, ketika melakukan pengajuan penutupan: '. $request->sd_pc_dst_extacc .' !';
                $alert      = 'danger';
            }
        }

        return redirect()->route('autodebit.mygoals.daftar-rekening')->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }

    public function penutupan($params, Request $request){
        $record = SavdepProductCustomerMyGoal::where('sd_pc_dst_extacc', $request->sd_pc_dst_extacc)->first();
        
        if($request->condition_autodebit > 0){
            $record->sp_pc_approval_status = 3;
        }else{
            $record->sp_pc_approval_status = $request->sp_pc_approval_status;
        }
        userActivities('Update', 'Melakukan penutupan', 'savdep_product_customer_lsbu', 'General', Route::current()->getName());
        if($record->save()){
            $message    = 'Success, berhasil mengajukan penutupan!';
            $alert      = 'success';
            $route      = 'autodebit.lsbu.daftar-rekening.result';
        }else{
            $message    = 'Gagal, Gagal mengajukan penutupan!';
            $alert      = 'gagal';
            $route      = 'autodebit.lsbu.daftar-rekening.show-inquiry';
        }
        return redirect()->route($route, [Crypt::encrypt($request->sd_pc_dst_extacc), 'penutupan'])->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }

    public function export(Request $request){
        $date = date("Ymd-his");
        userActivities('Export', 'Melakukan export data', 'savdep_product_customer_mygoals', 'General', Route::current()->getName());
        return Excel::download(new DaftarRekeningExport($request), 'daftar-rekening-'. $date .'.xlsx');
    }

    public function ajax_savdep_product(Request $request){
        $record = SavdepProduct::where('sd_p_id', $request->sd_p_id)->first();
        return response()->json($record);
    }

    public function ajax_simulasi_autodebit(Request $request){
        $records['setoran_awal'] = [];
        $records['interval'] = [];
        $metode_pendebetan  = $request->metode_pendebetan;
        $setoran_awal       = $request->setoran_awal;
        $setoran_berjangka  = $request->setoran_berjangka;
        $jangka_waktu       = $request->jangka_waktu;
        $product_id         = $request->product_id;
        $productRecord      = SavdepProduct::where('sd_p_id', strtoupper($request->product_id))->first();
        $interest = $productRecord ? $productRecord->sp_p_interest : 0;
        $resultMetode   = $this->conditionPendebetan($request, $metode_pendebetan);

        $indexVal = 1;
        $finalInterest  = $this->rumusInterest((floatval($interest) ? $interest : 0), intval($setoran_awal));
        $saldo_my_goals = $setoran_awal + $finalInterest;
        $records['setoran_awal']['saldo_my_goals']  = $saldo_my_goals;
        $records['setoran_awal']['period']          = $indexVal;
        $records['setoran_awal']['setoran_awal']    = $setoran_awal;
        $records['setoran_awal']['pilihan']         = $resultMetode->pilihan;
        if($request->product == 'mygoals'){
            $records['setoran_awal']['pilihan']         = $resultMetode->hari;
        }
        $records['setoran_awal']['interest']        = $finalInterest;
        $records['setoran_awal']['setoran_pertama'] = $resultMetode->hari_ini;
        // if($request->product == 'mygoals'){
        //     $records['setoran_awal']['setoran_pertama'] = $resultMetode->hari . '-' . $optionSetoran->bulanTahun;
        // }

        for($i = 1; $i < $jangka_waktu; $i++){
            $interestLoop   = $this->rumusInterest((floatval($interest)), $saldo_my_goals);
            // return response()->json($interestLoop);
            $rumusPajak     = 0;
            $saldo_my_goals += $setoran_berjangka + $interestLoop;
            $optionSetoran  = $this->optionSetoran($indexVal);
            if($saldo_my_goals >= $productRecord->sp_p_pajak_min_amount){
                $rumusPajak = $interestLoop * $productRecord->sp_p_pajak;
                $saldo_my_goals -= $rumusPajak;
            }
            if($metode_pendebetan == 3){
                $setoran_pertama = $resultMetode->hari . '-' . $optionSetoran->bulanTahun;
            }else if($metode_pendebetan == 1){
                $setoran_pertama = $optionSetoran->harian;
            }else{
                $setoran_pertama = $resultMetode->hari . $optionSetoran->mingguan;
            }
            $indexVal += 1;
            $row = [
                'saldo_my_goals'    => $saldo_my_goals,
                'period'            => $indexVal,
                'setoran_awal'      => $setoran_awal,
                'nominal'           => $setoran_berjangka,
                'pilihan'           => $resultMetode->pilihan,
                'interest'          => $interestLoop,
                'pajak'             => $rumusPajak,
                'setoran_pertama'   => $setoran_pertama
            ];
            array_push($records['interval'], $row);
        }

        return response()->json($records);
    }
    
    /**
     * Log Activity
     */

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

    /**
     * API BE Mba Novi
     */
    public function validasiNorek($params, Request $request){
        if(strtolower($params) == 'sumber'){
            $mt         = '2100';
            $mp         = [
                'ACCEXTSRC' => $request->noRek
            ];
        }else{
            $mt         = '2200';
            $mp         = [
                'ACCEXTDST' => $request->noRek
            ];
        }
        $data = [
            'MC'        => '50001',
            'MT'        => $mt,
            'PC'        => 'MYGOALS',
            'CC'        => '0000',
            'MP'        => $mp
        ];
        $record = sendAPI($data, 'validasi/rekening');
        
        $sisa_slot      = 0;
        $jumlah_data    = 0;
        if($mt == '2100'){
            $viewMygoals    = ViewSourceMyGoals::where('cif', $record->MP->ACCSRC_CIF)->first();
            $sisa_slot      = 5 - ($viewMygoals ? $viewMygoals->jumlah : 0);
            $jumlah_data    = $viewMygoals ? $viewMygoals->jumlah : 0;
        }
        $record->sisa_slot      = $sisa_slot;
        $record->jumlah_data    = $jumlah_data;

        return response()->json($record);
    }

}