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
                    if (auth()->user()->KoorKota) {
                        return redirect()->route('dashboard.kota.index');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', 'Anda Tidak Memiliki Data');
                    }
                case 'KOOR_KECAMATAN':
                    if (auth()->user()->KoorKecamatan) {
                        return redirect()->route('dashboard.kecamatan.index');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', 'Anda Tidak Memiliki Data');
                    }
                case 'KOOR_DESA':
                    if (auth()->user()->KoorDesa) {
                        return redirect()->route('koor.desa.index');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', 'Anda Tidak Memiliki Data');
                    }
                case 'KOOR_TPS':
                    if (auth()->user()->tps) {
                        return redirect()->route('koor.tps.index');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', 'Anda Tidak Memiliki Data');
                    }
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
