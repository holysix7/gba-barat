<?php

namespace App\Http\Controllers;

use App\Exports\DataWargaExport;
use App\Models\IuranRt;
use App\Models\Rt;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IuranController extends Controller
{
    public function index(){
        $month = date('m');
        return view('iuran', compact('month'));
    }

    public function getList(Request $request){
        $data = IuranRt::ajax($request);
        // $data = Rt::with(['user'])->get();
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $data->resCount,
            "recordsFiltered"   => $data->resCount,
            "data"              => $data->records
        ];
    
        return response()->json($response);
    }

    public function export(Request $request){
        return Excel::download(new DataWargaExport($request), 'Iuran-'. date("Ymd-his") .'.xlsx');
    }
}