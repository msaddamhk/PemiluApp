<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use Illuminate\Http\Request;

class DptKoorKecamatanController extends Controller
{
    public function index(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }
        $dpt = $koordesa->dpts()->where('name', 'like', '%' . request('cari') . '%')
            ->paginate(15);
        return view('kecamatan.dpt.index', compact('dpt', 'koorkecamatan', 'koordesa'));
    }
}
