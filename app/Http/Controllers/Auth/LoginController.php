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
                return redirect()->route('kota.index');
            case 'KOOR_KECAMATAN':
                return redirect()->route('koor.kecamatan.index');
            case 'KOOR_DESA':
                return redirect()->route('koor.desa.index');
            case 'KOOR_TPS':
                return redirect()->route('koor.tps.index');
        }
    }

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
