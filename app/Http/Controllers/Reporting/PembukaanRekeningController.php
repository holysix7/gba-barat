<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembukaanRekeningController extends Controller
{
    public function index(){
        return view('reporting.pembukaan-rekening.index');
    }
}
