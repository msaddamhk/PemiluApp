<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class TpsKoorTpsController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $tps = KoorTps::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('tps.tps.index', compact('tps'));
    }
}
