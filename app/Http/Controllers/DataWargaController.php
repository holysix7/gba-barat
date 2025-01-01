<?php

namespace App\Http\Controllers;

use App\Exports\DataWargaExport;
use App\Http\Traits\GetListTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataWargaController extends Controller
{
    use GetListTrait;
    public function index(){
        $data = $this->getParams('data-warga');
        return view('data-warga', compact('data'));
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
        return Excel::download(new DataWargaExport($request), 'Data-Warga-'. date("Ymd-his") .'.xlsx');
    }
}