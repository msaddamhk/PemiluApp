<?php

namespace App\Http\Controllers\desa;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KoorDesaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $desa = KoorDesa::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('desa.desa.index', compact('desa'));
    }

    public function edit(KoorDesa $koordesa)
    {
        $users = User::where('level', 'KOOR_DESA')->get();
        return view('desa.desa.edit', compact('users', 'koordesa'));
    }

    public function update(Request $request, KoorDesa $koordesa)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorDesa::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koordesa->update([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => $slug,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.index');
    }
}
