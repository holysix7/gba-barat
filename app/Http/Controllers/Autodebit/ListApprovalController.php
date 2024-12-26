<?php

namespace App\Http\Controllers\Autodebit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListApprovalController extends Controller
{
    public function index(){
        return view('autodebit.list-approval.index');
    }
}
