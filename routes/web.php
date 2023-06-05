<?php

use App\Http\Controllers\desa\DashboardKoorDesaController;
use App\Http\Controllers\desa\DptKoorDesaController;
use App\Http\Controllers\desa\DptTpsKoorDesaController;
use App\Http\Controllers\desa\KoorDesaController as DesaKoorDesaController;
use App\Http\Controllers\desa\KoorDesaDesaQuickCountControler;
use App\Http\Controllers\desa\KoorDesaQuickCountController;
use App\Http\Controllers\desa\TpsKoorDesaController;
use App\Http\Controllers\General\DashboardGeneralController;
use App\Http\Controllers\General\DesaController;
use App\Http\Controllers\general\DesaQuickCountControler;
use App\Http\Controllers\General\DptController;
use App\Http\Controllers\General\DptTpsController;
use App\Http\Controllers\General\KecamatanController;
use App\Http\Controllers\General\TpsController;
use App\Http\Controllers\General\KotaController;
use App\Http\Controllers\General\QuickCountController;
use App\Http\Controllers\kecamatan\DashboardKoorKecamatanController;
use App\Http\Controllers\kecamatan\DptKoorKecamatanController;
use App\Http\Controllers\kecamatan\DptTpsKoorKecamatanController;
use App\Http\Controllers\kecamatan\KoorDesaController;
use App\Http\Controllers\kecamatan\KoorKecamatanController;
use App\Http\Controllers\kecamatan\KoorKecamatanDesaQuickCountControler;
use App\Http\Controllers\kecamatan\KoorKecamatanQuickCountController;
use App\Http\Controllers\kecamatan\TpsKoorKecamatanController;
use App\Http\Controllers\tps\DashboardKoorTpsController;
use App\Http\Controllers\tps\DptTpsKoorTpsController;
use App\Http\Controllers\tps\KoorTpsQuickCountController;
use App\Http\Controllers\tps\TpsKoorTpsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware('auth')->group(function () {

    Route::resource('data-admin', \App\Http\Controllers\UserController::class)->names('users')->parameter('data-admin', 'user');

    Route::get('/', [DashboardGeneralController::class, 'index'])->name('dashboard.general.index');

    Route::get('/kabkota', [KotaController::class, 'index'])->name('kota.index');

    Route::post('/kabkota/store', [KotaController::class, 'store'])->name('kota.store');

    Route::get('/kabkota/{koorkota:slug}/edit', [KotaController::class, 'edit'])->name('kota.edit');

    Route::delete('/kabkota/{koorkota:slug}/delete', [KotaController::class, 'delete'])->name('kota.delete');

    Route::get('/kabkota/{koorkota:slug}/grafik', [KotaController::class, 'grafik'])->name('grafik.kota.index');

    Route::post('/kabkota/{koorkota:slug}/edit/update', [KotaController::class, 'update'])->name('kota.update');

    Route::post('/kabkota/store_otomatis', [KotaController::class, 'store_kota'])->name('kota.store.otomatis');

    Route::get('/kabkota/{koorkota:slug}/kecamatan', [KecamatanController::class, 'index'])
        ->name('kecamatan.index');

    Route::post('/kecamatan/store/{koorkota}', [KecamatanController::class, 'store_kecamatan'])
        ->name('kecamatan.store');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/edit',
        [KecamatanController::class, 'edit']
    )->name('kecamatan.edit');

    Route::delete(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/delete',
        [KecamatanController::class, 'delete']
    )->name('kecamatan.delete');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/grafik',
        [KecamatanController::class, 'grafik']
    )->name('grafik.kecamatan.index');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/edit/update',
        [KecamatanController::class, 'update']
    )->name('kecamatan.update');


    Route::get('/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa', [DesaController::class, 'index'])
        ->name('desa.index');

    Route::post('/{koorkota}/{koorkecamatan}/desa/store', [DesaController::class, 'store'])
        ->name('desa.store');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/edit',
        [DesaController::class, 'edit']
    )->name('desa.edit');

    Route::delete(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/delete',
        [DesaController::class, 'delete']
    )->name('desa.delete');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/grafik',
        [DesaController::class, 'grafik']
    )->name('grafik.desa.index');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/edit/update',
        [DesaController::class, 'update']
    )->name('desa.update');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt',
        [DptController::class, 'index']
    )
        ->name('dpt.index');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/tambah',
        [DptController::class, 'create']
    )
        ->name('dpt.create');

    Route::post('/{koorkota}/{koorkecamatan}/{koordesa}/dpt/store', [DptController::class, 'store'])
        ->name('dpt.store');


    Route::post('/{koorkota}/{koorkecamatan}/{koordesa}/dpt/import', [DptController::class, 'import'])
        ->name('dpt.import');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/{dpt}/edit',
        [DptController::class, 'edit']
    )->name('dpt.edit');

    Route::delete(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/{dpt}/delete',
        [DptController::class, 'delete']
    )->name('dpt.delete');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa}/dpt/{dpt}/update',
        [DptController::class, 'update']
    )
        ->name('dpt.update');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps',
        [TpsController::class, 'index']
    )
        ->name('tps.index');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/store',
        [TpsController::class, 'store']
    )->name('tps.store');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/edit',
        [TpsController::class, 'edit']
    )->name('tps.edit');

    Route::delete(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/delete',
        [TpsController::class, 'delete']
    )->name('tps.delete');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/edit/update',
        [TpsController::class, 'update']
    )->name('tps.update');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}',
        [DptTpsController::class, 'index']
    )
        ->name('tps.dpt.index');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/tambah',
        [DptTpsController::class, 'create']
    )
        ->name('tps.dpt.create');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/store',
        [DptTpsController::class, 'store']
    )
        ->name('tps.dpt.store');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/edit',
        [DptTpsController::class, 'edit']
    )->name('tps.dpt.edit');

    Route::delete(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/delete',
        [DptTpsController::class, 'delete']
    )->name('tps.dpt.delete');


    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/{dpt}/update',
        [DptTpsController::class, 'update']
    )
        ->name('tps.dpt.update');


    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/{dpt}/update_voters',
        [DptTpsController::class, 'update_voters']
    )
        ->name('tps.dpt.update_voters');



    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count',
        [DesaQuickCountControler::class, 'index']
    )
        ->name('desa.quick_count.index');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/tambah',
        [DesaQuickCountControler::class, 'create']
    )
        ->name('desa.quick_count.create');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/tambah',
        [DesaQuickCountControler::class, 'store']
    )
        ->name('desa.quick_count.store');


    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/{quickcount}/edit',
        [DesaQuickCountControler::class, 'edit']
    )
        ->name('desa.quick_count.edit');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/{quickcount}/store',
        [DesaQuickCountControler::class, 'update']
    )
        ->name('desa.quick_count.update');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count',
        [QuickCountController::class, 'index']
    )
        ->name('quick_count.index');

    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah',
        [QuickCountController::class, 'create']
    )
        ->name('quick_count.create');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah',
        [QuickCountController::class, 'store']
    )
        ->name('quick_count.store');


    Route::get(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/edit',
        [QuickCountController::class, 'edit']
    )
        ->name('quick_count.edit');

    Route::post(
        '/kabkota/{koorkota:slug}/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/store',
        [QuickCountController::class, 'update']
    )
        ->name('quick_count.update');


    // koor kecamatan

    Route::prefix('/koor')->group(function () {

        Route::middleware('can:isKoorKecamatan')->group(function () {

            Route::get('/dashboard-kecamatan', [DashboardKoorKecamatanController::class, 'index'])->name('dashboard.kecamatan.index');

            Route::get('/kecamatan', [KoorKecamatanController::class, 'index'])
                ->name('koor.kecamatan.index');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/edit',
                [KoorKecamatanController::class, 'edit']
            )->name('koor.kecamatan.edit');

            Route::get('/kecamatan/{koorkecamatan:slug}/grafik', [KoorKecamatanController::class, 'grafik'])->name('grafik.koorkecamatan.index');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/edit/update',
                [KoorKecamatanController::class, 'update']
            )->name('koor.kecamatan.update');

            Route::get('/kecamatan/{koorkecamatan:slug}/desa', [KoorDesaController::class, 'index'])
                ->name('koor.kecamatan.desa.index');

            Route::post('/kecamatan/{koorkecamatan:slug}/desa/store', [KoorDesaController::class, 'store'])
                ->name('koor.kecamatan.desa.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/edit',
                [KoorDesaController::class, 'edit']
            )->name('koor.kecamatan.desa.edit');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/grafik',
                [KoorDesaController::class, 'grafik']
            )->name('grafik.koorkecamatan.desa.index');


            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/edit/update',
                [KoorDesaController::class, 'update']
            )->name('koor.kecamatan.desa.update');

            Route::get(
                'kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt',
                [DptKoorKecamatanController::class, 'index']
            )
                ->name('koor.kecamatan.dpt.index');
            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/tambah',
                [DptKoorKecamatanController::class, 'create']
            )
                ->name('koor.kecamatan.dpt.create');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/tambah/store',
                [DptKoorKecamatanController::class, 'store']
            )
                ->name('koor.kecamatan.dpt.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/{dpt}/edit',
                [DptKoorKecamatanController::class, 'edit']
            )->name('koor.kecamatan.dpt.edit');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/dpt/{dpt}/edit/update',
                [DptKoorKecamatanController::class, 'update']
            )
                ->name('koor.kecamatan.dpt.update');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps',
                [TpsKoorKecamatanController::class, 'index']
            )
                ->name('koor.kecamatan.tps.index');


            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/store',
                [TpsKoorKecamatanController::class, 'store']
            )
                ->name('koor.kecamatan.tps.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/edit',
                [TpsKoorKecamatanController::class, 'edit']
            )->name('koor.kecamatan.tps.edit');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/edit/update',
                [TpsKoorKecamatanController::class, 'update']
            )->name('koor.kecamatan.tps.update');


            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/dpt',
                [DptTpsKoorKecamatanController::class, 'index']
            )
                ->name('koor.kecamatan.tps.dpt.index');


            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/tambah',
                [DptTpsKoorKecamatanController::class, 'create']
            )
                ->name('koor.kecamatan.tps.dpt.create');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/tambah/store',
                [DptTpsKoorKecamatanController::class, 'store']
            )
                ->name('koor.kecamatan.tps.dpt.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/edit',
                [DptTpsKoorKecamatanController::class, 'edit']
            )->name('koor.kecamatan.tps.dpt.edit');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/edit/update',
                [DptTpsKoorKecamatanController::class, 'update']
            )
                ->name('koor.kecamatan.tps.dpt.update');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count',
                [KoorKecamatanDesaQuickCountControler::class, 'index']
            )
                ->name('koor.kecamatan.desa.quick_count.index');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/tambah',
                [KoorKecamatanDesaQuickCountControler::class, 'create']
            )
                ->name('koor.kecamatan.desa.quick_count.create');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/tambah/store',
                [KoorKecamatanDesaQuickCountControler::class, 'store']
            )
                ->name('koor.kecamatan.desa.quick_count.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/{quickcount}/edit',
                [KoorKecamatanDesaQuickCountControler::class, 'edit']
            )
                ->name('koor.kecamatan.desa.quick_count.edit');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/real-count/{quickcount}/edit/store',
                [KoorKecamatanDesaQuickCountControler::class, 'update']
            )
                ->name('koor.kecamatan.desa.quick_count.update');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count',
                [KoorKecamatanQuickCountController::class, 'index']
            )
                ->name('koor.kecamatan.quick_count.index');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah',
                [KoorKecamatanQuickCountController::class, 'create']
            )
                ->name('koor.kecamatan.quick_count.create');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah/store',
                [KoorKecamatanQuickCountController::class, 'store']
            )
                ->name('koor.kecamatan.quick_count.store');

            Route::get(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/edit',
                [KoorKecamatanQuickCountController::class, 'edit']
            )
                ->name('koor.kecamatan.quick_count.edit');

            Route::post(
                '/kecamatan/{koorkecamatan:slug}/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/edit/store',
                [KoorKecamatanQuickCountController::class, 'update']
            )
                ->name('koor.kecamatan.quick_count.update');
        });



        // desa

        Route::middleware('can:isKoorDesa')->group(function () {

            Route::get('/desa', [DesaKoorDesaController::class, 'index'])
                ->name('koor.desa.index');

            Route::get('/desa/{koordesa:slug}/grafik', [DesaKoorDesaController::class, 'grafik'])->name('grafik.koodesa.index');

            Route::get(
                '/desa/{koordesa:slug}/edit',
                [DesaKoorDesaController::class, 'edit']
            )->name('koor.desa.edit');

            Route::post(
                '/desa/{koordesa:slug}/edit/update',
                [DesaKoorDesaController::class, 'update']
            )->name('koor.desa.update');

            Route::get('/desa/{koordesa:slug}/dpt', [DptKoorDesaController::class, 'index'])
                ->name('koor.desa.dpt.index');

            Route::get(
                '/desa/{koordesa:slug}/dpt/tambah',
                [DptKoorDesaController::class, 'create']
            )
                ->name('koor.desa.dpt.create');

            Route::post('/desa/{koordesa:slug}/dpt/tambah/store', [DptKoorDesaController::class, 'store'])
                ->name('koor.desa.dpt.store');

            Route::get(
                '/desa/{koordesa:slug}/dpt/{dpt}/edit',
                [DptKoorDesaController::class, 'edit']
            )->name('koor.desa.dpt.edit');

            Route::post('/desa/{koordesa:slug}/dpt/{dpt}/edit/update', [DptKoorDesaController::class, 'update'])
                ->name('koor.desa.dpt.update');


            Route::get('/desa/{koordesa:slug}/tps', [TpsKoorDesaController::class, 'index'])
                ->name('koor.desa.tps.index');

            Route::post('/desa/{koordesa:slug}/tps/store', [TpsKoorDesaController::class, 'store'])
                ->name('koor.desa.tps.store');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/edit',
                [TpsKoorDesaController::class, 'edit']
            )->name('koor.desa.tps.edit');

            Route::post(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/edit/update',
                [TpsKoorDesaController::class, 'update']
            )->name('koor.desa.tps.update');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/dpt',
                [DptTpsKoorDesaController::class, 'index']
            )
                ->name('koor.desa.tps.dpt.index');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/tambah',
                [DptTpsKoorDesaController::class, 'create']
            )
                ->name('koor.desa.tps.dpt.create');

            Route::post(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/tambah/store',
                [DptTpsKoorDesaController::class, 'store']
            )
                ->name('koor.desa.tps.dpt.store');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/edit',
                [DptTpsKoorDesaController::class, 'edit']
            )->name('koor.desa.tps.dpt.edit');

            Route::post(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/dpt/{dpt}/edit/update',
                [DptTpsKoorDesaController::class, 'update']
            )
                ->name('koor.desa.tps.dpt.update');


            Route::get(
                '/desa/{koordesa:slug}/real-count',
                [KoorDesaDesaQuickCountControler::class, 'index']
            )
                ->name('koor.desa.desa.quick_count.index');

            Route::get(
                '/desa/{koordesa:slug}/real-count/tambah',
                [KoorDesaDesaQuickCountControler::class, 'create']
            )
                ->name('koor.desa.desa.quick_count.create');

            Route::post(
                '/desa/{koordesa:slug}/real-count/tambah/store',
                [KoorDesaDesaQuickCountControler::class, 'store']
            )
                ->name('koor.desa.desa.quick_count.store');

            Route::get(
                '/desa/{koordesa:slug}/real-count/{quickcount}/edit',
                [KoorDesaDesaQuickCountControler::class, 'edit']
            )
                ->name('koor.desa.desa.quick_count.edit');

            Route::post(
                '/desa/{koordesa:slug}/real-count/{quickcount}/edit/update',
                [KoorDesaDesaQuickCountControler::class, 'update']
            )
                ->name('koor.desa.desa.quick_count.update');


            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/real-count',
                [KoorDesaQuickCountController::class, 'index']
            )
                ->name('koor.desa.quick_count.index');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah',
                [KoorDesaQuickCountController::class, 'create']
            )
                ->name('koor.desa.quick_count.create');

            Route::post(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/tambah/store',
                [KoorDesaQuickCountController::class, 'store']
            )
                ->name('koor.desa.quick_count.store');

            Route::get(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/edit',
                [KoorDesaQuickCountController::class, 'edit']
            )
                ->name('koor.desa.quick_count.edit');

            Route::post(
                '/desa/{koordesa:slug}/tps/{koortps:slug}/real-count/{quickcount}/edit/update',
                [KoorDesaQuickCountController::class, 'update']
            )
                ->name('koor.desa.quick_count.update');
        });


        // tps

        Route::middleware('can:isKoorTps')->group(function () {

            Route::get('/dashboardtps', [DashboardKoorTpsController::class, 'index'])->name('dashboard.tps.index');

            Route::get('/tps', [TpsKoorTpsController::class, 'index'])
                ->name('koor.tps.index');

            Route::get(
                '/tps/{koortps:slug}/edit',
                [TpsKoorTpsController::class, 'edit']
            )->name('koor.tps.edit');

            Route::post(
                '/tps/{koortps:slug}/edit/update',
                [TpsKoorTpsController::class, 'update']
            )->name('koor.tps.update');


            Route::get(
                '/tps/{koortps:slug}/dpt',
                [DptTpsKoorTpsController::class, 'index']
            )
                ->name('koor.tps.dpt.index');
            Route::get(
                '/tps/{koortps:slug}/dpt/tambah',
                [DptTpsKoorTpsController::class, 'create']
            )
                ->name('koor.tps.dpt.create');

            Route::post(
                '/tps/{koortps:slug}/dpt/tambah/store',
                [DptTpsKoorTpsController::class, 'store']
            )
                ->name('koor.tps.dpt.store');

            Route::get(
                '/tps/{koortps:slug}/dpt/{dpt}/edit',
                [DptTpsKoorTpsController::class, 'edit']
            )->name('koor.tps.dpt.edit');

            Route::post('/tps/{koortps:slug}/dpt/{dpt}/edit/update', [DptTpsKoorTpsController::class, 'update'])
                ->name('koor.tps.dpt.update');

            Route::get(
                '/tps/{koortps:slug}/real-count',
                [KoorTpsQuickCountController::class, 'index']
            )
                ->name('koor.tps.quick_count.index');

            Route::get(
                '/tps/{koortps:slug}/real-count/tambah',
                [KoorTpsQuickCountController::class, 'create']
            )
                ->name('koor.tps.quick_count.create');

            Route::post(
                '/tps/{koortps:slug}/real-count/tambah/store',
                [KoorTpsQuickCountController::class, 'store']
            )
                ->name('koor.tps.quick_count.store');

            Route::get(
                '/tps/{koortps:slug}/real-count/{quickcount}/edit',
                [KoorTpsQuickCountController::class, 'edit']
            )
                ->name('koor.tps.quick_count.edit');

            Route::post(
                '/tps/{koortps:slug}/real-count/{quickcount}/edit/update',
                [KoorTpsQuickCountController::class, 'update']
            )
                ->name('koor.tps.quick_count.update');
        });
    });
});
