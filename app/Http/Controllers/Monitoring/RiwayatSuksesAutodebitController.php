<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatSuksesAutodebitController extends Controller
{
    public function index(){
        return view('monitoring.riwayatsukses.index');
    }
}
