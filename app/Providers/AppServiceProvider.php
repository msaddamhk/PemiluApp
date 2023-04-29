<?php

namespace App\Providers;

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

        Gate::define('isKoorKota', function ($user) {
            return $user->level == 'KOOR_TPS';
        });
    }
}
