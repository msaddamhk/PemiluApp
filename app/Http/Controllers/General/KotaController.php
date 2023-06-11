<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Jobs\CreateKotaJob;
use App\Models\Dpt;
use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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

            $kota = KoorKota::where('name', 'like', '%' . (request('cari') ?? '') . '%')->paginate(15);
            $user = User::where('level', 'KOOR_KAB_KOTA')
                ->whereDoesntHave('koorKota')
                ->get();

            $api_kota = [];
            $isError = false;
            try {
                $url = "https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11";
                $data = json_decode(file_get_contents($url), true);
                $api_kota = $data['kota_kabupaten'];
            } catch (\Exception $e) {
                $isError = true;
            }

            return view('general.kota.index', compact('api_kota', 'kota', 'user', 'isError'));
        } else {
            abort(403);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:koor_kota,name',
            'user_id' => 'nullable',
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
        $users = User::where('level', 'KOOR_KAB_KOTA')
            ->whereDoesntHave('koorKota')
            ->get();
        return view('general.kota.edit', compact('koorkota', 'users'));
    }

    public function update(Request $request, KoorKota $koorkota)
    {

        $request->validate([
            'name' => 'required|unique:koor_kota,name,' . $koorkota->id . ',id',
            'user_id' => 'nullable',
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

        $input = [
            'name_otomatis' =>  $name,
        ];

        Validator::make($input, [
            'name_otomatis' => 'required|unique:koor_kota,name',
        ])->validate();

        $kota = KoorKota::create([
            "user_id" => $request->user,
            "name" => $name,
            'slug' => Str::slug($name),
            "created_by" => auth()->user()->id,
            "updated_by" => auth()->user()->id,
        ]);

        CreateKotaJob::dispatch($id, $kota->id, auth()->id());

        return redirect()->route('kota.index');
    }


    public function grafik(KoorKota $koorkota)
    {

        $kecamatans = KoorKecamatan::where('koor_kota_id', $koorkota->id)->get();
        $labels = [];
        $data = [];


        if ($kecamatans) {
            $koorDesas = KoorDesa::whereIn('koor_kecamatan_id', $kecamatans->pluck('id'))->pluck('id');

            $desaDptCounts = Dpt::whereIn('desa_id', $koorDesas)
                ->select('desa_id', DB::raw('count(*) as total_dpt'))
                ->groupBy('desa_id')
                ->orderBy('total_dpt', 'desc')
                ->get();


            foreach ($desaDptCounts as $desaDptCount) {
                $desa = KoorDesa::find($desaDptCount->desa_id);
                if ($desa) {
                    $labels[] = $desa->name;
                    $data[] = $desaDptCount->total_dpt;
                }
            }

            $top10Kecamatan = KoorKecamatan::where('koor_kota_id', $koorkota->id)
                ->withCount(['koorDesas as total_dpt' => function ($query) {
                    $query->join('dpt', 'koor_desa.id', '=', 'dpt.desa_id');
                }])
                ->orderBy('total_dpt', 'desc')
                ->pluck('total_dpt', 'name')
                ->toArray();

            $kecamatanLabels = array_keys($top10Kecamatan);
            $kecamatanData = array_values($top10Kecamatan);
        }

        return view('general.grafik.kota.index', compact('labels', 'data', 'kecamatanLabels', 'kecamatanData'));
    }

    public function delete(KoorKota $koorkota)
    {
        $koorkota->delete();
        return redirect()->route('kota.index');
    }
}
