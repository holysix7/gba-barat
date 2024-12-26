<?php

namespace App\Http\Controllers\Autodebit\Regular;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\SavdepProductCustomerMyGoal;
use App\Models\SavdepProduct;
use App\Models\SavdepProductCustomerReguler;
use App\Models\SavdepProductCustomerRegulerDetail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class DaftarRekeningController extends Controller
{
  public function index(){
    // $regulars = SavdepProductCustomerReguler::first();
    // $details  = SavdepProductCustomerRegulerDetail::first();
    return view('autodebit.regular.daftar-rekening.index');
  }

  public function ajax_goals(Request $request){
    if($request->search != null || $request->status_category != null){
      $search = $request->search;
      if($request->status_category != null){
        $records    = DB::table('savdep_product_customer_reguler_detail AS a')
        ->leftJoin('savdep_product_customer_regulars AS b', 'a.sd_pc_r_id', '=', 'b.sd_pc_r_id')
        ->select('a.sd_pc_rd_id', 'a.sd_pc_r_id', 'a.sd_pc_src_intacc', 'a.sd_pc_src_extacc', 'a.sd_pc_src_name', 'a.sd_pc_cif_src', 'a.sd_pc_src_gender', 'a.sd_pc_src_dob', 'a.sd_pc_src_notif_phone', 'a.sd_pc_src_notif_email', 'a.sd_pc_src_notif_status', 'a.sd_pc_src_notif_flag', 'a.sd_pc_dst_intacc', 'a.sd_pc_dst_extacc', 'a.sd_pc_dst_name', 'a.sd_pc_dst_gender', 'a.sd_pc_dst_dob', 'a.sd_pc_cif_dst', 'a.sd_pc_period', 'a.sd_pc_period_amount', 'a.sd_pc_period_date', 'a.sd_pc_check_flag', 'a.sd_pc_status', 'a.sd_pc_validate_blth', 'a.sd_pc_settledate')
        ->where('sd_pc_src_dob', $request->status_category)
        ->where(function($query)use ($search){
          $query->where('a.sd_pc_src_extacc', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_intacc', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_r_id', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_name', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_cif_src', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_gender', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_dob', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_cif_dst', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period_amount', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period_date', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_check_flag', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_status', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_validate_blth', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_settledate', 'ilike', "%$search%");
        })
        ->get();
      }else{
        $records    = DB::table('savdep_product_customer_reguler_detail AS a')
        ->leftJoin('savdep_product_customer_regulars AS b', 'a.sd_pc_r_id', '=', 'b.sd_pc_r_id')
        ->select('a.sd_pc_rd_id', 'a.sd_pc_r_id', 'a.sd_pc_src_intacc', 'a.sd_pc_src_extacc', 'a.sd_pc_src_name', 'a.sd_pc_cif_src', 'a.sd_pc_src_gender', 'a.sd_pc_src_dob', 'a.sd_pc_src_notif_phone', 'a.sd_pc_src_notif_email', 'a.sd_pc_src_notif_status', 'a.sd_pc_src_notif_flag', 'a.sd_pc_dst_intacc', 'a.sd_pc_dst_extacc', 'a.sd_pc_dst_name', 'a.sd_pc_dst_gender', 'a.sd_pc_dst_dob', 'a.sd_pc_cif_dst', 'a.sd_pc_period', 'a.sd_pc_period_amount', 'a.sd_pc_period_date', 'a.sd_pc_check_flag', 'a.sd_pc_status', 'a.sd_pc_validate_blth', 'a.sd_pc_settledate')
        ->where(function($query)use ($search){
          $query->where('a.sd_pc_src_extacc', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_intacc', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_r_id', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_name', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_cif_src', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_gender', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_src_dob', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_cif_dst', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period_amount', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_period_date', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_check_flag', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_status', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_validate_blth', 'ilike', "%$search%")
          ->orWhere('a.sd_pc_settledate', 'ilike', "%$search%");
        })
        ->get();
      }
      $resCount   = count($records);
    }else{
      $records    = DB::table('savdep_product_customer_reguler_detail AS a')
      ->leftJoin('savdep_product_customer_regulars AS b', 'a.sd_pc_r_id', '=', 'b.sd_pc_r_id')
      ->select('a.sd_pc_rd_id', 'a.sd_pc_r_id', 'a.sd_pc_src_intacc', 'a.sd_pc_src_extacc', 'a.sd_pc_src_name', 'a.sd_pc_cif_src', 'a.sd_pc_src_gender', 'a.sd_pc_src_dob', 'a.sd_pc_src_notif_phone', 'a.sd_pc_src_notif_email', 'a.sd_pc_src_notif_status', 'a.sd_pc_src_notif_flag', 'a.sd_pc_dst_intacc', 'a.sd_pc_dst_extacc', 'a.sd_pc_dst_name', 'a.sd_pc_dst_gender', 'a.sd_pc_dst_dob', 'a.sd_pc_cif_dst', 'a.sd_pc_period', 'a.sd_pc_period_amount', 'a.sd_pc_period_date', 'a.sd_pc_check_flag', 'a.sd_pc_status', 'a.sd_pc_validate_blth', 'a.sd_pc_settledate')
      ->where(function($query){
        $query->where('sd_pc_src_dob', 1)
        ->orWhere('sd_pc_src_dob', 5);
      })
      ->orderBy('a.sd_pc_src_gender', 'ASC')
      ->get();
      $resCount   = count($records);
    }
    $no = $request->start;
    foreach($records as $row){
      $row->rownum    = ++$no;
      $row->id        = Crypt::encrypt($row->id);
      $row->routeshow = route('autodebit.regular.daftar-rekening.show', $row->id);
    }
    $response = [
      "draw"              => $request->draw,
      "recordsTotal"      => $resCount,
      "recordsFiltered"   => $resCount,
      "data"              => $records,
      "search"            => $request->search,
      "status_category"   => $request->status_category
    ];

    return response()->json($response);
  }
}