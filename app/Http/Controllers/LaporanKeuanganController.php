<?php

namespace App\Http\Controllers;

use App\Exports\DataWargaExport;
use App\Http\Traits\GetListTrait;
use App\Models\Keuangan;
use App\Models\RwTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuanganController extends Controller
{
    use GetListTrait;
    public function index(){
        $data = $this->getParams('laporan-keuangan');
        return view('rw.laporan-keuangan', compact('data'));
    }

    public function getList(Request $request){
        $data = RwTransaction::ajax($request);
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $data->resCount,
            "recordsFiltered"   => $data->resCount,
            "data"              => $data->records
        ];
    
        return response()->json($response);
    }

    public function export(Request $request){
        return Excel::download(new DataWargaExport($request), 'Laporan-Keuangan-'. date("Ymd-his") .'.xlsx');
    }
}