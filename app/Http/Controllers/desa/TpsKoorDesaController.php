<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsKoorDesaController extends Controller
{
    public function index(Request $request, $slug_desa)
    {
        $user = User::where('level', 'KOOR_TPS')->get();
        $desa = KoorDesa::with([
            'tps' => function ($query) use ($request) {
                if ($request->has('cari')) {
                    $query->where('name', 'like', '%' . $request->query('cari') . '%');
                }
                $query->withCount('dpt');
                $query->withCount(['dptIsVoters' => function ($query) {
                    $query->where('is_voters', true);
                }]);
            }
        ])->where('slug', $slug_desa)->firstOrFail();

        return view('desa.tps.index', compact('desa', 'user'));
    }

    public function store(Request $request, $id_desa)
    {
        $desa = KoorDesa::findOrFail($id_desa);
        $request->validate([
            'name' => 'required|unique:koor_tps,name,NULL,id,koor_desa_id,' . $id_desa,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'TPS sudah ada untuk Desa ini.',
        ]);

        KoorTps::create([
            "user_id" => $request->user,
            "koor_desa_id" => $id_desa,
            'slug' => Str::slug($request->name),
            "name" => $request->name,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.tps.index', [
            'slug_desa' => $desa->slug
        ]);
    }
}
