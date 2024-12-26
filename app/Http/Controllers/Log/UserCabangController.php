<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserCabangController extends Controller
{
    public function index(){
        return view('log.user-cabang.index');
    }
}
