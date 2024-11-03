<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth_controller;
use App\Http\Controllers\Entry_controller;

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
Route::get('/', [Auth_controller::class, 'index']);
Route::post('/login', [Auth_controller::class, 'login']);
Route::get('/logout', [Auth_controller::class, 'logout']);

// halaman
Route::get('/home', [Auth_controller::class, 'home']);
Route::get('/tambah_anggota', [Auth_controller::class, 'tambah_anggota']);


// action
Route::post('/tambah_jamaah', [Entry_controller::class, 'tambah_jamaah']);

