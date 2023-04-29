<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function authenticated()
    {
        $userLevel = auth()->user()->level;
        switch ($userLevel) {
            case 'GENERAL':
                return redirect()->route('dashboard.index');
            case 'KOOR_KAB_KOTA':
                return redirect()->route('home');
            case 'KOOR_KECAMATAN':
                return redirect()->route('/home2');
            case 'KOOR_DESA':
                return redirect()->route('/home3');
            case 'KOOR_TPS':
                return redirect()->route('/home4');
        }
    }

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
