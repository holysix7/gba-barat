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
        $info_warga = InfoWarga::ajax($request);
        $counted    = data_get($info_warga, 'counted', 0);
        $start      = intval($request->start);
        $limit      = 20;
        $prev       = max($start - $limit, 0);
        $next       = ($start + $limit < $counted) ? $start + $limit : $start;
        $has_more   = ($start + $limit) < $counted;
        $response   = [
            'start' => $start,
            'prev'  => $prev,
            'next'  => $next,
            'counted' => $counted,
            'hasMore' => $has_more,
            'data'  => data_get($info_warga, 'data', [])
        ];
        return response()->json($response);
    }

    public function home(){
        return view('layouts/app-home');
    }
}