<?php

namespace App\Http\Controllers\Reporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarPremiController extends Controller
{
    public function index(){
        return view('reporting.daftar-premi.index');
    }
}
