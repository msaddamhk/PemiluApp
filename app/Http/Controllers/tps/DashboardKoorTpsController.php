<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKoorTpsController extends Controller
{
    public function index()
    {
        return view('tps.dashboard.index');
    }
}
