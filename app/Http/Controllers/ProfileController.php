<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index(){
        $session_user = Session::Get('user');
        $user = User::where('id', $session_user->id)
        ->with(['auth.role', 'address'])
        ->first();

        return view('profile', compact('user'));
    }

    public function detail(){
        $session_user = Session::Get('user');
        $user = User::where('id', $session_user->id)
        ->with(['auth.role', 'address', 'families' => function ($query) {
            $query->orderBy('tgl_lahir', 'asc');
        },])
        ->first();
        $data = [
            [
                'name' => $user->name,
                'no_telp' => $user->no_telp,
                'tgl_lahir' => $user->tgl_lahir,
                'jenis_kelamin' => $user->jenis_kelamin,
            ]
        ];
        foreach($user->families as $family){
            $row = [
                'name' => $family->name,
                'no_telp' => $family->no_telp,
                'tgl_lahir' => $family->tgl_lahir,
                'jenis_kelamin' => $family->jenis_kelamin,
            ];
            array_push($data, $row);
        }
        // dd($data);
        return view('profile', compact('data'));
    }
}