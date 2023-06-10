<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KoorKecamatanDesaQuickCountControler extends Controller
{
    public function index(
        Request $request,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
    ) {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }

        $quick_count = $koordesa->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'kecamatan.desa_quickcount.index',
            compact('quick_count', 'koorkecamatan', 'koordesa')
        );
    }
}
