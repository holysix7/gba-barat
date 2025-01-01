<?php

namespace App\Http\Controllers;

use App\Http\Traits\GetListTrait;
use App\Models\User;
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
}