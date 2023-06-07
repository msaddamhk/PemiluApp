<?php

namespace App\Http\Controllers\kota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKotaController extends Controller
{
    public function index()
    {
        return view('kota.dashboard.index');
    }
}
