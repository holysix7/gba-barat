<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductCustomerMyGoal;

trait MyGoalsTrait 
{
  public function pengajuanRegistrasi($parameter){
		$myGoals = json_decode($parameter['mygoals'], true);
		$mpArray = [];
		foreach($myGoals as $row){
			$mpArray[] = [	
				"ACCSRC_NAME"			=> $parameter['sd_pc_src_name'],
				"ACCINTSRC"				=> $parameter['sd_pc_src_extacc'],
				"ACCSRC_BRANCH"			=> $parameter['sd_pc_src_branch'],
				"ACCSRC_CURRENCY"		=> "IDR",
				"ACCSRC_CIF"			=> $parameter['sd_pc_cif_src'],
				"ACCEXTSRC"				=> $parameter['sd_pc_src_extacc'],
				"ACCSRC_TYPE"			=> $parameter['account_type_src'],
				"ACCINTDST"				=> $row['ACCINTDST'],
				"ACCDST_TYPE"			=> $row['ACCDST_TYPE'],
				"ACCDST_CIF"			=> $row['ACCDST_CIF'],
				"ACCDST_NAME"			=> $row['ACCDST_NAME'],
				"ACCDST_BRANCH"			=> $row['ACCDST_BRANCH'],
				"ACCEXTDST"				=> $row['sd_pc_dst_extacc'],
				"ACCDST_CURRENCY"		=> $row['ACCDST_CURRENCY'],
				"MISI_UTAMA"			=> $row['sp_pc_misi_utama'],
				"BRANCHCD"				=> Session::get('user')->kodeCabang,
				"AIM"					=> $row['sp_pc_aim'],
				"MAIL_ADDRESS"			=> $row['sd_pc_notif_email'] ? $row['sd_pc_notif_email'] : '',
				"PHONE_NUMBER"			=> $row['sd_pc_notif_phone'] ? $row['sd_pc_notif_phone'] : '',
				"NOTIFICATION_STATUS"	=> $row['sd_pc_notif_flag'],
				"PERIOD_DAY"			=> $row['sp_pc_jenis_period'] == 2 ? $row['sp_pc_period_date'] : '',
				"PERIOD_INTERVAL"		=> $row['sp_pc_jenis_period'],
				"INIT_AMOUNT"			=> str_replace('.', '', $row['sp_pc_init_amount']),
				"TARGET_GOALS"			=> str_replace('.', '', $row['sp_pc_target_amount']),
				"DST_DOB"				=> $parameter['sd_pc_dob'] ? $parameter['sd_pc_dob'] : '',
				"DST_GENDER"			=> $parameter['sd_pc_gender'] ? $parameter['sd_pc_gender'] : '',
				"PERIOD"				=> 20,
				"PERIOD_AMOUNT"			=> str_replace('.', '', $row['sd_pc_period_amount']),
				"PERIOD_DATE"			=> $row['sp_pc_jenis_period'] == 3 ? $row['sp_pc_period_date'] : '',
				"USER_ID"				=> Session::get('user')->userId
			];
		}
        
		$data = [
			"MC"=> "50001",
			"MT"=> "2300",
			"PC"=> "MYGOALS",
			"CC"=> "0000",
			"MP"=> $mpArray
		];
		$record = sendAPI($data, 'registration');
		if($record->RC == '0000'){
			$status = true;
		}else{
			$status = false;
		}
		$response = [
			'status' => $status,
			'message' => $record->RC_DESC,
		];
		return $response;
  }

  public function rumusInterest($interest, $saldo){
      $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
      $jumlahHariTahun = 0;
      for($j = 1; $j <= 12; $j++){
        $jumlahHariTahun += cal_days_in_month(CAL_GREGORIAN,date('m', strtotime("2022-$j-1")),date('Y'));
      }
      $result = floatval($interest) ? (($interest / 1000) * $saldo * $jumlahHariBulan ) / $jumlahHariTahun : 0;

      return $result;
  }

  public function optionSetoran($index){
      $object = (object)[
          'bulanTahun'    => date('M-Y', strtotime("+ $index months")),
          'mingguan'      => date(', d-M-Y', strtotime("+ $index weeks")),
          'harian'        => date('D, d-M-Y', strtotime("+ $index days"))
      ];

      return $object;
  }

  public function conditionPendebetan($request, $metode_pendebetan){
      //tidak memilih karena harian
      $type       = 'Harian';
      $pilihan    = '';
      $hari_ini   = date('D, d-M-Y');
      $hari       = '';
      if($metode_pendebetan == 3){
          //pilih tanggal berapa
          $type     = 'Bulanan';
          $pilihan  = $request->pilihan_pembayaran;
          $hari     = $pilihan;
          if($request->product == 'mygoals'){
            $hari     = $request->tgl_minggu_id;
          }
      }
      if($metode_pendebetan == 2){
        //pilih hari apa
          $type     = 'Mingguan';
          $pilihan  = $request->pilihan_pembayaran;
          if($pilihan == '01'){
              $hari     = 'Mon';
          }else if($pilihan == '02'){
              $hari     = 'Tues';
          }else if($pilihan == '03'){
              $hari     = 'Wed';
          }else if($pilihan == '04'){
              $hari     = 'Thurs';
          }else if($pilihan == '05'){
              $hari     = 'Fri';
          }else if($pilihan == '06'){
              $hari     = 'Sat';
          }else{
              $hari     = 'Sun';
          }
      }

      $object = (object)[
          'type'      => $type,
          'pilihan'   => $pilihan,
          'hari'      => $hari,
          'hari_ini'  => $hari_ini
      ];

      return $object;
  }

