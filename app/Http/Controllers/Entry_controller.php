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
use Illuminate\Support\Facades\Auth;

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
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'alamat' => 'required',
        ]);
        if(!empty($cek_validator)){
            session()->flash('eror', $cek_validator);
            return redirect('/tambah_anggota');
        }


        DB::beginTransaction();
        try {
            $nama_foto='ft'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
            $this->upload_foto($data->foto,public_path('/storage/foto'),$nama_foto);
            $data->foto=$nama_foto;

            $nama_foto='ktp'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
            $this->upload_foto($data->ktp,public_path('/storage/ktp'),$nama_foto);
            $data->ktp=$nama_foto;

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
                'foto'  => $data->foto,
                'ktp'  => $data->ktp,
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
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if(!empty($cek_validator)){
            session()->flash('eror', $cek_validator);
            return redirect('/tambah_anggota');
        }


        DB::beginTransaction();
        try {
            $nama_foto='ft'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
            $this->upload_foto($data->foto,public_path('/storage/foto'),$nama_foto);
            $data->foto=$nama_foto;

            $nama_foto='ktp'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
            $this->upload_foto($data->ktp,public_path('/storage/ktp'),$nama_foto);
            $data->ktp=$nama_foto;

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
                'foto'  => $data->foto,
                'ktp'  => $data->ktp,
            ]);


            User::create([
                'id_anggota' => $tambah_anggota->id_anggota,
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
        $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('name', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('role',4)
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

    function ajax_get_chart() {

        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');

        // Loop untuk 4 bulan ke belakang
        foreach (range(3, 0) as $i) {
            $date = Carbon::now()->subMonths($i);
            $labels[]=$date->translatedFormat('F');

            $jamaah=Anggota::select(
                    DB::raw('count(*) as jumlah_jamaah')
                )
                ->whereMonth('input_time',$date->format('n'))
                ->whereYear('input_time',$date->format('Y'))
                ->where('status','y')
                ->where('jenis_akun','jamaah')
                ->first();
            $total_jamaah=Anggota::where('status','y')
                ->where('jenis_akun','jamaah')
                ->count();
            $jumlah_jamaah[]=$jamaah->jumlah_jamaah;

            $koordinator=Anggota::select(
                    DB::raw('count(*) as jumlah_koordinator')
                )
                ->whereMonth('input_time',$date->format('n'))
                ->whereYear('input_time',$date->format('Y'))
                ->where('status','y')
                ->where('jenis_akun','koordinator')
                ->first();
            $total_koordinator=Anggota::where('status','y')
                ->where('jenis_akun','koordinator')
                ->count();
            $jumlah_koordinator[]=$koordinator->jumlah_koordinator;

            // echo $date->format('n') . ' - ' . $date->format('Y') . ' - ' . $date->translatedFormat('F') . PHP_EOL;

        }

        $data = [
            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jamaah total : '. $total_jamaah,
                    'backgroundColor' => 'rgba(60,141,188,0.9)',
                    'borderColor' => 'rgba(60,141,188,0.8)',
                    'pointRadius' => false,
                    'pointColor' => '#3b8bba',
                    'pointStrokeColor' => 'rgba(60,141,188,1)',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(60,141,188,1)',
                    // 'data' => [28, 48, 40, 19, 86, 27, 90]
                    'data' => $jumlah_jamaah
                ],
                [
                    'label' => 'Koordinator total : '. $total_koordinator,
                    'backgroundColor' => 'rgba(210, 214, 222, 1)',
                    'borderColor' => 'rgba(210, 214, 222, 1)',
                    'pointRadius' => false,
                    'pointColor' => 'rgba(210, 214, 222, 1)',
                    'pointStrokeColor' => '#c1c7d1',
                    'pointHighlightFill' => '#fff',
                    'pointHighlightStroke' => 'rgba(220,220,220,1)',
                    'data' => $jumlah_koordinator
                ],
            ]
        ];

        return response()->json($data);

    }
}
