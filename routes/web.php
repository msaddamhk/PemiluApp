<?php

use App\Http\Controllers\desa\DptKoorDesaController;
use App\Http\Controllers\desa\DptTpsKoorDesaController;
use App\Http\Controllers\desa\KoorDesaController as DesaKoorDesaController;
use App\Http\Controllers\desa\TpsKoorDesaController;
use App\Http\Controllers\General\DesaController;
use App\Http\Controllers\General\DptController;
use App\Http\Controllers\General\DptTpsController;
use App\Http\Controllers\General\KecamatanController;
use App\Http\Controllers\General\TpsController;
use App\Http\Controllers\General\KotaController;
use App\Http\Controllers\kecamatan\DptKoorKecamatanController;
use App\Http\Controllers\kecamatan\DptTpsKoorKecamatanController;
use App\Http\Controllers\kecamatan\KoorDesaController;
use App\Http\Controllers\kecamatan\KoorKecamatanController;
use App\Http\Controllers\kecamatan\TpsKoorKecamatanController;
use App\Http\Controllers\tps\DptTpsKoorTpsController;
use App\Http\Controllers\tps\TpsKoorTpsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/home', function () {
    return view('home');
})->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('index');
    })->name('dashboard.index');

    Route::resource('data-admin', \App\Http\Controllers\UserController::class)->names('users');
    Route::get('/kabkota', [KotaController::class, 'index'])->name('kota.index');
    Route::post('/kabkota/store', [KotaController::class, 'store'])->name('kota.store');


    Route::get('/kabkota/{slug_kota}/kecamatan', [KecamatanController::class, 'index'])
        ->name('kecamatan.index');

    Route::post('/kecamatan/store/{id_kota}', [KecamatanController::class, 'store_kecamatan'])
        ->name('kecamatan.store');


    Route::get('/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa', [DesaController::class, 'index'])
        ->name('desa.index');
    Route::post('/desa/store/{id_kecamatan}', [DesaController::class, 'store'])
        ->name('desa.store');


    Route::get('/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt', [DptController::class, 'index'])
        ->name('dpt.index');
    Route::get(
        '/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt/tambah',
        [DptController::class, 'create']
    )
        ->name('dpt.create');
    Route::post('/dpt/store/{id_desa}', [DptController::class, 'store'])
        ->name('dpt.store');
    Route::get(
        '/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt/{id_dpt}/edit',
        [DptController::class, 'edit']
    )->name('dpt.edit');

    Route::post('/dpt/update/{id_dpt}', [DptController::class, 'update'])
        ->name('dpt.update');

    Route::post('/dpt/update.voters/{id_dpt}', [DptController::class, 'update_voters'])
        ->name('dpt.update_voters');

    Route::get('/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps', [TpsController::class, 'index'])
        ->name('tps.index');
    Route::post('/tps/store/{id_desa}', [TpsController::class, 'store'])->name('tps.store');


    Route::get(
        '/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}',
        [DptTpsController::class, 'index']
    )
        ->name('tps.dpt.index');
    Route::get(
        '/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}/tambah',
        [DptTpsController::class, 'create']
    )
        ->name('tps.dpt.create');
    Route::post(
        '/tps/store/{id_desa}/{id_tps}',
        [DptTpsController::class, 'store']
    )
        ->name('tps.dpt.store');
    Route::get(
        '/kabkota/{slug_kota}/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}/{id_dpt}/edit',
        [DptTpsController::class, 'edit']
    )->name('tps.dpt.edit');
    Route::post('/tps/dpt/update/{id_dpt}', [DptTpsController::class, 'update'])
        ->name('tps.dpt.update');
    Route::post('/tps/dpt/update.voters/{id_dpt}', [DptTpsController::class, 'update_voters'])
        ->name('tps.dpt.update_voters');



    // koor kecamatan
    Route::get('/kecamatan', [KoorKecamatanController::class, 'index'])
        ->name('koor.kecamatan.index');
    Route::get('/kecamatan/{slug_kecamatan}/desa', [KoorDesaController::class, 'index'])
        ->name('koor.kecamatan.desa.index');
    Route::post('kecamatan/desa/store/{id_kecamatan}', [KoorDesaController::class, 'store'])
        ->name('koor.kecamatan.desa.store');

    Route::get('kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt', [DptKoorKecamatanController::class, 'index'])
        ->name('koor.kecamatan.dpt.index');
    Route::get(
        '/kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt/tambah',
        [DptKoorKecamatanController::class, 'create']
    )
        ->name('koor.kecamatan.dpt.create');
    Route::post('/kecamatan/dpt/store/{id_desa}', [DptKoorKecamatanController::class, 'store'])
        ->name('koor.kecamatan.dpt.store');
    Route::get(
        '/kecamatan/{slug_kecamatan}/desa/{slug_desa}/dpt/{id_dpt}/edit',
        [DptKoorKecamatanController::class, 'edit']
    )->name('koor.kecamatan.dpt.edit');
    Route::post('kecamatan/dpt/update/{id_dpt}', [DptKoorKecamatanController::class, 'update'])
        ->name('koor.kecamatan.dpt.update');
    Route::post('/kecamatan/dpt/update.voters/{id_dpt}', [DptKoorKecamatanController::class, 'update_voters'])
        ->name('koor.kecamatan.dpt.update_voters');

    Route::get('/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps', [TpsKoorKecamatanController::class, 'index'])
        ->name('koor.kecamatan.tps.index');
    Route::post('/kecamatan/tps/store/{id_desa}', [TpsKoorKecamatanController::class, 'store'])
        ->name('koor.kecamatan.tps.store');
    Route::get(
        '/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}',
        [DptTpsKoorKecamatanController::class, 'index']
    )
        ->name('koor.kecamatan.tps.dpt.index');
    Route::get(
        '/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}/tambah',
        [DptTpsKoorKecamatanController::class, 'create']
    )
        ->name('koor.kecamatan.tps.dpt.create');
    Route::post(
        'kecamatan/tps/dpt/store/{id_desa}/{id_tps}',
        [DptTpsKoorKecamatanController::class, 'store']
    )
        ->name('koor.kecamatan.tps.dpt.store');
    Route::get(
        '/kecamatan/{slug_kecamatan}/desa/{slug_desa}/tps/{slug_tps}/{id_dpt}/edit',
        [DptTpsKoorKecamatanController::class, 'edit']
    )->name('koor.kecamatan.tps.dpt.edit');
    Route::post('/kecamatan/tps/dpt/update/{id_dpt}', [DptTpsKoorKecamatanController::class, 'update'])
        ->name('koor.kecamatan.tps.dpt.update');
    Route::post('/kecamatan/tps/dpt/update.voters/{id_dpt}', [DptTpsKoorKecamatanController::class, 'update_voters'])
        ->name('koor.kecamatan.tps.dpt.update_voters');



    // desa

    Route::get('/desa', [DesaKoorDesaController::class, 'index'])
        ->name('koor.desa.index');
    Route::get('/desa/{slug_desa}/dpt', [DptKoorDesaController::class, 'index'])
        ->name('koor.desa.dpt.index');
    Route::get(
        '/desa/{slug_desa}/dpt/tambah',
        [DptKoorDesaController::class, 'create']
    )
        ->name('koor.desa.dpt.create');
    Route::post('/desa/dpt/store/{id_desa}', [DptKoorDesaController::class, 'store'])
        ->name('koor.desa.dpt.store');
    Route::get(
        '/desa/{slug_desa}/dpt/{id_dpt}/edit',
        [DptKoorDesaController::class, 'edit']
    )->name('koor.desa.dpt.edit');

    Route::post('desa/dpt/update/{id_dpt}', [DptKoorDesaController::class, 'update'])
        ->name('koor.desa.dpt.update');

    Route::post('/desa/dpt/update.voters/{id_dpt}', [DptKoorDesaController::class, 'update_voters'])
        ->name('koor.desa.dpt.update_voters');

    Route::get('/desa/{slug_desa}/tps', [TpsKoorDesaController::class, 'index'])
        ->name('koor.desa.tps.index');

    Route::post('/desa/tps/store/{id_desa}', [TpsKoorDesaController::class, 'store'])
        ->name('koor.desa.tps.store');

    Route::get(
        '/desa/{slug_desa}/tps/{slug_tps}',
        [DptTpsKoorDesaController::class, 'index']
    )
        ->name('koor.desa.tps.dpt.index');
    Route::get(
        '/desa/{slug_desa}/tps/{slug_tps}/tambah',
        [DptTpsKoorDesaController::class, 'create']
    )
        ->name('koor.desa.tps.dpt.create');
    Route::post(
        '/desa/tps/dpt/store/{id_desa}/{id_tps}',
        [DptTpsKoorDesaController::class, 'store']
    )
        ->name('koor.desa.tps.dpt.store');
    Route::get(
        '/desa/{slug_desa}/tps/{slug_tps}/{id_dpt}/edit',
        [DptTpsKoorDesaController::class, 'edit']
    )->name('koor.desa.tps.dpt.edit');

    Route::post('/desa/tps/dpt/update/{id_dpt}', [DptTpsKoorDesaController::class, 'update'])
        ->name('koor.desa.tps.dpt.update');

    Route::post('/desa/tps/dpt/update.voters/{id_dpt}', [DptTpsKoorDesaController::class, 'update_voters'])
        ->name('koor.desa.tps.dpt.update_voters');



    // tps
    Route::get('/tps', [TpsKoorTpsController::class, 'index'])
        ->name('koor.tps.index');
    Route::get(
        '/tps/{slug_tps}',
        [DptTpsKoorTpsController::class, 'index']
    )
        ->name('koor.tps.dpt.index');
    Route::get(
        '/tps/{slug_tps}/tambah',
        [DptTpsKoorTpsController::class, 'create']
    )
        ->name('koor.tps.dpt.create');
    Route::post(
        '/koortps/tps/dpt/store/{id_desa}/{id_tps}',
        [DptTpsKoorTpsController::class, 'store']
    )
        ->name('koor.tps.dpt.store');

    Route::get(
        '/tps/{slug_tps}/{id_dpt}/edit',
        [DptTpsKoorTpsController::class, 'edit']
    )->name('koor.tps.dpt.edit');

    Route::post('/koortps/tps/dpt/update/{id_dpt}', [DptTpsKoorTpsController::class, 'update'])
        ->name('koor.tps.dpt.update');

    Route::post('/koortps/tps/dpt/update.voters/{id_dpt}', [DptTpsKoorTpsController::class, 'update_voters'])
        ->name('koor.tps.dpt.update_voters');
});