  public function ajaxList($request){
    $sql    = DB::table('savdep_product_customer_mygoals AS a');
    $conditions = 'real';

    // if($request->status_category == 5){
    //     $sql    = DB::table('savdep_product_customer_mygoals_temp AS a');
    //     $conditions = 'temp';
    // }

    $sql    = $sql->leftJoin('savdep_product AS b', 'a.sd_pc_pid', '=', 'b.sd_p_id')
    ->where('a.sp_pc_branch_reg', Session::get('user')->kodeCabang);

    $sql = $sql->where('a.sp_pc_status', $request->status_category);
    
    if($request->search){
        $sql = $sql->where(function($query)use ($search){
            $query->where('a.sd_pc_dst_extacc', 'ilike', "%$search%")
            ->orWhere('a.sd_pc_src_intacc', 'ilike', "%$search%")
            ->orWhere('a.sp_pc_dst_name', 'ilike', "%$search%")
            ->orWhere('a.sd_pc_pid', 'ilike', "%$search%")
            ->orWhere('a.sp_pc_period_date', 'ilike', "%$search%")
            ->orWhere('a.sp_pc_period', 'ilike', "%$search%")
            ->orWhere('a.sp_pc_reg_date', 'ilike', "%$search%")
            ->orWhere('a.sp_pc_status', 'ilike', "%$search%")
            ->orWhere('b.sd_p_name', 'ilike', "%$search%");
        });
    }
    $sql = $sql->orderBy('a.sp_pc_reg_date', 'DESC');
    $resCount   = $sql->count();
    $sql        = $sql->skip($request->start)->take($request->length);
    $records    = $sql->get();
    $no         = $request->start;
    foreach($records as $row){
      $row->rownum      = ++$no;
      $row->conditions  = $conditions;
      $row->routeshow   = route('autodebit.mygoals.daftar-rekening.show', Crypt::encrypt($row->sd_pc_dst_extacc));
    }
    $result = (object)[
        'resCount'  => $resCount,
        'records'   => $records
    ];
    return $result;
  }

  public function showRecord($params){
    $record = SavdepProductCustomerMyGoal::where('sd_pc_dst_extacc', Crypt::decrypt($params))->first();
    $record->product                    = $record->product ? $record->product : null;
    $record->counted_success            = 0;
    $record->counted_fail               = 0;
    $record->routeInquiry               = route('autodebit.mygoals.daftar-rekening.show-inquiry', Crypt::encrypt($record->sd_pc_dst_extacc));
    $record->saldo_tercapai             = ($record->sp_pc_debet_total_amount / $record->sp_pc_target_amount) * 100;
    $record->saldo_tercapai_goals       = ($record->sp_pc_current_period / $record->sp_pc_period) * 100;
    $record->saldo_berjangka            = ($record->sd_pc_period_amount * $record->counted_success) + $record->sd_pc_init_amount;
    $record->saldo_success_autodebet    = $record->sd_pc_period_amount * $record->counted_success;
    $record->saldo_fail_autodebet       = $record->sd_pc_debet_fail_count * $record->sd_pc_period_amount;
    $record->sp_pc_notif_status_name    = $record->sp_pc_notif_status > 0 ? $record->sp_pc_notif_status == 1 ? 'SMS' : $record->sp_pc_notif_status == 2 ? 'Email' : 'SMS dan Email' : 'Tidak Aktif';
    $record->sp_pc_period_interval_name = $record->sp_pc_period_interval > 1 ? $record->sp_pc_notif_status == 2 ? 'Mingguan' : 'Bulanan' : 'Harian';
    $record->transactions               = $record->transactions ? $record->transactions : [];
    if($record->sd_pc_period_interval == 0){
      $record->sd_pc_period_interval_text = 'Bulanan';
    }elseif($record->sd_pc_period_interval == 1){
      $record->sd_pc_period_interval_text = 'Harian';
    }else{
      $record->sd_pc_period_interval_text = 'Mingguan';
    }

    return $record;
  }

	public function namaHari($sp_pc_period_date, $sp_pc_jenis_period){
		$nama_hari = 'Setiap Hari';
		if($sp_pc_jenis_period == 2){
			$nama_hari = 'Setiap hari: Sabtu';
			if($sp_pc_period_date == '01'){
				$nama_hari = 'Setiap hari: Minggu';
			}
			if($sp_pc_period_date == '02'){
				$nama_hari = 'Setiap hari: Senin';
			}
			if($sp_pc_period_date == '03'){
				$nama_hari = 'Setiap hari: Selasa';
			}
			if($sp_pc_period_date == '04'){
				$nama_hari = 'Setiap hari: Rabu';
			}
			if($sp_pc_period_date == '05'){
				$nama_hari = 'Setiap hari: Kamis';
			}
			if($sp_pc_period_date == '06'){
				$nama_hari = 'Setiap hari: Jumat';
			}
		}
		if($sp_pc_jenis_period == 3){
			$nama_hari = 'Setiap tanggal: '. $sp_pc_period_date;
		}

		return $nama_hari;
	}

	public function jenisPeriod($sp_pc_jenis_period){
		$nama_jenis_period = 'Bulanan';
		if($sp_pc_jenis_period == 2){
			$nama_jenis_period = 'Mingguan';
		}
		if($sp_pc_jenis_period == 1){
			$nama_jenis_period = 'Harian';
		}
		return $nama_jenis_period;
	}

	public function namaNotif($sd_pc_notif_flag){
		$string = 'Tidak Aktif';
		if($sd_pc_notif_flag == 1){
			$string = 'SMS';
		}
		if($sd_pc_notif_flag == 3){
			$string = 'Email';
		}
		if($sd_pc_notif_flag == 4){
			$string = 'SMS dan Email';
		}

		return $string;
	}
}