<?php

namespace App\Http\Controllers\DataWarehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ExportingData;
use App\Models\SavdepDownloadManager;

class DataWarehouseController extends Controller
{
  public function index(){
    return view('data-warehouse.index');
  }

  public function ajax(Request $request){
    $sql        = SavdepDownloadManager::where('branch_code', Session::get('user')->kodeCabang);
    $sql        = $sql->orderBy('id', 'desc');
    $resCount   = $sql->count();
    $sql        = $sql->skip($request->start)->take(10);
    $records    = $sql->get();
    $i = 1;
    foreach($records as $row){
      $row->rownum = $i++;
      $row->route = route('data-warehouse.download', Crypt::encrypt($row->path . $row->filename));
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

  public function download($params){
    $decrypted = Crypt::decrypt($params);
    if(file_exists(storage_path(str_replace('\\', '/', $decrypted)))){
      $result = response()->download(storage_path(str_replace('\\', '/', $decrypted)));
    }else{
      $result = redirect()->back()->with([
        'message'     => "Data tersebut belum selesai",
        'alert-type'  => "danger"
      ]);
    }
    return $result;
  }
  
  public function delete(Request $request){
    $record   = SavdepDownloadManager::find($request->id);
    $docName  = $record->filename;
    if(unlink(storage_path(str_replace('\\', '/', $record->path . $record->filename)))){
      $record->delete();
    }
    return redirect()->back()->with([
      'message'     => 'Berhasil menghapus dokumen '. $docName,
      'alert-type'  => 'success'
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