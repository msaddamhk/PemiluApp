<?php

namespace App\Http\Controllers\tps;

use App\Http\Controllers\Controller;
use App\Models\KoorTps;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsKoorTpsController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->input('cari');
        $tps = KoorTps::where('user_id', auth()->user()->id)
            ->where('name', 'like', '%' . $cari . '%')
            ->get();
        return view('tps.tps.index', compact('tps'));
    }
    public function edit(KoorTps $koortps)
    {
        $users = User::where('level', 'KOOR_TPS')->get();
        return view('tps.tps.edit', compact('users', 'koortps'));
    }

    public function update(Request $request, KoorTps $koortps)
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
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('koor.tps.index');
    }
}
