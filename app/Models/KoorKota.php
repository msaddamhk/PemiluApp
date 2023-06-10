<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KoorKota extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'koor_kota';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function koorKecamatans()
    {
        return $this->hasMany(KoorKecamatan::class);
    }

    public function jumlahKecamatan()
    {
        return $this->koorKecamatans()->count();
    }

    public function getCountKotaForGeneral()
    {
        return $this->count();
    }

    public function getdataDiagram()
    {
        $dataDiagram = [];

        foreach ($this->get() as $koorKotaModel) {
            $kotaId = $koorKotaModel->id;
            $dptCount = (new Dpt())->whereHas('koorDesa.kecamatan.kota', function ($query) use ($kotaId) {
                $query->where('id', $kotaId);
            })->count();

            $dataDiagram[] = [
                'name' => $koorKotaModel->name,
                'count' => $dptCount,
            ];
        }

        return $dataDiagram;
    }

    public function getCountKecamatanForKota($id)
    {
        $findKota = $this->where('user_id', $id)->first();
        return $findKota->koorKecamatans()->count();
    }

    public function getCountDesaForKota($id)
    {
        $findKota = $this->where('user_id', $id)->first();
        $countAllDesa = 0;
        foreach ($findKota->koorKecamatans()->get() as $kecamatan) {
            $countAllDesa += $kecamatan->koorDesas()->count();
        }
        return $countAllDesa;
    }

    public function getTotalVoterKota($id)
    {
        $numVoters = $this->join('koor_kecamatan', 'koor_kota.id', '=', 'koor_kecamatan.koor_kota_id')
            ->join('koor_desa', 'koor_kecamatan.id', '=', 'koor_desa.koor_kecamatan_id')
            ->join('dpt', 'koor_desa.id', '=', 'dpt.desa_id')
            ->where('koor_kota.user_id', $id)
            ->count();

        return $numVoters;
    }

    public function getdataDiagramForKota($id)
    {
        $findKota = $this->where('user_id', $id)->first();
        $dataDiagram = [];

        foreach ($findKota->koorKecamatans as $kecamatan) {
            $jumlahPemilihPerkecamatan = $kecamatan->koorDesas->flatMap(function ($desa) {
                return $desa->dpts;
            })->count();

            if ($jumlahPemilihPerkecamatan > 0) {
                $dataDiagram[] = [
                    'name' => $kecamatan->name,
                    'jumlahMemilihPerkecamatan' => $jumlahPemilihPerkecamatan
                ];
            }
        }

        return $dataDiagram;
    }

    public function getDataTableForKota($id)
    {
        $findKota = $this->where('user_id', $id)->first();
        $dataTable = [];

        foreach ($findKota->koorKecamatans as $kecamatan) {
            $jumlahDptPerkecamatan = $kecamatan->koorDesas->sum(function ($desa) {
                return $desa->total_dpt ?? 0;
            });

            $jumlahPemilihPerkecamatan = $kecamatan->koorDesas->flatMap(function ($desa) {
                return $desa->dpts;
            })->count();

            $dataPersen = ($jumlahPemilihPerkecamatan > 0 ) ? number_format(($jumlahDptPerkecamatan / $jumlahPemilihPerkecamatan) * 100, 2) : 0 ;

            if ($jumlahPemilihPerkecamatan > 0) {
                $dataTable[] = [
                    'name' => $kecamatan->name,
                    'slugKota' => $findKota->slug,
                    'slugKecamatan' => $kecamatan->slug,
                    'jumlahDptPerkecamatan' => $jumlahDptPerkecamatan,
                    'jumlahMemilih' => $jumlahPemilihPerkecamatan,
                    'dataPersen' => $dataPersen
                ];
            }
        }

        return $dataTable;
    }
}
