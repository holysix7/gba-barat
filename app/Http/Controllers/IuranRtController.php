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
        $iuran = null;

        try {
            DB::beginTransaction();

            // Update tagihan
            $iuran = IuranRt::getRow($values);

            if (!$iuran) {
                throw new \Exception("Data Iuran tidak ditemukan.");
            }

            $iuran->status_bayar = true;
            $iuran->save();

            // Update keuangan rw dan laporan keuangan
            $laporan_keuangan = RwTransaction::transaction($iuran, 'debit');
            if (!$laporan_keuangan) {
                throw new \Exception("Gagal memperbarui laporan keuangan.");
            }

            DB::commit();

            return redirect()->route('iuran-rt')->with([
                'message' => "Sukses merubah status bayar {$iuran->rt->name} untuk periode bulan {$iuran->bulan} tahun {$iuran->tahun}",
                'alert-type' => "success"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iuran-rt')->with([
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
                'alert-type' => "error"
            ]);
        }
    }
}