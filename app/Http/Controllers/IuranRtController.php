<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Exports\DataWargaExport;
use App\Exports\IuranRtExport;
use App\Http\Traits\GetListTrait;
use App\Models\IuranRt;
use App\Models\Keuangan;
use App\Models\Rt;
use App\Models\RwTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IuranRtController extends Controller
{
    use GetListTrait;

    public function index(){
        $data = $this->getParams('iuran-rt');
        return view('rw.iuran-rt', compact('data'));
    }

    public function getList(Request $request){
        $data  = IuranRt::ajax($request);
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $data->resCount,
            "recordsFiltered"   => $data->resCount,
            "data"              => $data->records
        ];
    
        return response()->json($response);
    }

    public function export(Request $request){
        return Excel::download(new IuranRtExport($request), 'Iuran-'. date("Ymd-his") .'.xlsx');
    }

    public function bayar(Request $request)
    {
        $values = json_decode($request->values);
        try {
            $iuran  = IuranRt::bayarRow($values);
            
            return redirect()->route('iuran-rt')->with([
                'message' => "Sukses merubah status bayar {$iuran->rt->name} untuk periode bulan {$iuran->bulan} tahun {$iuran->tahun}",
                'alert-type' => "success"
            ]);

        } catch (\Exception $e) {
            return redirect()->route('iuran-rt')->with([
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'alert-type' => "error"
            ]);
        }
    }

    public function create(Request $request){
        try {
            $iuran      = IuranRt::createRow($request);
            $rt_name    = data_get($iuran, 'rt.name');
            return redirect()->back()->with([
                'message' => "Sukses menambahkan tagihan baru untuk: {$rt_name}",
                'alert-type' => "success"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => "Terjadi kesalahan: ". $e->getMessage(),
                'alert-type' => "error"
            ]);
        }
    }

    public function update(Request $request){
        $iuran      = IuranRt::updateById($request);
        if(!is_null($iuran)){
            $rt_name    = data_get($iuran, 'rt.name');
            return redirect()->back()->with([
                'message' => "Sukses merubah tagihan untuk {$rt_name}",
                'alert-type' => "success"
            ]);
        }else{
            return redirect()->back()->with([
                'message' => "Tagihan wajib diisi",
                'alert-type' => "error"
            ]);
        }
    }
}