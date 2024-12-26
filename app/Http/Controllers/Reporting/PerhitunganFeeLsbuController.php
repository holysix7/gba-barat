<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerhitunganFeeLsbuController extends Controller
{
    public function index(){
        return view('reporting.perhitungan-fee-lsbu.index');
    }
}
