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
    public function index(Request $request, KoorDesa $koordesa)
    {
        if ($koordesa->user_id !== auth()->id()) {
            abort(403);
        }
        $user = User::where('level', 'KOOR_TPS')->get();
        $tps = $koordesa->koortps()
            ->where('name', 'like', '%' . request('cari') . '%')
            ->withCount(['dpt', 'dptIsVoters' => function ($query) {
                $query->where('is_voters', true);
            }])
            ->paginate(15);

        return view('desa.tps.index', compact('tps', 'koordesa', 'user'));
    }

    public function store(Request $request, KoorDesa $koordesa)
    {

        $request->validate([
            'name' => 'required|unique:koor_tps,name,NULL,id,koor_desa_id,' . $koordesa->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'TPS sudah ada untuk Desa ini.',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorTps::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        KoorTps::create([
            "user_id" => $request->user,
            "koor_desa_id" => $koordesa->id,
            "total_dpt_by_tps" => $request->total_dpt_by_tps,
            'slug' => $slug,
            "name" => $request->name,
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.tps.index', [$koordesa]);
    }

    public function edit(KoorDesa $koordesa, KoorTps $koortps)
    {
        $users = User::where('level', 'KOOR_TPS')->get();
        return view('desa.tps.edit', compact('users', 'koordesa', 'koortps'));
    }

    public function update(Request $request, KoorDesa $koordesa, KoorTps $koortps)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);
        $count = 2;
        while (KoorTps::where('slug', $slug)->first()) {
            $slug = Str::slug($request->name) . '-' . $count;
            $count++;
        }

        $koortps->update([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => $slug,
            "total_dpt_by_tps" => $request->total_dpt_by_tps,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.desa.tps.index', [$koordesa]);
    }
}
