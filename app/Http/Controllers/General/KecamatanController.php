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
    public function index(Request $request, KoorKota $koorkota)
    {
        $user = User::where('level', 'KOOR_KECAMATAN')->get();
        $kecamatan = $koorkota->KoorKecamatans()->where('name', 'like', '%' . request('cari') . '%')->get();
        return view('general.kecamatan.index', compact('koorkota', 'kecamatan',  'user'));
    }

    public function create_kecamatan($slug_kota)
    {
        $kota = KoorKota::where('slug', $slug_kota)->first();
        return view('general.kecamatan.create_kecamatan', compact('kota'));
    }

    public function store_kecamatan(Request $request, KoorKota $koorkota)
    {

        $request->validate([
            'name' => 'required|unique:koor_kecamatan,name,NULL,id,koor_kota_id,' . $koorkota->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Kecamatan sudah ada untuk kota ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKecamatan::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }


        KoorKecamatan::create([
            "user_id" => $request->user,
            "koor_kota_id" => $koorkota->id,
            "name" => $request->name,
            'slug' => $slug,
            "created_by" => 1,
            "updated_by" => 1,
        ]);


        return redirect()->route('kecamatan.index', $koorkota);
    }

    public function edit(KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $users = User::where('level', 'KOOR_KECAMATAN')->get();
        return view('general.kecamatan.edit', compact('koorkecamatan', 'users', 'koorkota'));
    }

    public function update(Request $request, KoorKota $koorkota, KoorKecamatan $koorkecamatan)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorKecamatan::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koorkecamatan->update([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('kecamatan.index', $koorkota);
    }
}
