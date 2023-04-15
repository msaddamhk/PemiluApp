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



































// Route::get('/nama', 'NamaController@index')->name('nama.index');
// Route::get('/nama/tambah', 'NamaController@create')->name('nama.create');
// Route::post('/nama/store', 'NamaController@store')->name('nama.store');
// Route::get('/nama/detail/{id}', 'NamaController@show')->name('nama.detail');
// Route::get('/nama/edit/{id}', 'NamaController@edit')->name('nama.edit');
// Route::put('/nama/update/{id}', 'NamaController@update')->name('nama.update');
// Route::delete('/nama/delete/{id}', 'NamaController@destroy')->name('nama.delete');
