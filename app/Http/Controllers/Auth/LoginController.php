<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use \Auth;
use \Hash;
use Illuminate\Http\Request;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use \Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash as FacadesHash;
use App\Models\SysUser as User;
use App\Models\SysRole as Role;
use App\Models\SysApplication as Application;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('layouts.app-login');
    }

    public function checking_login(Request $request){
        // $encrypter  = new Encrypter('YqqVhqTtTqSCv9aXWCCKT96xK4eet0yo', 'AES-256-CBC');
        $encrypter  = new Encrypter('yasOkRpyKE7qsBLsbp0Im7TbkKq1jpgs', 'AES-256-CBC');
        // $username   = "C328";
        // $password   = $encrypter->encrypt('bebas');
        $data       = [
            "userId"    => $request->username,
            "password"  => $encrypter->encrypt($request->password),
            "appId"     => 260
        ];
        $result = sendAPIUim($data);
        // Log::uim(["request" => $data]);
        // Log::uim(["response" => $result]);
		// dd($result);
        $conditions = $result->rc == '00' ? true : false;
		
        if($conditions){
            if($result->response){
                $response       = $result->response; 
                $role           = Role::where('id_fungsi', $response->idFungsi)->first();
                if($role){
                    $applications = Application::getAccessMenu($role->id, 1);
                    $applications = collect($applications)->sortBy('order')->toArray();
                    // dd($applications);
                    if($role->permissions){
                        $permissions = [];
                        foreach($role->permissions as $rPermission){
                            $row = [
                                'id'                => $rPermission->id,
                                'role_id'           => $rPermission->role_id,
                                'application_id'    => $rPermission->application_id,
                                'permission_id'     => $rPermission->permission_id,
                                'isactive'          => $rPermission->isactive,
                            ];
                            array_push($permissions, $row);
                        }
                    }
                    Session::put([
                        'status' => 200,
                        'description' => $response->nama .' berhasil login!',
                        'user' => $response,
                        'role' => $role,
                        'menus' => $applications,
                        'permissions' => $permissions
                    ]);
                    if($response->kodeCabang != '0'){
                        $route      = 'dashboard';
                        $message    = '<b>Selamat datang '. session('user')->nama .'</b>';
                    }else{
                        $route      = 'setting.rolemanagement';
                        if($role->id == 1){
                            $message    = 'System: '. $response->nama .' berhasil login!';
                        }else{
                            $message    = 'User Pusat: '. $response->nama .' berhasil login!';
                        }
                    }
                    $alert      = 'success';
                }else{
                    $route      = 'login';
                    $message    = 'Gagal login, User tersebut tidak memiliki role yang terdaftar!';
                    $alert      = 'danger';
                }
            }else{
                $route      = 'login';
                $message    = 'Gagal login, User tersebut tidak ditemukan!';
                $alert      = 'danger';
            }
        }else{
            $route      = 'login';
            $message    = $result->rc . ": " . $result->message;
            $alert      = 'danger';
        }
        return redirect()->route($route)->with([
            'message'       => $message,
            'alert-type'    => $alert
        ]);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/')->with([
            'message'       => 'Berhasil logout',
            'alert-type'    => 'success'
        ]);
    }

    private function encrypt_msg($username, $password, $appId){
        $cipher = 'AES-256-CBC';
        $key    = $this->config->application->uimKeyEncryptMessage;
        $iv     = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        $value  = \openssl_encrypt(serialize($password), $cipher, $key, 0, $iv);

        $mac = hash_hmac('sha256', base64_encode($iv).$value, $key);
        $json = json_encode(['iv' => base64_encode($iv), 'value' => $value, 'mac' => $mac]);

        $data = new \stdClass;
        $data->userId = $username;
        $data->password = base64_encode($json);
        $data->appId = $appId;

        return json_encode($data);
    }
}