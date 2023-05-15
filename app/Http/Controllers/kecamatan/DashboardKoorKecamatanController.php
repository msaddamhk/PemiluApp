<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKoorKecamatanController extends Controller
{
    public function index()
    {
        return view('kecamatan.dashboard.index');
    }
}
