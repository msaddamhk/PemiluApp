<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index(Request $request, $slug_kota)
    {
        $user = User::where('level', 'KOOR_KECAMATAN')->get();
        $kota = KoorKota::with(['KoorKecamatan' => function ($query) use ($request) {
            if ($request->has('cari')) {
                $query->where('name', 'like', '%' . $request->query('cari') . '%');
            }
        }])
            ->where('slug', $slug_kota)
            ->firstOrFail();
        return view('general.kecamatan.index', compact('kota',  'user'));
    }

    public function create_kecamatan($slug_kota)
    {
        $kota = KoorKota::where('slug', $slug_kota)->first();
        return view('general.kecamatan.create_kecamatan', compact('kota'));
    }

    public function store_kecamatan(Request $request, $id_kota)
    {
        $request->validate([
            'name' => 'required|unique:koor_kecamatan,name,NULL,id,koor_kota_id,' . $id_kota,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Kecamatan sudah ada untuk kota ini.',
        ]);

        KoorKecamatan::create([
            "user_id" => $request->user,
            "koor_kota_id" => $id_kota,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => 1,
            "updated_by" => 1,
        ]);

        $slug_kota = KoorKota::findOrFail($id_kota)->slug;
        return redirect()->route('kecamatan.index', ['slug_kota' => $slug_kota]);
    }
}