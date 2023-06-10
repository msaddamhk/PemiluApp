<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsKoorKecamatanController extends Controller
{
    public function index(Request $request, KoorKecamatan $koorkecamatan, KoorDesa $koordesa)
    {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }
        $tps = $koordesa->koortps()
            ->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpt', 'dptIsVoters' => function ($query) {
                $query->where('is_voters', true);
            }])
            ->paginate(15);

        return view('kecamatan.tps.index', compact('tps', 'koorkecamatan', 'koordesa'));
    }
}
