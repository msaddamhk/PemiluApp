<?php

namespace App\Providers;

use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::define('hasAccessToKota', function ($user, $kotaSlug) {
        //     $kota = KoorKota::where('user_id', $user->id)->where('slug', $kotaSlug)->first();
        //     return !is_null($kota);
        // });

        // Gate::define('hasAccessToKecamatan', function ($user, $kecamatanSlug) {
        //     $kecamatan = KoorKecamatan::where('user_id', $user->id)->where('slug', $kecamatanSlug)->first();
        //     return !is_null($kecamatan);
        // });


        // Gate::define('hasAccessToKecamatan', function ($user, $kecamatanSlug) {
        //     return $user->koorKecamatans()->where('slug', $kecamatanSlug)->exists();
        // });

        // Gate::define('hasAccessToKecamatan', function ($user) {
        //     $kecamatan = KoorKecamatan::where('user_id', $user->id)->first();
        //     return !is_null($kecamatan);
        // });


        Gate::define('isGeneral', function ($user) {
            return $user->level == 'GENERAL';
        });

        Gate::define('isKoorKota', function ($user) {
            return $user->level == 'KOOR_KAB_KOTA';
        });

        Gate::define('isKoorKecamatan', function ($user) {
            return $user->level == 'KOOR_KECAMATAN';
        });

        Gate::define('isKoorDesa', function ($user) {
            return $user->level == 'KOOR_DESA';
        });

        Gate::define('isKoorTps', function ($user) {
            return $user->level == 'KOOR_TPS';
        });
    }
}
