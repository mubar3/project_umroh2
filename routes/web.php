<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth_controller;
use App\Http\Controllers\Entry_controller;
use App\Http\Controllers\Controller;

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

// Route::get('/', function () {
//     return view('login');
// });

// auth
Route::get('/', [Controller::class, 'index']);
Route::get('/login_page', [Auth_controller::class, 'index'])->name('login_page');
Route::post('/login', [Auth_controller::class, 'login']);
Route::get('/data_anggota/{id}', [Auth_controller::class, 'data_anggota']);


Route::middleware(['auth'])->group(function () {

    // halaman
    Route::get('/home', [Auth_controller::class, 'home']);
    Route::get('/tambah_anggota', [Auth_controller::class, 'tambah_anggota'])->middleware('role:1,2,3,4');
    Route::get('/daftar_anggota', [Auth_controller::class, 'daftar_anggota'])->middleware('role:1,2,3,4,5');
    Route::get('/tambah_user', [Auth_controller::class, 'tambah_user'])->middleware('role:1,2');
    Route::get('/daftar_user', [Auth_controller::class, 'daftar_user'])->middleware('role:1,2');
    Route::get('/tabungan', [Auth_controller::class, 'tabungan'])->middleware('role:1,8');
    Route::get('/setoran', [Auth_controller::class, 'setoran'])->middleware('role:1,8');
    Route::get('/hutang', [Auth_controller::class, 'hutang'])->middleware('role:1,8');
    Route::get('/uang_keluar', [Auth_controller::class, 'uang_keluar'])->middleware('role:1,6');
    Route::get('/uang_masuk', [Auth_controller::class, 'uang_masuk'])->middleware('role:1,6');
    Route::get('/kategori_list', [Auth_controller::class, 'kategori_list'])->middleware('role:1,6');
    Route::get('/daftar_paket', [Auth_controller::class, 'daftar_paket'])->middleware('role:1');
    Route::get('/barang_masuk', [Auth_controller::class, 'barang_masuk'])->middleware('role:1,7');
    Route::get('/barang_keluar', [Auth_controller::class, 'barang_keluar'])->middleware('role:1,7');

    // cetak
    Route::get('/sertifikat/{id}', [Auth_controller::class, 'sertifikat']);
    Route::get('/kartu/{id}', [Auth_controller::class, 'kartu']);

    // action
    Route::get('/logout', [Auth_controller::class, 'logout']);
    Route::post('/tambah_jamaah', [Entry_controller::class, 'tambah_jamaah']);
    Route::post('/tambah_koordinator', [Entry_controller::class, 'tambah_koordinator']);
    Route::post('/tambah_user', [Entry_controller::class, 'tambah_user']);

    // ajax
    // Route::get('/ajax_get_jamaah', [Entry_controller::class, 'ajax_get_jamaah']);
    Route::get('/ajax_get_jamaah', 'App\Http\Controllers\Entry_controller@ajax_get_jamaah')->middleware('check.ajax.source');
    Route::get('/ajax_hapus_jamaah/{id}', 'App\Http\Controllers\Entry_controller@ajax_hapus_jamaah')->middleware('check.ajax.source');
    Route::get('/ajax_ubah_user/{task}/{id}', 'App\Http\Controllers\Entry_controller@ajax_ubah_user')->middleware('check.ajax.source');
    Route::get('/ajax_get_koordinator', 'App\Http\Controllers\Entry_controller@ajax_get_koordinator')->middleware('check.ajax.source');
    Route::get('/ajax_get_leader', 'App\Http\Controllers\Entry_controller@ajax_get_leader')->middleware('check.ajax.source');
    Route::get('/ajax_get_chart', 'App\Http\Controllers\Entry_controller@ajax_get_chart')->middleware('check.ajax.source');
    Route::get('/ajax_get_chart2', 'App\Http\Controllers\Entry_controller@ajax_get_chart2')->middleware('check.ajax.source');
    Route::get('/ajax_get_top_leader', 'App\Http\Controllers\Entry_controller@ajax_get_top_leader')->middleware('check.ajax.source');
    Route::get('/ajax_get_user', 'App\Http\Controllers\Entry_controller@ajax_get_user')->middleware('check.ajax.source');
    Route::get('/ajax_data_jamaah/{id_anggota}', 'App\Http\Controllers\Entry_controller@ajax_data_jamaah')->middleware('check.ajax.source');
    Route::post('/ajax_update_anggota', 'App\Http\Controllers\Entry_controller@ajax_update_anggota')->middleware('check.ajax.source');
    Route::post('/ajax_tambah_tabungan', 'App\Http\Controllers\Entry_controller@ajax_tambah_tabungan')->middleware('check.ajax.source');
    Route::post('/ajax_tambah_setoran', 'App\Http\Controllers\Entry_controller@ajax_tambah_setoran')->middleware('check.ajax.source');
    Route::post('/ajax_tambah_hutang', 'App\Http\Controllers\Entry_controller@ajax_tambah_hutang')->middleware('check.ajax.source');
    Route::post('/ajax_bayar_hutang', 'App\Http\Controllers\Entry_controller@ajax_bayar_hutang')->middleware('check.ajax.source');
    Route::post('/ajax_uang_keluar', 'App\Http\Controllers\Entry_controller@ajax_uang_keluar')->middleware('check.ajax.source');
    Route::post('/ajax_uang_masuk', 'App\Http\Controllers\Entry_controller@ajax_uang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_get_uang_keluar', 'App\Http\Controllers\Entry_controller@ajax_get_uang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_get_uang_masuk', 'App\Http\Controllers\Entry_controller@ajax_get_uang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_hapus_uang_keluar/{id}', 'App\Http\Controllers\Entry_controller@ajax_hapus_uang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_hapus_uang_masuk/{id}', 'App\Http\Controllers\Entry_controller@ajax_hapus_uang_masuk')->middleware('check.ajax.source');
    Route::post('/ajax_edit_pass_user', 'App\Http\Controllers\Entry_controller@ajax_edit_pass_user')->middleware('check.ajax.source');
    Route::post('/ajax_list_uang_masuk', 'App\Http\Controllers\Entry_controller@ajax_list_uang_masuk')->middleware('check.ajax.source');
    Route::post('/ajax_list_uang_keluar', 'App\Http\Controllers\Entry_controller@ajax_list_uang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_get_list_uang_masuk', 'App\Http\Controllers\Entry_controller@ajax_get_list_uang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_get_list_uang_keluar', 'App\Http\Controllers\Entry_controller@ajax_get_list_uang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_ubah_list_uang_masuk/{action}/{id}', 'App\Http\Controllers\Entry_controller@ajax_ubah_list_uang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_ubah_list_uang_keluar/{action}/{id}', 'App\Http\Controllers\Entry_controller@ajax_ubah_list_uang_keluar')->middleware('check.ajax.source');
    Route::post('/ajax_tambah_paket', 'App\Http\Controllers\Entry_controller@ajax_tambah_paket')->middleware('check.ajax.source');
    Route::get('/ajax_get_paket', 'App\Http\Controllers\Entry_controller@ajax_get_paket')->middleware('check.ajax.source');
    Route::get('/ajax_ubah_paket/{action}/{id}', 'App\Http\Controllers\Entry_controller@ajax_ubah_paket')->middleware('check.ajax.source');
    Route::get('/ajax_get_barang', 'App\Http\Controllers\Entry_controller@ajax_get_barang')->middleware('check.ajax.source');
    Route::post('/ajax_barang_masuk', 'App\Http\Controllers\Entry_controller@ajax_barang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_get_barang_masuk', 'App\Http\Controllers\Entry_controller@ajax_get_barang_masuk')->middleware('check.ajax.source');
    Route::get('/ajax_hapus_barang_masuk/{id}', 'App\Http\Controllers\Entry_controller@ajax_hapus_barang_masuk')->middleware('check.ajax.source');
    Route::post('/ajax_barang_keluar', 'App\Http\Controllers\Entry_controller@ajax_barang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_get_barang_keluar', 'App\Http\Controllers\Entry_controller@ajax_get_barang_keluar')->middleware('check.ajax.source');
    Route::get('/ajax_hapus_barang_keluar/{id}', 'App\Http\Controllers\Entry_controller@ajax_hapus_barang_keluar')->middleware('check.ajax.source');
});


// alamat
Route::get('provinces', 'App\Http\Controllers\Controller@provinces')->name('provinces');
Route::get('cities', 'App\Http\Controllers\Controller@cities')->name('cities');
Route::get('districts', 'App\Http\Controllers\Controller@districts')->name('districts');
Route::get('villages', 'App\Http\Controllers\Controller@villages')->name('villages');

