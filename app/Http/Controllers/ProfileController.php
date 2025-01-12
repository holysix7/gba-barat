<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetListTrait;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    use GetListTrait;

    public function __construct()
    {

    }

    public function index(){
        $data = $this->getParams('profile');
        return view('profile.index', compact('data'));
    }

    public function detail(){
        $data = $this->getParams('profile-detail');
        return view('profile.index', compact('data'));
    }

    public function createFamily(Request $request){
        $family = new Family();
        $family->name = $request->name;
        $family->no_telp = $request->no_telp;
        $family->tgl_lahir = $request->tgl_lahir;
        $family->jenis_kelamin = $request->jenis_kelamin;
        $family->user_id = getUserLoginId();
        if($family->save()){
            return redirect()->back()->with([
                'message' => "Sukses menambah data keluarga!",
                'alert-type' => "success"
            ]);
        }else{
            return redirect()->back()->with([
                'message' => "Gagal menambah data keluarga!",
                'alert-type' => "error"
            ]);
        }
    }
}