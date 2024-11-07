<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Bank;
use App\Models\Daftar_paket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
            session()->flash('eror', 'username/password/role salah');
            return redirect('/login_page');
        }
    }

    function home() {
        $this->log_web('/home');
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
        $paket=Daftar_paket::where('status','y')->get();
        $bank=Bank::where('status','y')->get();
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_anggota',
            'paket'   => $paket,
            'bank'   => $bank,
        ]);
    }

    function tambah_user() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'tambah_user',
        ]);
    }

    function daftar_user() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_user',
        ]);
    }

    function data_anggota($id) {
        $id = Crypt::decryptString($id);
        $anggota=Anggota::select(
                'anggota.*',
                'p.name as provinsi',
                'kc.name as kecamatan',
                'k.name as kota',
                'd.name as desa',
                'dp.judul as paket',
                'users.name as koordinator',
                DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                DB::raw("concat('".env('APP_URL')."','/storage/ktp/',anggota.ktp) as 'ktp'"),
            )
            ->join('indonesia_provinces as p','p.id','=','anggota.provinsi')
            ->join('indonesia_cities as k','k.id','=','anggota.kota')
            ->join('indonesia_districts as kc','kc.id','=','anggota.kecamatan')
            ->join('indonesia_villages as d','d.id','=','anggota.desa')
            ->leftjoin('daftar_paket as dp','dp.id_paket','=','anggota.paket')
            ->leftjoin('users','users.id','=','anggota.koordinator')
            ->where('anggota.id_anggota',$id)
            ->first();

        return view('data_anggota')->with([
            'anggota'   => $anggota,
        ]);
    }

    function logout() {
        $this->log_web('/logout');
        Auth::logout();
        return redirect('/login_page'); // Redirect ke halaman login setelah logout
    }
}
