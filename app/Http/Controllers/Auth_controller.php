<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Bank;
use App\Models\User;
use App\Models\Daftar_paket;
use App\Models\Setoran;
use App\Models\Uang_keluar_list;
use App\Models\Uang_masuk_list;
use App\Models\Role;
use Carbon\Carbon;
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
            $roles=Role::where('status','y')->get();
            return view('login')->with([
                'roles' => $roles
            ]);
        }

    }
    function login(Request $data) {

        if (Auth::attempt(['email' => $data->email, 'password' => $data->password, 'role' => $data->role])) {
            if(Auth::user()->status == 'n'){
                Auth::logout();
                session()->flash('eror', 'Akun nonaktif');
                return redirect('/login_page');
            }elseif(Auth::user()->hapus == 'y'){
                Auth::logout();
                session()->flash('eror', 'Akun telah dihapus');
                return redirect('/login_page');
            }

            // // cek koor naik pangkat
            // if($data->role == 4){
            //     if( (Anggota::where('koordinator',Auth::user()->id)->where('status','y')->count()) >= 5 ){
            //         // naik ke leader
            //         $roles=Role::find(3);
            //         $role=strtolower(str_replace(" ", ".", $roles->nama));
            //         $data->email=Auth::user()->id.'@'.$role;
            //         User::find(Auth::user()->id)->update([
            //             'role'  => 3,
            //             'email' =>$data->email
            //         ]);

            //         // login ulang
            //         Auth::logout();
            //         Auth::attempt(['email' => $data->email, 'password' => $data->password, 'role' => 3]);

            //         $this->log_web('/naik_pangkat');

            //         return view('dashboard.halaman')->with([
            //             'halaman'   => 'home',
            //             'email_baru'   => $data->email,
            //             'pangkat' =>$roles->nama
            //         ]);
            //     }
            // }


            // // leader koor naik pangkat
            // if($data->role == 3){
            //     if( (User::where('atasan',Auth::user()->id)->where('status','y')->count()) >= 3 ){
            //         // naik ke top leader
            //         $roles=Role::find(2);
            //         $role=strtolower(str_replace(" ", ".", $roles->nama));
            //         $data->email=Auth::user()->id.'@'.$role;
            //         User::find(Auth::user()->id)->update([
            //             'role'  => 2,
            //             'email' =>$data->email
            //         ]);

            //         // login ulang
            //         Auth::logout();
            //         Auth::attempt(['email' => $data->email, 'password' => $data->password, 'role' => 2]);

            //         $this->log_web('/naik_pangkat');

            //         return view('dashboard.halaman')->with([
            //             'halaman'   => 'home',
            //             'email_baru'   => $data->email,
            //             'pangkat' =>$roles->nama
            //         ]);
            //     }
            // }

            return redirect('/home');
        }else{
            session()->flash('eror', 'Username / password / role salah');
            return redirect('/login_page');
        }
    }

    function home() {
        $this->log_web('/home');

        return view('dashboard.halaman')->with([
            'halaman'   => 'home',
            // 'jumlah_jamaah_total'   => $jumlah_jamaah,
            // 'jumlah_jamaah'   => $anggota,
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
        $roles=Role::where('status','y')->whereNot('id',4);
        if(Auth::user()->role == 2){
            // top leader hanya bisa input leader
            $roles=$roles->where('id',3)->get();
        }else{
            $roles=$roles->get();
        }

        return view('dashboard.halaman')->with([
            'halaman'   => 'tambah_user',
            'roles'   => $roles,
        ]);
    }

    function daftar_user() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_user',
        ]);
    }

    function tabungan() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'tabungan',
        ]);
    }

    function setoran() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'setoran',
        ]);
    }

    function hutang() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'hutang',
        ]);
    }

    function uang_keluar() {
        $list=Uang_keluar_list::where('status','y')->get();
        $bank=Bank::where('status','y')->get();
        return view('dashboard.halaman')->with([
            'halaman'   => 'uang_keluar',
            'list'   => $list,
            'bank'   => $bank,
        ]);
    }

    function uang_masuk() {
        $list=Uang_masuk_list::where('status','y')->get();
        $bank=Bank::where('status','y')->get();
        return view('dashboard.halaman')->with([
            'halaman'   => 'uang_masuk',
            'list'   => $list,
            'bank'   => $bank,
        ]);
    }

    function barang_masuk() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'barang_masuk',
        ]);
    }

    function barang_keluar() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'barang_keluar',
        ]);
    }

    function kategori_list() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'kategori_list',
        ]);
    }

    function daftar_paket() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_paket',
        ]);
    }

    function daftar_bank() {
        return view('dashboard.halaman')->with([
            'halaman'   => 'daftar_bank',
        ]);
    }

    function sertifikat($id) {
        $id = Crypt::decryptString($id);
        $anggota=Anggota::find($id);

        $this->log_web('/sertifikat_'.$id);

        if($anggota->jenis_akun == 'jamaah'){
            $anggota->nama_koordinator=User::find($anggota->koordinator)?->name;
            $anggota->id_koordinator=User::find($anggota->koordinator)?->id;

        }else{
            $anggota->nama_koordinator=$anggota->nama;
            $anggota->id_koordinator=User::where('id_anggota',$anggota->id_anggota)->value('id');
        }

        $leader=User::find( User::find($anggota->id_koordinator)?->atasan );
        $anggota->nama_leader=$leader->name;

        $top_leader=User::find( $leader->atasan );
        $anggota->nama_top_leader=$top_leader->name;

        Carbon::setLocale('id');
        $anggota->tanggal_lahir=Carbon::parse($anggota->tanggal_lahir)->translatedFormat('j F Y');

        $anggota->foto=env('APP_URL').'/storage/foto/'.$anggota->foto;

        return view('dashboard.cetak.sertifikat')->with([
            'anggota'   => $anggota,
        ]);
    }

    function kartu($id) {
        $id = Crypt::decryptString($id);

        $this->log_web('/kartu_'.$id);

        $anggota=Anggota::select(
                '*',
                DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
            )
            ->where('id_anggota',$id)
            ->first();

        return view('dashboard.cetak.kartu')->with([
            'anggota'   => $anggota,
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
                DB::raw("
                    CASE
                        WHEN `tabungan`.`saldo` is NULL THEN 0
                        ELSE `tabungan`.`saldo`
                    END AS `saldo`
                "),
                DB::raw("
                    CASE
                        WHEN `daftar_paket`.`harga` is NULL THEN 0
                        ELSE `daftar_paket`.`harga`
                    END AS `tagihan_paket`
                "),
                DB::raw("
                    CASE
                        WHEN `setoran`.`saldo_total` is NULL THEN 0
                        ELSE `setoran`.`saldo_total`
                    END AS `setoran`
                "),
                DB::raw("
                    CASE
                        WHEN `hutang`.`saldo_total` is NULL THEN 0
                        ELSE `hutang`.`saldo_total`
                    END AS `hutang`
                "),
                'leader.name as leader'
                // 'tabungan.saldo'
            )
            ->join('indonesia_provinces as p','p.id','=','anggota.provinsi')
            ->join('indonesia_cities as k','k.id','=','anggota.kota')
            ->join('indonesia_districts as kc','kc.id','=','anggota.kecamatan')
            ->join('indonesia_villages as d','d.id','=','anggota.desa')
            ->leftjoin('daftar_paket as dp','dp.id_paket','=','anggota.paket')
            ->leftjoin('users','users.id','=','anggota.koordinator')
            ->leftjoin('users as koor','koor.id_anggota','=','anggota.id_anggota')
            ->leftjoin('users as leader','leader.id','=','koor.atasan')
            ->leftjoin('tabungan','tabungan.id_anggota','=','anggota.id_anggota')
            ->leftjoin('daftar_paket','daftar_paket.id_paket','=','anggota.paket')
            ->leftjoin('setoran',function ($join) {
                $join->on('setoran.id_anggota','=','anggota.id_anggota')
                    ->whereColumn('setoran.input_time','=',DB::raw('(SELECT MAX(s1.input_time) FROM setoran as s1 WHERE s1.id_anggota = anggota.id_anggota)'))
                    ;
            })
            ->leftjoin('hutang',function ($join) {
                $join->on('hutang.id_anggota','=','anggota.id_anggota')
                    ->whereColumn('hutang.input_time','=',DB::raw('(SELECT MAX(h1.input_time) FROM hutang as h1 WHERE h1.id_anggota = anggota.id_anggota)'))
                    ;
            })
            ->where('anggota.id_anggota',$id)
            ->first();

        $anggota->saldo=$this->formatRupiah($anggota->saldo);
        $anggota->tagihan_paket=$this->formatRupiah($anggota->tagihan_paket);
        $anggota->setoran=$this->formatRupiah($anggota->setoran);
        $anggota->hutang=$this->formatRupiah($anggota->hutang);

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
