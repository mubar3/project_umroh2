<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class Entry_controller extends Controller
{
    function tambah_jamaah(Request $data) {

        $cek_validator=$this->validator($data,[
            'tanggal' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor' => 'required',
            'paket' => 'required',
            'koordinator' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            // 'alamat' => 'required',
        ]);
        if(!empty($cek_validator)){
            session()->flash('eror', $cek_validator);
            return redirect('/tambah_anggota');
        }


        DB::beginTransaction();
        try {
            Anggota::create([
                'nama'  => $data->nama,
                'tanggal_mendaftar'  => $data->tanggal,
                'jenis_kelamin'  => $data->kelamin,
                'provinsi'  => $data->provinsi,
                'kota'  => $data->kota,
                'kecamatan'  => $data->kecamatan,
                'desa'  => $data->desa,
                'alamat'  => $data->alamat,
                'tempat_lahir'  => $data->tempat_lahir,
                'tanggal_lahir'  => $data->tanggal_lahir,
                'nomor'  => $data->nomor,
                'jenis_akun'  => 'jamaah',
                'paket'  => $data->paket,
                'koordinator'  => $data->koordinator,
            ]);
            DB::commit();
            session()->flash('success', 'Jamaah telah berhasil ditambahkan');
            return redirect('/tambah_anggota');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('eror', 'Terjadi Kesalahan dalam penyimpanan data, silahkan ulangi beberapa menit kemudian');
            return redirect('/tambah_anggota');
        }

    }
    function tambah_koordinator(Request $data) {

        $cek_validator=$this->validator($data,[
            'tanggal' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'leader' => 'required',
            'bank' => 'required',
            'nama_rekening' => 'required',
            'nomor_rekening' => 'required',
        ]);
        if(!empty($cek_validator)){
            session()->flash('eror', $cek_validator);
            return redirect('/tambah_anggota');
        }


        DB::beginTransaction();
        try {
            $tambah_anggota=Anggota::create([
                'nama'  => $data->nama,
                'tanggal_mendaftar'  => $data->tanggal,
                'jenis_kelamin'  => $data->kelamin,
                'provinsi'  => $data->provinsi,
                'kota'  => $data->kota,
                'kecamatan'  => $data->kecamatan,
                'desa'  => $data->desa,
                'alamat'  => $data->alamat,
                'tempat_lahir'  => $data->tempat_lahir,
                'tanggal_lahir'  => $data->tanggal_lahir,
                'nomor'  => $data->nomor,
                'jenis_akun'  => 'koordinator',
                'leader'  => $data->leader,
                'bank'  => $data->bank,
                'nama_rekening'  => $data->nama_rekening,
                'nomor_rekening'  => $data->nomor_rekening,
            ]);


            User::create([
                'name' => $data->nama,
                'email' => $tambah_anggota->id_anggota.'@leader',
                'role' => 4,
                'password' => bcrypt('asd'), // Pastikan untuk mengenkripsi password
            ]);
            DB::commit();
            session()->flash('success', 'Koordinator telah berhasil ditambahkan');
            return redirect('/tambah_anggota');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('eror', 'Terjadi Kesalahan dalam penyimpanan data, silahkan ulangi beberapa menit kemudian');
            return redirect('/tambah_anggota');
        }

    }

    function ajax_get_jamaah() {
        return response()->json(Anggota::where('status','y')->get());
    }

    function ajax_hapus_jamaah($id){
        $anggota=Anggota::find($id);
        if($anggota){
            $anggota->update(['status'=>'n']);
            return response()->json(['message' => 'User deleted successfully.']);
        }else{
            return response()->json(['message' => 'User not found.'], 404);
        }

    }

    function ajax_get_koordinator(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        // Query ke database, misalnya mencari nama yang mirip dengan keyword
        $data = Anggota::select('id_anggota as id', 'nama as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('nama', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('jenis_akun','koordinator')
                ->get();

        // Mengembalikan data dalam format JSON
        return response()->json(['items' => $data]);

    }



    function ajax_get_leader(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        // Query ke database, misalnya mencari nama yang mirip dengan keyword
        $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('name', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('role',3)
                ->get();

        // Mengembalikan data dalam format JSON
        return response()->json(['items' => $data]);

    }
}
