<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorTps;
use App\Models\QuickCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class KoorKecamatanQuickCountController extends Controller
{
    public function index(
        Request $request,
        KoorKecamatan $koorkecamatan,
        KoorDesa $koordesa,
        KoorTps $koortps
    ) {
        if ($koorkecamatan->user_id !== auth()->id()) {
            abort(403);
        }

        $quick_count = $koortps->quickCount()->where('number_of_votes', 'like', '%' . request('cari') . '%')
            ->get();

        return view(
            'kecamatan.quickcount.index',
            compact('quick_count', 'koorkecamatan', 'koordesa', 'koortps')
        );
    }
}
