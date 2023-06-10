<?php

namespace App\Http\Controllers\kota;

use App\Http\Controllers\Controller;
use App\Models\KoorKecamatan;
use App\Models\KoorKota;

class DashboardKotaController extends Controller
{
    public function index()
    {
        $getIdUser = Auth()->user()->id;

        $koorKecamatan = new KoorKecamatan();
        $kecamatanCount = $koorKecamatan->getCountKecamatanForGeneral();

        $koorKota = new KoorKota();
        $getCountKecamatanForKota = $koorKota->getCountKecamatanForKota($getIdUser);
        $getCountDesaForKota = $koorKota->getCountDesaForKota($getIdUser);
        $getVotersForKota = $koorKota->getTotalVoterKota($getIdUser);
        $getDataDiagramForKota = $koorKota->getdataDiagramForKota($getIdUser);
        $getDataTableForKota = $koorKota->getDataTableForKota($getIdUser);

        // dd($getDataTableForKota);

        return view('kota.dashboard.index', compact(['getCountKecamatanForKota', 'getCountDesaForKota', 'getVotersForKota', 'getDataDiagramForKota']));
    }
}
