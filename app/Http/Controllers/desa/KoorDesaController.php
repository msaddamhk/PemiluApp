<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use Illuminate\Http\Request;

class KoorDesaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $desa = KoorDesa::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('desa.desa.index', compact('desa'));
    }
}
