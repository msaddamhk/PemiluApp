<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorTps;
use Illuminate\Http\Request;

class DptTpsKoorKecamatanController extends Controller
{

    public function index(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa, KoorTps $koortps)
    {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }
        $dpt = $koortps->dpt()->where('name', 'like', '%' . request('cari') . '%')
            ->paginate(15);
        return view('kecamatan.tps.dpt', compact('dpt', 'koorkecamatan', 'koordesa', 'koortps'));
    }
}
