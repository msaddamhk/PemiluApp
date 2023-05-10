<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class KotaController extends Controller
{
    public function index()
    {
        if (auth()->user()->level == 'KOOR_KAB_KOTA') {
            $kota = KoorKota::where('user_id', auth()->user()->id)
                ->where('name', 'like', '%' . (request('cari') ?? '') . '%')
                ->get();

            return view('general.kota.index', compact('kota'));
        } elseif (request()->user()->can('isGeneral')) {

            $url = "https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11";
            $data = json_decode(file_get_contents($url), true);
            $api_kota = $data['kota_kabupaten'];

            $kota = KoorKota::where('name', 'like', '%' . (request('cari') ?? '') . '%')->get();

            $user = User::where('level', 'KOOR_KAB_KOTA')->get();

            return view('general.kota.index', compact('api_kota', 'kota', 'user'));
        } else {

            abort(403);
        }
    }

    public function create()
    {
        return view('general.kota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user' => 'required',
        ]);

        KoorKota::create([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('kota.index');
    }

    public function edit(KoorKota $koorkota)
    {
        $users = User::where('level', 'KOOR_KAB_KOTA')->get();
        return view('general.kota.edit', compact('koorkota', 'users'));
    }

    public function update(Request $request, KoorKota $koorkota)
    {

        $request->validate([
            'name' => 'required',
            'user' => 'required',
        ]);

        $koorkota->update([
            "user_id" => $request->user,
            "name" => $request->name,
            'slug' => Str::slug($request->name),
            "updated_by" => auth()->user()->id,
        ]);

        return redirect()->route('kota.index');
    }


    public function store_kota(Request $request)
    {
        $value = $request->input('api_kota');
        list($id, $name) = explode(',', $value);

        $kota = KoorKota::create([
            "user_id" => $request->user,
            "name" => $name,
            'slug' => Str::slug($name),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        $url_kecamatan = "https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=" . $id;
        $data_kecamatan = json_decode(file_get_contents($url_kecamatan), true);
        $data_kecamatan = $data_kecamatan['kecamatan'];


        foreach ($data_kecamatan as $kecamatan) {
            $slug = Str::slug($kecamatan['nama']);
            $count = 2;
            while (KoorKecamatan::where('slug', $slug)->first()) {
                $slug = Str::slug($kecamatan['nama']) . '-' . $count;
                $count++;
            }

            $kecamatanModel = KoorKecamatan::create([
                'name' => $kecamatan['nama'],
                'koor_kota_id' => $kota->id,
                'slug' => $slug,
                "created_by" => auth()->user()->id,
                "updated_by" => auth()->user()->id,
            ]);

            $url_desa = "https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=" . $kecamatan['id'];
            $data_desa = json_decode(file_get_contents($url_desa), true);

            foreach ($data_desa['kelurahan'] as $desa) {
                $slug_desa = Str::slug($desa['nama']);
                $count = 2;
                while (KoorDesa::where('slug', $slug_desa)->first()) {
                    $slug_desa = Str::slug($desa['nama']) . '-' . $count;
                    $count++;
                }
                KoorDesa::create([
                    'koor_kecamatan_id' => $kecamatanModel->id,
                    'name' => $desa['nama'],
                    'slug' => $slug_desa,
                    "created_by" => auth()->user()->id,
                    "updated_by" => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('kota.index');
    }
}
