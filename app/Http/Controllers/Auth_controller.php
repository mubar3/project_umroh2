<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Bank;
use App\Models\Daftar_paket;

class Auth_controller extends Controller
{

    function index() {
        // return Auth::check();
        if (Auth::check()) {
            return redirect('/home');
        }else{
            return view('login');
        }

    }
    function login(Request $data) {

        if (Auth::attempt(['email' => $data->email, 'password' => $data->password, 'role' => $data->role])) {
            return redirect('/home');
        }else{
            session()->flash('eror', 'username/password/jenis akun salah');
            return redirect('/login_page');
        }
    }

    function home() {
        $jumlah_jamaah=Anggota::where('jenis_akun','jamaah')->where('status','y')->count();
        return view('dashboard.halaman')->with([
            'halaman'   => 'home',
            'jumlah_jamaah'   => $jumlah_jamaah,
        ]);
    }

    function tambah_anggota() {
        $paket=Daftar_paket::where('status','y')->get();
        $bank=Bank::where('status','y')->get();
        return view('dashboard.halaman')->with([
            'halaman'   => 'tambah_anggota',
            'paket'   => $paket,
            'bank'   => $bank,

        ]);
    }

    function daftar_anggota() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_anggota',
        ]);
    }

    function logout() {
        Auth::logout();
        return redirect('/login_page'); // Redirect ke halaman login setelah logout
    }
}
