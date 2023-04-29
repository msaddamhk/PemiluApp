<?php

use App\Http\Controllers\General\DesaController;
use App\Http\Controllers\General\DptController;
use App\Http\Controllers\General\DptTpsController;
use App\Http\Controllers\General\KecamatanController;
use App\Http\Controllers\General\TpsController;
use App\Http\Controllers\General\KotaController;
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
    Route::post('/dpt/update/{id_dpt}', [DptTpsController::class, 'update'])
        ->name('tps.dpt.update');
});
