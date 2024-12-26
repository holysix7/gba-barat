<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelsAppUser as User;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('layouts.app-home');
    }

    public function register(){
        return view('layouts.app-register');
    }

    public function register2(){
        return view('layouts.app-register2');
    }

    public function forget_password(){
        return view('layouts.app-forget-pwd');
    }

    public function checking_lupa(Request $request){
        $request->validate([
            'email'     => 'required',
            'captcha'   => 'required|captcha',
        ]);
        $route  = 'gagal';
        $user   = User::where('email', $request->email)->first();
        if ($user) {
            $content['email'] = [
                "TEMPLATE_KEY"  => "JMET007",
                "DESTNUM"       => $user->email,
                "EMAIL"         => $user->email,
                "USER"          => $user->name,
                "LINK"          => "<a href='". url('/') . "/change-password/". Crypt::encrypt($user->user_id) ."'>Silahkan Klik Disini!</a>"
            ];
            $res = sendEmail($content);
            // echo json_encode($res); die;
            if($res){
                $message    = 'Berhasil, mohon check email anda!';
                $alert      = 'success';
                $route      = 'berhasil';
            }else{
                $message    = 'Gagal mengirim email untuk melakukan reset password!';
                $alert      = 'success';
            }
        }else{
            $message    = "Maaf user dengan email: $request->email tidak ditemukan.";
            $alert      = 'warning';
        }
        $notification = [
            'message'       => $message,
            'alert-type'    => $alert
        ];
        if($route == 'berhasil'){
            return redirect()->route($route)->with($notification);
        }else{
            return back()->with($notification);
        }
    }

    public function after_forget(){
        return view('layouts.app-after-forget');
    }
}
