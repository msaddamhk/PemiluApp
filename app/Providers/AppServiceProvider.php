<?php

namespace App\Providers;

use App\Models\KoorKecamatan;
use App\Models\KoorKota;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();

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
