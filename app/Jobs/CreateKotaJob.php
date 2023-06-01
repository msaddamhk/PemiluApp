<?php

namespace App\Jobs;

use App\Models\KoorDesa;
use App\Models\KoorKecamatan;
use Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;


class CreateKotaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    private $kotaId;
    private $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($id, $kotaId, $userId)
    {
        $this->id = $id;
        $this->kotaId = $kotaId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $url_kecamatan = "https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=" . $this->id;
            $data_kecamatan = json_decode(file_get_contents($url_kecamatan), true);
            $data_kecamatan = $data_kecamatan['kecamatan'];

            foreach ($data_kecamatan ?? [] as $kecamatan) {
                $slug = Str::slug($kecamatan['nama']);
                $count = 2;
                while (KoorKecamatan::where('slug', $slug)->first()) {
                    $slug = Str::slug($kecamatan['nama']) . '-' . $count;
                    $count++;
                }

                $kecamatanModel = KoorKecamatan::create([
                    'name' => $kecamatan['nama'],
                    'koor_kota_id' => $this->kotaId,
                    'slug' => $slug,
                    "created_by" => $this->userId,
                    "updated_by" => $this->userId,
                ]);

                $url_desa = "https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=" . $kecamatan['id'];
                $data_desa = json_decode(file_get_contents($url_desa), true);

                foreach ($data_desa['kelurahan'] ?? [] as $desa) {
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
                        "created_by" => $this->userId,
                        "updated_by" => $this->userId,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            throw new Error("no internet connection");
        }
    }
}
