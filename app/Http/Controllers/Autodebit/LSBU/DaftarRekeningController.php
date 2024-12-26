<?php

namespace App\Http\Controllers\Autodebit\LSBU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductCustomerLsbu;
use App\Models\SavdepProductCustomerLsbuClose;
use App\Models\SavdepLsbuUpdate;
use App\Models\SavdepProduct;
use App\Models\SavdepTransaction;
use App\Models\ViewSourceLsbu;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Autodebit\LSBU\DaftarRekeningExport;
use App\Exports\Autodebit\LSBU\DaftarRekeningQueueExport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use \PDF;
use App\Jobs\ExportingData;
use App\Http\Traits\MyGoalsTrait;

class DaftarRekeningController extends Controller
{
    use MyGoalsTrait;
    
    public function index(){
        $maxDate = date('Y-m-d');
        return view('autodebit.lsbu.daftar-rekening.index', compact('maxDate'));
    }

    public function ajax(Request $request){
        if($request->search != null || $request->status_category != null){
            $search = $request->search;
            if($request->status_category != null){
                $sql    = DB::table('savdep_product_customer_lsbu AS a')
                    ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                    ->where('a.sp_pc_status', $request->status_category)
                    ->where('a.sp_pc_branch_reg', Session::get('user')->kodeCabang)
                    ->where(function($query)use ($search){
                        $query->where('a.sd_pc_dst_extacc', 'ilike', "%$search%")
                        ->orWhere('a.sd_pc_src_intacc', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_dst_name', 'ilike', "%$search%")
                        ->orWhere('a.sd_pc_pid', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_period', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_reg_date', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_status', 'ilike', "%$search%")
                        ->orWhere('b.sd_p_name', 'ilike', "%$search%");
                    });
            }else{  
                $sql    = DB::table('savdep_product_customer_lsbu AS a')
                    ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                    ->where('sp_pc_branch_reg', Session::get('user')->kodeCabang)
                    ->where(function($query) use($search){
                        $query->where('a.sp_pc_status', 1)
                        ->orWhere('a.sp_pc_status', 0);
                    })
                    ->where(function($query)use ($search){
                        $query->where('a.sd_pc_dst_extacc', 'ilike', "%$search%")
                        ->orWhere('a.sd_pc_src_intacc', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_dst_name', 'ilike', "%$search%")
                        ->orWhere('a.sd_pc_pid', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_period', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_reg_date', 'ilike', "%$search%")
                        ->orWhere('a.sp_pc_status', 'ilike', "%$search%")
                        ->orWhere('b.sd_p_name', 'ilike', "%$search%");
                    });
            }
        }else{
            $sql    = DB::table('savdep_product_customer_lsbu AS a')
                ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
                ->where('sp_pc_branch_reg', Session::get('user')->kodeCabang)
                ->where(function($query){
                    $query->where('a.sp_pc_status', 1)
                    ->orWhere('a.sp_pc_status', 0);
                });
        }
        $sql        = $sql->orderBy('a.sp_pc_reg_date', 'DESC');
        $resCount   = $sql->count();
        $sql        = $sql->skip($request->start)->take($request->length);
        $records    = $sql->get();
        $no         = $request->start;
        foreach($records as $row){
            $row->rownum    = ++$no;
            $row->routeshow = route('autodebit.lsbu.daftar-rekening.show', Crypt::encrypt($row->sd_pc_dst_extacc));
        }
        $response = [
            "search"            => $request->search,
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }

    public function show($params){
        // dd(Crypt::decrypt($params));
        $record    = DB::table('savdep_product_customer_lsbu AS a')
            ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where('a.sd_pc_dst_extacc', Crypt::decrypt($params))
            ->first();
        $record->progress       = intval(($record->sp_pc_current_period_sukses / $record->sp_pc_period) * 100);
        $record->routeRiwayat   = route('autodebit.lsbu.daftar-rekening.transaksi', $params);
        $record->routeInquiry   = route('autodebit.lsbu.daftar-rekening.show-inquiry', $params);
        $record->routeEdit      = route('autodebit.lsbu.daftar-rekening.edit', $params);
        
        $maxDate = date('Y-m-d');
        // dd($record);
        return view('autodebit.lsbu.daftar-rekening.index', compact('record', 'maxDate'));
    }

    public function ajax_show(Request $request){
        $record = SavdepProductCustomerLsbu::where('sd_pc_src_intacc', $request->sd_pc_src_intacc)->first();
        return response()->json($record);
    }

    public function show_inquiry($params){
        // dd(Crypt::decrypt($params));
        $record    = DB::table('savdep_product_customer_lsbu AS a')
            ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where('a.sd_pc_dst_extacc', Crypt::decrypt($params))
            ->first();
        $dataTransaksi      = SavdepTransaction::select('sd_t_dt')->where([
            ['sd_t_dep_acc', $record->sd_pc_dst_extacc],
            ['sd_t_reg_lsbu', $record->sp_pc_reg_id]
        ])->orderBy('sd_t_dt', 'asc');
        $counted = $dataTransaksi->count();
        $tglMulaiAutodebit = $dataTransaksi->first();
        $record->routeshow          = route('autodebit.lsbu.daftar-rekening.show', $params);
        $record->tglReg             = date('d M Y', strtotime($record->sp_pc_reg_date));
        $record->tglMulai           = $tglMulaiAutodebit ? date('d M Y', strtotime($tglMulaiAutodebit->sd_t_dt)) : null;
        $record->sd_t_dt            = $tglMulaiAutodebit ? $tglMulaiAutodebit->sd_t_dt : null;
        $record->transactionDone    = $counted ? $counted : 0;
        $record->saldoTercapai      = $record->sp_pc_debet_total_amount;
        $record->formSubmit         = route('autodebit.lsbu.daftar-rekening.show-inquiry', $params);
        $maxDate = date('Y-m-d');
        // dd($record->sd_t_dt);
        return view('autodebit.lsbu.daftar-rekening.index', compact('record', 'maxDate'));
    }

    public function penutupan($params, Request $request){
        $record = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', $request->sd_pc_dst_extacc)->first();
        if($request->condition_autodebit > 0){
            $record->sp_pc_approval_status = 2;
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

    public function new(){
        $days = [];
        for($i = 1; $i <= 25; $i++){
            array_push($days, $i);
        }
        $days   = json_encode($days);
        $maxDate = date('Y-m-d');
        $product = SavdepProduct::where('sd_p_id', 'LSBU')->first();
        // dd($product);
        return view('autodebit.lsbu.daftar-rekening.index', compact('days', 'maxDate', 'product'));
    }
    
    public function confirm(Request $request){
        $clearCache     = Cache::flush();
        $cached         = Cache::put('newRekening', $request->all());
        $message        = 'Success, berhasil mengisi form pendaftaran!';
        $alert          = 'success';
        $route          = 'autodebit.lsbu.daftar-rekening.confirm-menu';
        $params         = Crypt::encrypt(Cache::get('newRekening'));
        return redirect()->route($route, $params)->with(
            $notification = array(
                'message' => $message,
                'alert-type' => $alert
            )
        );
    }
    
    public function form_confirm($params){
        $dataCache = Crypt::decrypt($params);
        // dd($dataCache);
        if(count($dataCache) > 4){
            // dd($dataCache['sd_pc_dst_extacc']);
            $dataSumber = [
                'sd_pc_src_extacc'  => $dataCache['sd_pc_src_extacc'] ? $dataCache['sd_pc_src_extacc'] : null,
                'sd_pc_src_name'    => $dataCache['sd_pc_src_name'] ? $dataCache['sd_pc_src_name'] : null,
                'sd_pc_src_intacc'  => $dataCache['sd_pc_src_intacc'] ? $dataCache['sd_pc_src_intacc'] : null,
                'sd_pc_src_branch'  => $dataCache['sd_pc_src_branch'] ? $dataCache['sd_pc_src_branch'] : null,
                'accsrc_type_name'  => $dataCache['accsrc_type_name'] ? $dataCache['accsrc_type_name'] : null,
                'accsrc_currency'   => $dataCache['accsrc_currency'] ? $dataCache['accsrc_currency'] : null,
                'accsrc_cif'        => $dataCache['accsrc_cif'] ? $dataCache['accsrc_cif'] : null,
                'accsrc_type'       => $dataCache['accsrc_type'] ? $dataCache['accsrc_type'] : null
            ];
            $dataTujuan = [];
            
            foreach($dataCache['sd_pc_dst_extacc'] as $key => $extacc){
                foreach($dataCache['sp_pc_dst_name'] as $keyName => $name){
                    foreach($dataCache['sp_pc_period'] as $keyPeriod => $period){
                        foreach($dataCache['sp_pc_period_amount'] as $keyPeriodAmount => $periodAmount){
                            foreach($dataCache['sp_pc_period_date'] as $keyPeriodDate => $periodDate){
                                foreach($dataCache['accintdst'] as $keyIntDst => $accIntDst){
                                    foreach($dataCache['accdst_type'] as $keyDstType => $accDstType){
                                        foreach($dataCache['accdst_type_name'] as $keyDstTypeName => $accDstTypeName){
                                            if($key == $keyName && $keyName == $keyPeriod && $keyPeriod == $keyPeriodAmount && $keyPeriodAmount == $keyPeriodDate && $keyPeriodDate == $keyIntDst && $keyIntDst == $keyDstType && $keyDstType == $keyDstTypeName){
                                                $row = [
                                                    'sd_pc_dst_extacc'      => $extacc,
                                                    'sp_pc_dst_name'        => $name,
                                                    'sp_pc_period'          => $period,
                                                    'sp_pc_period_amount'   => $periodAmount,
                                                    'sp_pc_period_date'     => $periodDate,
                                                    'accintdst'             => $accIntDst,
                                                    'accdst_type'           => $accDstType,
                                                    'accdst_type_name'      => $accDstTypeName
                                                ];
                                                array_push($dataTujuan, (object)$row);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $record['data_sumber']  = (object)$dataSumber;
            $record['data_tujuan']  = $dataTujuan;
            $record['today']        = date("d M Y");
            // dd($record['data_tujuan']);
            $maxDate = date('Y-m-d');
            return view('autodebit.lsbu.daftar-rekening.index', compact('record', 'maxDate'));
        }else{
            return redirect()->back()->with([
                'message'   => 'Harap isi rekening tujuan terlebih dahulu',
                'alert-type'=> 'danger'
            ]);
        }
    }

    public function create(Request $request){
        $result = $this->pengajuanRegistrasi($request->all());
        
        if($result == true){
            userActivities('Create', 'Menambahkan data', 'savdep_product_customer_lsbu', 'General', Route::current()->getName());
            $message    = 'Success, berhasil menambahkan data!';
            $alert      = 'success';
            $route      = 'autodebit.lsbu.daftar-rekening.result';
            return redirect()->route($route, [Crypt::encrypt($request->all()), 'pendaftaran'])->with(
                $notification = array(
                    'message' => $message,
                    'alert-type' => $alert
                )
            );
        }else{
            $message    = 'Error, ketika menambahkan data!';
            $alert      = 'danger';
            $route      = 'autodebit.lsbu.daftar-rekening.new';
            return redirect()->route($route)->with(
                $notification = array(
                    'message' => $message,
                    'alert-type' => $alert
                )
            );
        }
    }

    public function result($params, $paramsDua){
        $element = Crypt::decrypt($params);
        $maxDate = date('Y-m-d');
        // dd($element['data_tujuan']);
        $routeVerifNow = route('autodebit.lsbu.approval.show', Crypt::encrypt(is_array($element) ? $element['sd_pc_src_extacc'] : $element));

        return view('autodebit.lsbu.daftar-rekening.index', compact('routeVerifNow', 'maxDate'));
    }

    public function show_transaksi(Request $request){
        $sp_pc_reg_id       = $request->sp_pc_reg_id;
        $sd_pc_dst_extacc   = $request->sd_pc_dst_extacc;
        $type               = $request->type;
        if($type == 'aktif'){
            $parent             = SavdepProductCustomerLsbu::where('sp_pc_reg_id', $sp_pc_reg_id)->first();
        }else{
            $parent             = SavdepProductCustomerLsbuClose::where('sp_pc_reg_id', $sp_pc_reg_id)->first();
        }
        $transactions       = SavdepTransaction::where([
            ['sd_t_reg_lsbu', '=', $sp_pc_reg_id],
            ['sd_t_rc', '=', 'R'],
        ])->get();
        if($parent){
            if($transactions){
                $status = 200;
                $message = 'Success';
            }else{
                $status = 200;
                $message = 'Gagal query transaksi: '. $sd_pc_dst_extacc;
            }
        }else{
            $status = 200;
            $message = 'Gagal query parent: '. $sd_pc_dst_extacc;
        }
        $records = [
            'type'      => $type,
            'status'    => $status,
            'message'   => $message,
            'data'      => [
                'parent'        => $parent ? $parent : null,
                'transactions'  => $transactions ? $transactions : []
            ]
        ];
        return response()->json($records);
    }

    public function export(Request $request){        
        $counted = 0;
        $counted = SavdepProductCustomerLsbu::where('sp_pc_status', $request->sd_pc_status)
        ->where('sp_pc_branch_reg', Session::get('user')->kodeCabang)
        ->whereBetween('sp_pc_reg_date', [$request->start_date ." 00:00:00", $request->end_date ." 23:59:59"])->count();
        if($counted > 0){
            $array = [
                "branch_code"   => Session::get('user')->kodeCabang,
                "counted"       => $counted,
                "type"          => 'LSBU - Daftar Rekening',
                "request"       => $request->all()
            ];
            ExportingData::dispatch($array);
            userActivities('Export', 'Melakukan export data daftar rekening lsbu', 'savdep_product_customer_lsbu', 'General', Route::current()->getName());
            $message    = 'Berhasil melakukan export silahkan klik link <a href="'. route("download-manager") .'">ini</a>';
            $alert      = 'success';
        }else{
            $message    = 'Gagal melakukan export karena tidak ada data pada tanggal: <b>'. $request->start_date .' - '. $request->end_date . '</b>';
            $alert      = 'danger';
        }
        return redirect()->back()->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function edit($params){
        $record    = DB::table('savdep_product_customer_lsbu AS a')
            ->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
            ->where('a.sd_pc_dst_extacc', Crypt::decrypt($params))
            ->first();
        $record->progress           = intval(($record->sp_pc_current_period / $record->sp_pc_period) * 100);
        $record->routeSubmit        = route('autodebit.lsbu.daftar-rekening.edit', $params);
        // dd($record->sp_p_min_period);
        $record->minimalJangkaWaktu = $record->sp_pc_current_period < $record->sp_p_min_period ? $record->sp_p_min_period : $record->sp_pc_current_period + 2;
        $record->minimalSetoran     = $record->sp_p_min_period_amount;
        $maxDate    = date('Y-m-d');
        $days       = [];

        for($i = 1; $i <= 25; $i++){
            array_push($days, $i);
        }
        
        $days   = $days;
        // dd($days);
        return view('autodebit.lsbu.daftar-rekening.index', compact('record', 'maxDate', 'days'));
    }

    public function update($params, Request $request){
        $recordLsbu = SavdepProductCustomerLsbu::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
        $recordLsbu->sp_pc_approval_status = 5;
        $recordLsbu->save();
        
        $record = new SavdepLsbuUpdate();
        $record->sd_pc_dst_extacc       = Crypt::decrypt($params);
        $record->sp_pc_period           = $request->sp_pc_period;
        $record->sp_pc_period_date      = $request->sp_pc_period_date;
        $record->sp_pc_period_amount    = str_replace('.', '', $request->sp_pc_period_amount);
        
        if($record->save()){
            $message    = 'Berhasil request perubahan data '. Crypt::decrypt($params) .' silahkan lakukan approval';
            $alert      = 'success';
        }else{
            $message    = 'Gagal mengubah data '. Crypt::decrypt($params);
            $alert      = 'danger';
        }
        
        return redirect()->route('autodebit.lsbu.daftar-rekening')->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function ajax_simulasi_autodebit(Request $request){
        $records['setoran_awal'] = [];
        $records['interval'] = [];
        $setoran_berjangka  = $request->setoran_berjangka;
        $jangka_waktu       = $request->jangka_waktu;
        $rek_tujuan         = $request->rek_tujuan;
        $tanggal            = $request->tanggal;
        $productRecord      = SavdepProduct::where('sd_p_id', 'LSBU')->first();
        $interest           = $productRecord ? $productRecord->interest ? $productRecord->interest->sd_ps_variable : null : null;
        $saldo_lsbu         = 0;

        $resultMetode   = $this->conditionPendebetan($request, 0);
        $date   = explode('-', date('Y-m-d'));
        $tahun  = $date[0];
        $bulan  = $date[1];
        $hari   = $tanggal;
        //bulan depan
        $indexVal = 0;
        if(strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $hari)))){
            $indexVal = 1;
        }
        for($i = 1; $i <= $jangka_waktu; $i++){
            $interestLoop       = $this->rumusInterest((intval($interest) ? $interest : 0), $setoran_berjangka);
            $saldo_lsbu         += $setoran_berjangka + $interestLoop;
            $optionSetoran      = $this->optionSetoran($indexVal);
            $setoran_pertama    = $tanggal . '-' . $optionSetoran->bulanTahun;
            $row = [
                'saldo_my_goals'    => $saldo_lsbu,
                'period'            => $i,
                'setoran_awal'      => '',
                'nominal'           => $setoran_berjangka,
                'pilihan'           => $resultMetode->pilihan,
                'interest'          => $interestLoop,
                'setoran_pertama'   => $setoran_pertama
            ];
            array_push($records['interval'], $row);
            $indexVal ++;
        }

        return response()->json($records);
    }

    public function riwayatSumber(Request $request){
        $records = SavdepProductCustomerLsbu::select('sd_pc_dst_extacc', 'sp_pc_period_amount', 'sp_pc_period', 'sp_pc_current_period_sukses', 'sp_pc_reg_date', 'sp_pc_dst_name', 'sp_pc_branch_reg')->where('sd_pc_src_extacc', $request->rekSumber)->get();
        foreach($records as $key => $record){
            $record->rownum = $key+1;
        }
        return response()->json($records);
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
            'MC'    => '50002',
            'MT'    => $mt,
            'PC'    => 'LSBU',
            'CC'    => '0000',
            'MP'    => $mp
        ];
        $record                 = sendAPI($data, 'validasi/rekening');
        $viewLsbu               = ViewSourceLsbu::where('rekening_sumber', $request->noRek)->first();
        $record->sisa_slot      = 10 - ($viewLsbu ? $viewLsbu->jumlah : 0);
        $record->jumlah_data    = $viewLsbu ? $viewLsbu->jumlah : 0;
        return response()->json($record);
    }
    
    //encapsulation
    public function pengajuanRegistrasi($parameter){
        $data_tujuan = [];
        foreach(json_decode($parameter['data_tujuan']) as $row){
            $element = [
                "ACCDST_TYPE"       => $row->accdst_type,
                "ACCDST_TYPE_NAME"  => $row->accdst_type_name,
                "ACCDST_NAME"       => $row->sp_pc_dst_name,
                "ACCEXTDST"         => $row->sd_pc_dst_extacc,
                "ACCSRC_NAME"       => $parameter['sd_pc_src_name'],
                "ACCINTSRC"         => $parameter['sd_pc_src_intacc'],
                "ACCSRC_BRANCH"     => $parameter['sd_pc_src_branch'],
                "ACCSRC_TYPE_NAME"  => $parameter['accsrc_type_name'],
                "ACCSRC_CURRENCY"   => $parameter['accsrc_currency'],
                "ACCSRC_CIF"        => $parameter['accsrc_cif'] ? $parameter['accsrc_cif'] : '',
                "ACCEXTSRC"         => $parameter['sd_pc_src_extacc'],
                "ACCSRC_TYPE"       => $parameter['accsrc_type'],
                "DST_CURRENCY"      => $parameter['accsrc_currency'],            
                "PERIOD"            => $row->sp_pc_period,
                "PERIOD_AMOUNT"     => str_replace('.', '', $row->sp_pc_period_amount),
                "PERIOD_DATE"       => $row->sp_pc_period_date,            
                "USER_ID"           => Session::get('user')->userId,
                "BRANCHCD"           => Session::get('user')->kodeCabang,
            ];
            array_push($data_tujuan, $element);
        }
        $data = [
            'MC' => "50002",
            'MT' => "2300",
            'PC' => "LSBU",
            'CC' => "0000",
            'MP' => $data_tujuan
        ];
        // return $data;
        $record = sendAPI($data, 'registration');
        if($record->RC == '0000'){
            $status = true;
        }else{
            $status = false;
        }
        return $status;
    }
}