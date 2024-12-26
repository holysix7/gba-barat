<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DataWargaController extends Controller
{
    public function index(){
        $prefix = request()->segment(1);
        switch ($prefix) {
            case 'rt01':
                # code...
                break;
            case 'rt02':
                # code...
                break;
            case 'rt03':
                # code...
                break;
            case 'rt04':
                # code...
                break;
            case 'rt05':
                $data = User::getWargaByRt('05');
                break;
            case 'rt06':
                # code...
                break;
            
            default:
                return redirect()->back();
                break;
        }

        return view('data-warga', compact('data'));
    }
}