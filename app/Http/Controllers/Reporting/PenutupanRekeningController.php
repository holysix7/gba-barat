<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenutupanRekeningController extends Controller
{
    public function index(){
        return view('reporting.penutupan-rekening.index');
    }
}
