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
        if (auth()->user()->is_active == "1") {
            switch (auth()->user()->level) {
                case 'GENERAL':
                    return redirect()->route('dashboard.general.index');
                case 'KOOR_KAB_KOTA':
                    return redirect()->route('dashboard.kota.index');
                case 'KOOR_KECAMATAN':
                    return redirect()->route('dashboard.kecamatan.index');
                case 'KOOR_DESA':
                    return redirect()->route('koor.desa.index');
                case 'KOOR_TPS':
                    return redirect()->route('koor.tps.index');
                default:
                    return redirect()->back()->with('error', 'Level user tidak valid.');
            }
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'Akun Anda tidak aktif.');
        }
    }

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
