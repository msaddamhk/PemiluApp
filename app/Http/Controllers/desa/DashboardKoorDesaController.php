<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKoorDesaController extends Controller
{
    public function index()
    {
        return view('desa.dashboard.index');
    }
}
