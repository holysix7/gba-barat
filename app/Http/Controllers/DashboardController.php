<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetListTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use GetListTrait;
    
    public function index(){
        $data = $this->getParams('timeline');
        return view('timeline.index', compact('data'));
    }    
}