<?php

use App\Http\Controllers\DesaController;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});


Route::get('/kabupatenkota', [GeneralController::class, 'index'])->name('kota.index');
Route::get('/tambahkabupatenkota', [GeneralController::class, 'create'])->name('kota.create');
Route::post('/kota/store', [GeneralController::class, 'store'])->name('kota.store');


Route::get('/kota/{id_kota}', [GeneralController::class, 'show'])->name('kota.show');
Route::get('/tambahkecamatan/{id_kota}', [GeneralController::class, 'create_kecamatan'])->name('kecamatan.create');
Route::post('/kecamatan/store/{id_kota}', [GeneralController::class, 'store_kecamatan'])->name('kecamatan.store');


Route::get('/{id_kecamatan}/desa', [DesaController::class, 'index'])->name('desa.index');
Route::get('/tambahdesa/{id_kecamatan}', [DesaController::class, 'create'])->name('desa.create');
Route::post('/desa/store/{id_kecamatan}', [DesaController::class, 'store'])->name('desa.store');
