<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Http\Request;

class KoorKecamatanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $kecamatan = KoorKecamatan::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('kecamatan.index', compact('kecamatan'));
    }
}
