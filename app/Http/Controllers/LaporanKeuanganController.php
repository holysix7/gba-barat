<?php

namespace App\Http\Controllers;

use App\Exports\DataWargaExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuanganController extends Controller
{
    public function index(){
        return view('laporan-keuangan');
    }

    public function getList(Request $request){
        $data = User::ajax($request);
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