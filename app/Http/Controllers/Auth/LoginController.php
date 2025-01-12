<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Auth;
use App\Models\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('layouts.app-login');
    }

    public function checking_login(Request $request){
        $auth = Auth::where('username', $request->username)->first();
        
        if(!$auth){
            return redirect()->route('login')->with([
                'message' => 'Gagal login, User tersebut tidak terdaftar!',
                'alert-type' => 'danger'
            ]);
        }
        $user   = $auth->user;
        $role   = $user->role;
        $pwd    = $request->password;

        if(!Hash::check($pwd, $auth->password)){
            return redirect()->route('login')->with([
                'message' => 'Gagal login, Password tidak sesuai!',
                'alert-type' => 'danger'
            ]);
        }

        Session::put([
            'status' => 200,
            'description' => $user->nama .' berhasil login!',
            'user' => $user,
            'role' => $role,
        ]);

        return redirect()->route('timeline')->with([
            'message'       => '<b>Selamat datang '. session('user')->nama .'</b>',
            'alert-type'    => 'success'
        ]);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/')->with([
            'message'       => 'Berhasil logout',
            'alert-type'    => 'success'
        ]);
    }
}