<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetListTrait;
use App\Models\InfoWarga;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    use GetListTrait;
    
    public function index(){
        $data = $this->getParams('timeline');
        return view('timeline.index', compact('data'));
    }

    public function getInfoWarga(Request $request){
        $limit = intval($request->get('limit', 2)); 
        $start = intval($request->get('start', 0)); 
        
        $query = InfoWarga::ajax($start, $limit);
        $data  = data_get($query, 'data', []);
        $counted  = data_get($query, 'counted', 0);

        $prev = max($start - $limit, 0);
        $next = ($start + $limit < $counted) ? $start + $limit : $start;
        $has_more = ($start + $limit) < $counted;

        
        $response = [
            'start'   => $start,
            'prev'    => $prev,
            'next'    => $next,
            'counted' => $counted,
            'hasMore' => $has_more,
            'data'    => $data, 
        ];

        return response()->json($response);
    }

    public function create(Request $request){
        $info_warga = InfoWarga::create($request);
        if(!is_null($info_warga)){
            return redirect()->back()->with([
                'message' => "Sukses menambah berita warga",
                'alert-type' => "success"
            ]);
        }else{
            return redirect()->back()->with([
                'message' => "Gagal menambah berita warga",
                'alert-type' => "error"
            ]);
        }
    }

    public function home(){
        return view('layouts/app-home');
    }
}