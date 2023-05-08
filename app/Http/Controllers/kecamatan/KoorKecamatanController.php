<?php

namespace App\Http\Controllers\kecamatan;

use App\Http\Controllers\Controller;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Support\Str;

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

    public function edit(KoorKecamatan $koorkecamatan)
    {
        $users = User::where('level', 'KOOR_KECAMATAN')->get();
        return view('kecamatan.edit', compact('koorkecamatan', 'users'));
    }

    public function update(Request $request, KoorKecamatan $koorkecamatan)
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

        return redirect()->route('koor.kecamatan.index');
    }
}
