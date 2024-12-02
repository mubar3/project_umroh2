<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use App\Models\Tabungan;
use App\Models\Daftar_paket;
use App\Models\Tabungan_log;
use App\Models\Setoran;
use App\Models\Hutang;
use App\Models\Uang_keluar;
use App\Models\Uang_keluar_list;
use App\Models\Uang_masuk;
use App\Models\Uang_masuk_list;
use App\Models\Barang;
use App\Models\Log_barang;
use App\Models\Role;
use App\Models\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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

            if(!$this->isNullOrEmpty($data->rfid)){
                // cek rfid
                if( Anggota::where('rfid',$data->rfid)->where('status','y')->first() ){
                    session()->flash('eror', 'Nomor RFID ini sudah terdaftar di anggota yang lain');
                    return redirect('/tambah_anggota');
                }
            }
            $this->log_web('/tambah_jamaah');

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
                'rfid'  => $data->rfid,
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

            if(!$this->isNullOrEmpty($data->rfid)){
                // cek rfid
                if( Anggota::where('rfid',$data->rfid)->where('status','y')->first() ){
                    session()->flash('eror', 'Nomor RFID ini sudah terdaftar di anggota yang lain');
                    return redirect('/tambah_anggota');
                }
            }
            $this->log_web('/tambah_koordinator');

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
                'rfid'  => $data->rfid,
            ]);


            User::create([
                'id_anggota' => $tambah_anggota->id_anggota,
                'name' => $data->nama,
                'email' => $tambah_anggota->id_anggota.'@koordinator',
                'role' => 4,
                'password' => bcrypt('asd'), // Pastikan untuk mengenkripsi password
                'atasan'  => $data->leader
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

    function tambah_user(Request $data) {
        $cek_validator=$this->validator($data,[
            'role' => 'required',
            'nama' => 'required',
        ]);
        if(!empty($cek_validator)){
            session()->flash('eror', $cek_validator);
            return redirect('/tambah_user');
        }

        DB::beginTransaction();
        try {
            $this->log_web('/tambah_user');

            if($data->role == 2 && Auth::user()->role == 1){
                // admin input top leader
                $data->top_leader = Auth::user()->id;
            }elseif($data->role == 3 && Auth::user()->role == 1){
                // admin input leader
                if(!isset($data->top_leader) || isset($data->top_leader) && $this->isNullOrEmpty($data->top_leader)){
                    session()->flash('eror', 'Data top leader kosong');
                    return redirect('/tambah_user');
                }
            }elseif($data->role == 1 && Auth::user()->role == 1){
                // admin input admin
                $data->top_leader=null;
            }elseif($data->role == 3 && Auth::user()->role == 2){
                // top leader input leader
                $data->top_leader = Auth::user()->id;
            }elseif(in_array($data->role,[5,6,7,8]) && Auth::user()->role == 1){
                // admin input keanggotaan
                $data->top_leader=Auth::user()->id;
            }else{
                session()->flash('eror', 'Tidak valid');
                return redirect('/tambah_user');
            }

            $insert=User::create([
                'name' => $data->nama,
                // 'email' => $tambah_anggota->id_anggota.'@leader',
                'atasan' =>$data->top_leader,
                'role' => $data->role,
                'password' => bcrypt('asd'), // Pastikan untuk mengenkripsi password
            ]);

            $role=Role::find($data->role);
            if(!$role){
                session()->flash('eror', 'Role tidak valid');
                return redirect('/tambah_user');
            }
            $role=strtolower(str_replace(" ", ".", $role->nama));

            User::find($insert->id)->update(['email' => $insert->id.'@'.$role]);


            DB::commit();
            session()->flash('success', 'User telah berhasil didaftarkann, dengan email '.$insert->id.'@'.$role.' dan password : asd');
            return redirect('/tambah_user');
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('eror', 'Terjadi Kesalahan dalam penyimpanan data, silahkan ulangi beberapa menit kemudian');
            return redirect('/tambah_user');
        }

    }

    function ajax_update_anggota(Request $data) {
        // $data->id_anggota = Crypt::decryptString($data->id_anggota);
        $validasi=[
            'id_anggota' => 'required',
            'tanggal' => 'required',
            'nama' => 'required',
            'kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'nomor' => 'required',
            // 'paket' => 'required',
            // 'koordinator' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            // 'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'alamat' => 'required',
        ];
        if(!$this->isNullOrEmpty($data->foto)){
            $validasi['foto'] =  'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }
        if(!$this->isNullOrEmpty($data->ktp)){
            $validasi['ktp'] =  'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        if($data->jenis_akun == 'jamaah'){
            // ketika jamaah
            $validasi['paket'] =  'required';
        }else{
            // ketika koordinator
            $validasi['bank'] =  'required';
            $validasi['nama_rekening'] =  'required';
            $validasi['nomor_rekening'] =  'required';
        }

        $cek_validator=$this->validator($data,$validasi);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/update_anggota');
            $update=[
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
                'rfid'  => $data->rfid,
                // 'jenis_akun'  => 'jamaah',
                // 'paket'  => $data->paket,
                // 'koordinator'  => $data->koordinator,
                // 'foto'  => $data->foto,
                // 'ktp'  => $data->ktp,
            ];

            if($data->jenis_akun == 'jamaah'){
                // ketika jamaah
                $update['paket'] =  $data->paket;
            }else{
                // ketika koordinator
                $update['bank'] =  $data->bank;
                $update['nama_rekening'] =  $data->nama_rekening;
                $update['nomor_rekening'] =  $data->nomor_rekening;
            }


            if(!$this->isNullOrEmpty($data->koordinator)){
                $update['koordinator'] = $data->koordinator;
            }
            if(!$this->isNullOrEmpty($data->foto)){
                $nama_foto='ft'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
                $this->upload_foto($data->foto,public_path('/storage/foto'),$nama_foto);
                $update['foto'] = $nama_foto;
            }
            if(!$this->isNullOrEmpty($data->ktp)){
                $nama_foto='ktp'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
                $this->upload_foto($data->ktp,public_path('/storage/ktp'),$nama_foto);
                $update['ktp'] = $nama_foto;
            }

            $anggota=Anggota::find($data->id_anggota);

            $update_user=User::where('id_anggota',$data->id_anggota)->first();
            if($update_user){
                $update_user->update([
                    'name'  => $data->nama
                ]);
            }


            if(!$this->isNullOrEmpty($data->rfid)){
                // cek rfid
                if( Anggota::where('rfid',$data->rfid)->where('status','y')->whereNot('id_anggota',$anggota->id_anggota)->first() ){
                    return response()->json(['message' => 'Nomor RFID ini sudah terdaftar di anggota yang lain'], 404);
                }
            }

            // tidak bisa ganti paket kalau sudah setor uang
            if($anggota->jenis_akun == 'jamaah' && $anggota->paket != $data->paket && Setoran::where('id_anggota',$anggota->id_anggota)->first()){
                return response()->json(['message' => 'Perubahan paket tidak dapat dilakukan karena sudah terdapat data setoran uang pada paket ini'], 404);
            }

            if(!$anggota){
                return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
            }
            $anggota->update($update);

            DB::commit();
            return response()->json(['message' => 'Data berhasil diupdate']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

    }

    function ajax_get_jamaah() {
        if(in_array(Auth::user()->role,[1,5,8])){
            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->get();
        }elseif(Auth::user()->role == 2){

            $koordinator=User::select(
                    'koor.id as koordinator',
                    'koor.id_anggota as koordinator_data',
                )
                ->join('users as koor','koor.atasan','=','users.id')
                ->where('users.atasan',Auth::user()->id)
                ->get();

            $koordinator_data = $koordinator->pluck('koordinator_data')->toArray();
            $koordinator = $koordinator->pluck('koordinator')->toArray();

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where(function ($where) use($koordinator,$koordinator_data){
                    $where->whereIn('anggota.koordinator',$koordinator)
                        ->orWhereIn('anggota.id_anggota',$koordinator_data)
                        ;
                })
                // ->whereIn('koordinator',$koordinator)
                ->get();

        }elseif(Auth::user()->role == 3){

            $koordinator=User::select(
                    'users.id as koordinator',
                    'users.id_anggota as koordinator_data',
                )
                ->where('users.atasan',Auth::user()->id)
                ->get();

            $koordinator_data = $koordinator->pluck('koordinator_data')->toArray();
            $koordinator = $koordinator->pluck('koordinator')->toArray();

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where(function ($where) use($koordinator,$koordinator_data){
                    $where->whereIn('anggota.koordinator',$koordinator)
                        ->orWhereIn('anggota.id_anggota',$koordinator_data)
                        ;
                })
                // ->whereIn('koordinator',$koordinator)
                ->get();

        }elseif(Auth::user()->role == 4){

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where('koordinator',Auth::user()->id)
                ->get();

        }else{
            $anggota=[];
        }

        // encryp
        foreach ($anggota as $key) {
            $key->id_anggota_fix=Crypt::encryptString($key->id_anggota);
        }

        return response()->json($anggota);
    }

    function ajax_data_jamaah($id_anggota) {
        $id_anggota = Crypt::decryptString($id_anggota);
        $anggota=Anggota::find($id_anggota);
        if ($anggota) {
            return response()->json(['success' => true, 'data' => $anggota]);
        } else {
            return response()->json(['success' => false, 'message' => 'Data anggota tidak ditemukan.'], 404);
        }
    }

    function ajax_hapus_jamaah($id){
        $this->log_web('/hapus_anggota');


        $id = Crypt::decryptString($id);
        $anggota=Anggota::find($id);
        if($anggota){
            // id koordinator
            User::where('id_anggota',$id)->update(['status' => 'n']);

            $anggota->update(['status'=>'n']);
            return response()->json(['message' => 'User deleted successfully.']);
        }else{
            return response()->json(['message' => 'User not found.'], 404);
        }

    }

    function ajax_ubah_user($role,$id){
        if($role == 'hapus'){
            $this->log_web('/hapus_user');

            $user=User::find($id);
            if($user){
                // id koordinator
                Anggota::where('id_anggota',$user->id_anggota)->update(['status' => 'n']);

                $user->update(['hapus'=>'y']);

                return response()->json(['message' => 'Hapus data berhasil']);
            }else{
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }elseif($role == 'reset_pass'){
            $this->log_web('/reset_pass_user');

            $user=User::find($id);
            if($user){
                $user->update(['password'=>bcrypt('asd')]);
                return response()->json(['message' => 'Reset password berhasil']);
            }else{
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }elseif($role == 'aktifkan'){
            $this->log_web('/aktifkan_user');

            $user=User::where('id',$id)->where('status','n')->first();
            if($user){
                $user->update(['status'=>'y']);
                return response()->json(['message' => 'Status User Berhasil Diaktifkan']);
            }else{
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }elseif($role == 'nonaktifkan'){
            $this->log_web('/nonaktifkan_user');

            $user=User::where('id',$id)->where('status','y')->first();
            if($user){
                $user->update(['status'=>'n']);
                return response()->json(['message' => 'Status User Berhasil Dinonaktifkan']);
            }else{
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }else{
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_koordinator(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        // Query ke database, misalnya mencari nama yang mirip dengan keyword
        if(in_array(Auth::user()->role,[1,8,6])){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                    ->where('name', 'like', '%' . $search . '%')
                    ->where('status','y')
                    ->where('role',4)
                    ->get();

        }elseif(Auth::user()->role == 2){
            $data = User::select('users.id', 'users.name as text') // 'text' adalah format yang dibutuhkan Select2
                    ->join('users as leader','leader.id','=','users.atasan')
                    ->where('users.name', 'like', '%' . $search . '%')
                    ->where('users.status','y')
                    ->where('leader.atasan',Auth::user()->id)
                    ->where('users.role',4)
                    ->get();

        }elseif(Auth::user()->role == 3){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                    ->where('name', 'like', '%' . $search . '%')
                    ->where('status','y')
                    ->where('atasan',Auth::user()->id)
                    ->where('role',4)
                    ->get();
        }elseif(Auth::user()->role == 4){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                    ->where('name', 'like', '%' . $search . '%')
                    ->where('status','y')
                    ->where('atasan',Auth::user()->atasan)
                    ->where('role',4)
                    ->get();
        }else{
            $data=[];
        }

        // Mengembalikan data dalam format JSON
        return response()->json(['items' => $data]);

    }



    function ajax_get_leader(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        // Query ke database, misalnya mencari nama yang mirip dengan keyword
        if(Auth::user()->role == 1){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('name', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('role',3)
                ->get();

        }elseif(Auth::user()->role == 2){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('name', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('atasan',Auth::user()->id)
                ->where('role',3)
                ->get();

        }elseif(Auth::user()->role == 3){
            $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                    // ->where('name', 'like', '%' . $search . '%')
                    ->where('status','y')
                    ->where('id',Auth::user()->id)
                    ->where('role',3)
                    ->get();
        }elseif(Auth::user()->role == 4){
            $data=[];
        }else{
            $data=[];
        }

        // Mengembalikan data dalam format JSON
        return response()->json(['items' => $data]);

    }

    function ajax_get_top_leader(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        // Query ke database, misalnya mencari nama yang mirip dengan keyword
        $data = User::select('id', 'name as text') // 'text' adalah format yang dibutuhkan Select2
                ->where('name', 'like', '%' . $search . '%')
                ->where('status','y')
                ->where('role',2)
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

        // data chart
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

        // semua jamaah
        $jumlah_jamaah=Anggota::where('jenis_akun','jamaah')->where('status','y')->count();

        // ambil jamaah user
        if(Auth::user()->role == 1){
            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where('anggota.jenis_akun','jamaah')
                ->count();
        }elseif(Auth::user()->role == 2){

            $koordinator=User::select(
                    'koor.id as koordinator',
                    'koor.id_anggota as koordinator_data',
                )
                ->join('users as koor','koor.atasan','=','users.id')
                ->where('users.atasan',Auth::user()->id)
                ->get();

            $koordinator_data = $koordinator->pluck('koordinator_data')->toArray();
            $koordinator = $koordinator->pluck('koordinator')->toArray();

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where(function ($where) use($koordinator,$koordinator_data){
                    $where->whereIn('anggota.koordinator',$koordinator)
                        ->orWhereIn('anggota.id_anggota',$koordinator_data)
                        ;
                })
                ->where('anggota.jenis_akun','jamaah')
                // ->whereIn('koordinator',$koordinator)
                ->count();

        }elseif(Auth::user()->role == 3){

            $koordinator=User::select(
                    'users.id as koordinator',
                    'users.id_anggota as koordinator_data',
                )
                ->where('users.atasan',Auth::user()->id)
                ->get();

            $koordinator_data = $koordinator->pluck('koordinator_data')->toArray();
            $koordinator = $koordinator->pluck('koordinator')->toArray();

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where(function ($where) use($koordinator,$koordinator_data){
                    $where->whereIn('anggota.koordinator',$koordinator)
                        ->orWhereIn('anggota.id_anggota',$koordinator_data)
                        ;
                })
                ->where('anggota.jenis_akun','jamaah')
                // ->whereIn('koordinator',$koordinator)
                ->count();

        }elseif(Auth::user()->role == 4){

            $anggota=Anggota::select(
                    'anggota.*',
                    DB::raw("concat('".env('APP_URL')."','/storage/foto/',anggota.foto) as 'foto'"),
                    'users.email',
                )
                ->leftjoin('users','users.id_anggota','=','anggota.id_anggota')
                ->where('anggota.status','y')
                ->where('koordinator',Auth::user()->id)
                ->where('anggota.jenis_akun','jamaah')
                ->count();
        }else{
            $anggota=0;
        }

        // hitung semua pemasukan
        $total_pemasukan=0;
        $tabungan=Tabungan::select(DB::raw('sum(saldo) as total'))
            ->join('anggota','anggota.id_anggota','=','tabungan.id_anggota')
            ->where('anggota.status','y')
            ->first();
        if($tabungan){
            $total_pemasukan+=$tabungan->total;
        }
        $setoran=Setoran::select(DB::raw('sum(saldo) as total'))
            ->join('anggota','anggota.id_anggota','=','setoran.id_anggota')
            ->where('anggota.status','y')
            ->first();
        if($setoran){
            $total_pemasukan+=$setoran->total;
        }

        $data=[
            'chart' => $data,
            'jamaah_user'   => $anggota,
            'total_jamaah'   => $jumlah_jamaah,
            'total_pemasukan'   => $total_pemasukan,
        ];

        return response()->json($data);

    }

    function ajax_get_chart2() {

        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');
        $data_provinsi=DB::table('indonesia_provinces')
            ->get();
        // Loop untuk 4 bulan ke belakang
        $provinsi=[];

        $total_jamaah=Anggota::where('status','y')
            ->where('jenis_akun','jamaah')
            ->count();

        $total_koordinator=Anggota::where('status','y')
            ->where('jenis_akun','koordinator')
            ->count();

        foreach ($data_provinsi as $key) {
            $jamaah=Anggota::select(
                    DB::raw('count(*) as jumlah_jamaah')
                )
                ->where('provinsi',$key->id)
                ->where('status','y')
                ->where('jenis_akun','jamaah')
                ->first();
            if($jamaah->jumlah_jamaah > 0){
                $jumlah_jamaah[]=$jamaah->jumlah_jamaah;
                $provinsi[]=$key->name;
            }

            $koordinator=Anggota::select(
                    DB::raw('count(*) as jumlah_koordinator')
                )
                ->where('provinsi',$key->id)
                ->where('status','y')
                ->where('jenis_akun','koordinator')
                ->first();
            if($jamaah->jumlah_jamaah > 0){
                $jumlah_koordinator[]=$koordinator->jumlah_koordinator;
            }

            // echo $date->format('n') . ' - ' . $date->format('Y') . ' - ' . $date->translatedFormat('F') . PHP_EOL;

        }

        // data chart
        $data = [
            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'labels' => $provinsi,
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

        $data=[
            'chart' => $data,
        ];

        return response()->json($data);

    }

    function ajax_get_user() {
        if(Auth::user()->role == 1){
            $user=User::select(
                    'users.*',
                    // DB::raw("
                    //     CASE
                    //         WHEN `role` = 1 THEN 'ADMIN'
                    //         WHEN `role` = 2 THEN 'TOP LEADER'
                    //         WHEN `role` = 3 THEN 'LEADER'
                    //         WHEN `role` = 4 THEN 'ADMINISTRATOR'
                    //         ELSE 'UNKNOWN'
                    //     END AS `role`
                    // ")
                    'role.nama as role'
                )
                ->join('role','role.id','=','users.role')
                ->where('users.hapus','n')
                ->whereNot('users.id',Auth::user()->id)
                ->get();
        }elseif(Auth::user()->role == 2){
            $user=User::select(
                    '*',
                    DB::raw("
                        CASE
                            WHEN `role` = 1 THEN 'ADMIN'
                            WHEN `role` = 2 THEN 'TOP LEADER'
                            WHEN `role` = 3 THEN 'LEADER'
                            WHEN `role` = 4 THEN 'ADMINISTRATOR'
                            ELSE 'UNKNOWN'
                        END AS `role`
                    ")
                )
                ->where('hapus','n')
                ->where('atasan',Auth::user()->id)
                ->whereNot('users.id',Auth::user()->id)
                ->get();
        }else{
            $user=[];
        }

        return response()->json($user);
    }

    function ajax_tambah_tabungan(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'rfid'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            // $id_anggota=Crypt::decryptString($data->rfid);
            // $id_anggota=$data->rfid;
            $anggota=Anggota::where('rfid',$data->rfid)->where('status','y')->first();
            if(!$anggota){
                return response()->json(['message' => 'RFID belum terdaftar'], 404);
            }
            $id_anggota=$anggota->id_anggota;

            $this->log_web('/ajax_tambah_tabungan');

            $cek_tabungan=Tabungan::where('id_anggota',$id_anggota)->first();
            if(!$cek_tabungan){
                $cek_tabungan=Tabungan::create([
                    'id_anggota'    => $id_anggota,
                ]);
            }
            $log=Tabungan_log::create([
                'id_anggota'    => $id_anggota,
                'jenis'         => 'tabungan',
                'transaksi'     => 'masuk',
                'id_tabungan'   => $cek_tabungan->id_tabungan,
                'saldo'         => $data->jumlah,
                'saldo_total'   => $cek_tabungan->saldo + $data->jumlah,
            ]);

            $message='Berhasil tambah saldo sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total saldo kartu sebanyak '.$this->formatRupiah($cek_tabungan->saldo + $data->jumlah);
            $cek_tabungan->update([
                'saldo' =>$cek_tabungan->saldo + $data->jumlah
            ]);

            DB::commit();
            return response()->json(['message' => $message ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_tambah_setoran(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'rfid'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            // $id_anggota=Crypt::decryptString($data->rfid);
            // $id_anggota=$data->rfid;
            $anggota=Anggota::where('rfid',$data->rfid)->where('status','y')->first();
            if(!$anggota){
                return response()->json(['message' => 'RFID belum terdaftar'], 404);
            }
            $id_anggota=$anggota->id_anggota;

            $this->log_web('/ajax_tambah_setoran');

            $anggota=Anggota::find($id_anggota);

            $cek_paket=Daftar_paket::where('id_paket',$anggota->paket)->first();
            if(!$cek_paket){
                return response()->json(['message' => 'Anggota ini belum terdaftar paket apapun'], 404);
            }

            $cek_setoran=Setoran::where('id_anggota',$id_anggota)->orderBy('input_time','desc')->first();
            if($cek_setoran){
                // setoran ke 2 ++
                if( ($cek_setoran->saldo_total + $data->jumlah) > $cek_paket->harga ){
                    return response()->json(['message' => 'Jumlah uang berlebih, sisa tagihan paket sebesar'.$this->formatRupiah($cek_paket->harga - $cek_setoran->saldo_total) ], 404);
                }
                Setoran::create([
                    'id_anggota'    => $id_anggota,
                    'saldo'         => $data->jumlah,
                    'saldo_total'   => $cek_setoran->saldo_total + $data->jumlah,
                ]);

                $message='Berhasil setoran sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total tagihan tersisa sebanyak '.$this->formatRupiah($cek_paket->harga - ($cek_setoran->saldo_total + $data->jumlah) );
            }else{
                // setoran awal
                if( $data->jumlah > $cek_paket->harga ){
                    return response()->json(['message' => 'Jumlah uang berlebih, sisa tagihan paket sebesar'.$this->formatRupiah($cek_paket->harga) ], 404);
                }
                Setoran::create([
                    'id_anggota'    => $id_anggota,
                    'saldo'         => $data->jumlah,
                    'saldo_total'   => $data->jumlah,
                ]);
                $message='Berhasil setoran sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total tagihan tersisa sebanyak '.$this->formatRupiah($cek_paket->harga - $data->jumlah);
            }

            DB::commit();
            return response()->json(['message' => $message ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_tambah_hutang(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'rfid'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            // $id_anggota=Crypt::decryptString($data->rfid);
            // $id_anggota=$data->rfid;
            $anggota=Anggota::where('rfid',$data->rfid)->where('status','y')->first();
            if(!$anggota){
                return response()->json(['message' => 'RFID belum terdaftar'], 404);
            }
            $id_anggota=$anggota->id_anggota;

            $this->log_web('/ajax_tambah_hutang');

            $anggota=Anggota::find($id_anggota);

            $cek_hutang=Hutang::where('id_anggota',$id_anggota)->orderBy('input_time','desc')->first();
            if($cek_hutang){
                // hutang ke 2 ++
                Hutang::create([
                    'id_anggota'    => $id_anggota,
                    'saldo'         => $data->jumlah,
                    'saldo_total'   => $cek_hutang->saldo_total + $data->jumlah,
                ]);

                $message='Berhasil hutang sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total hutang sebanyak '.$this->formatRupiah($cek_hutang->saldo_total + $data->jumlah);
            }else{
                // hutang awal
                Hutang::create([
                    'id_anggota'    => $id_anggota,
                    'saldo'         => $data->jumlah,
                    'saldo_total'   => $data->jumlah,
                ]);
                $message='Berhasil hutang sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total hutang sebanyak '.$this->formatRupiah($data->jumlah);
            }

            DB::commit();
            return response()->json(['message' => $message ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_bayar_hutang(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'rfid'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            // $id_anggota=Crypt::decryptString($data->rfid);
            // $id_anggota=$data->rfid;
            $anggota=Anggota::where('rfid',$data->rfid)->where('status','y')->first();
            if(!$anggota){
                return response()->json(['message' => 'RFID belum terdaftar'], 404);
            }
            $id_anggota=$anggota->id_anggota;

            $this->log_web('/ajax_bayar_hutang');

            $anggota=Anggota::find($id_anggota);

            $cek_hutang=Hutang::where('id_anggota',$id_anggota)->orderBy('input_time','desc')->first();
            if($cek_hutang){
                if($cek_hutang->saldo_total < $data->jumlah){
                    return response()->json(['message' => 'Uang terlalu banyak, sisa hutang sebesar '.$this->formatRupiah($cek_hutang->saldo_total)], 404);
                }
                // hutang ke 2 ++
                Hutang::create([
                    'transaksi'    => 'bayar',
                    'id_anggota'    => $id_anggota,
                    'saldo'         => $data->jumlah,
                    'saldo_total'   => $cek_hutang->saldo_total - $data->jumlah,
                ]);

                $message='Berhasil bayar hutang sebanyak '.$this->formatRupiah($data->jumlah).', sehingga total hutang sebanyak '.$this->formatRupiah($cek_hutang->saldo_total - $data->jumlah);
            }else{
                return response()->json(['message' => 'Tidak ada data hutang yang ditemukan'], 404);
            }

            DB::commit();
            return response()->json(['message' => $message ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_uang_keluar(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'kategori'    => 'required',
            'bank'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_uang_keluar');

            Uang_keluar::create([
                'id_list'   => $data->kategori,
                'ket'   => $data->ket,
                'jumlah'   => $data->jumlah,
                'bank'   => $data->bank,
                'userid'   => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_uang_masuk(Request $data) {
        $cek_validator=$this->validator($data,[
            'jumlah'    => 'required',
            'kategori'    => 'required',
            'bank'    => 'required',
            // 'foto'    => 'required',
            // 'koordinator'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_uang_masuk');

            $insert=[
                'id_list'   => $data->kategori,
                'ket'   => $data->ket,
                'jumlah'   => $data->jumlah,
                'bank'   => $data->bank,
                'userid'   => Auth::user()->id,
            ];

            if(!$this->isNullOrEmpty($data->foto)){
                $nama_foto='um'.Auth::user()->id.strtotime(Carbon::now()).'.jpg';
                $this->upload_foto($data->foto,public_path('/storage/uang_masuk'),$nama_foto);
                $insert['foto']=$nama_foto;
            }
            if(!$this->isNullOrEmpty($data->koordinator)){
                $insert['koordinator']=$data->koordinator;

            }

            Uang_masuk::create($insert);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_uang_keluar() {

        $data=Uang_keluar::select(
                'uang_keluar.*',
                'uang_keluar_list.nama as kategori',
                'bank.nama_bank'
            )
            ->join('uang_keluar_list','uang_keluar_list.id_list','=','uang_keluar.id_list')
            ->leftJoin('bank','bank.id','=','uang_keluar.bank')
            ->get();

        return response()->json($data);
    }

    function ajax_get_uang_masuk() {

        $data=Uang_masuk::select(
                'uang_masuk.*',
                DB::raw("concat('".env('APP_URL')."','/storage/uang_masuk/',uang_masuk.foto) as 'foto'"),
                'users.name as nama_koordinator',
                'uang_masuk_list.nama as kategori',
                'bank.nama_bank'
            )
            ->join('uang_masuk_list','uang_masuk_list.id_list','=','uang_masuk.id_list')
            ->leftjoin('users','users.id','=','uang_masuk.koordinator')
            ->leftJoin('bank','bank.id','=','uang_masuk.bank')
            ->get();

        return response()->json($data);
    }

    function ajax_hapus_uang_keluar($id){
        $this->log_web('/hapus_uang_keluar');

        $data=Uang_keluar::find($id)->delete();
        if($data){
            return response()->json(['message' => 'Berhasil hapus data']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_hapus_uang_masuk($id){
        $this->log_web('/hapus_uang_masuk');

        $data=Uang_masuk::find($id)->delete();
        if($data){
            return response()->json(['message' => 'Berhasil hapus data']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_list_uang_masuk(Request $data) {
        $cek_validator=$this->validator($data,[
            'nama'    => 'required',
            // 'ket'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_list_uang_masuk');

            Uang_masuk_list::create([
                'nama'   => $data->nama,
                'ket'   => $data->ket,
                'userid'   => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_list_uang_keluar(Request $data) {
        $cek_validator=$this->validator($data,[
            'nama'    => 'required',
            // 'ket'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_list_uang_keluar');

            Uang_keluar_list::create([
                'nama'   => $data->nama,
                'ket'   => $data->ket,
                'userid'   => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_list_uang_masuk() {

        $data=Uang_masuk_list::all();

        return response()->json($data);
    }

    function ajax_get_list_uang_keluar() {

        $data=Uang_keluar_list::all();

        return response()->json($data);
    }

    function ajax_ubah_list_uang_masuk($action,$id){
        if($action == 'hapus'){
            if(Uang_masuk::where('id_list',$id)->first()){
                return response()->json(['message' => 'Gagal hapus data karena sudah pernah digunakan'], 404);
            }
            $data=Uang_masuk_list::find($id)->delete();
        }elseif($action == 'aktifkan'){
            $data=Uang_masuk_list::find($id)->update(['status'=>'y']);
        }elseif($action == 'nonaktifkan'){
            $data=Uang_masuk_list::find($id)->update(['status'=>'n']);
        }else{
            $data=false;
        }

        $this->log_web('/'.$action.'_list_uang_masuk');

        if($data){
            return response()->json(['message' => 'Berhasil '.$action.' data kategori']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_ubah_list_uang_keluar($action,$id){
        if($action == 'hapus'){
            if(Uang_keluar::where('id_list',$id)->first()){
                return response()->json(['message' => 'Gagal hapus data karena sudah pernah digunakan'], 404);
            }
            $data=Uang_keluar_list::find($id)->delete();
        }elseif($action == 'aktifkan'){
            $data=Uang_keluar_list::find($id)->update(['status'=>'y']);
        }elseif($action == 'nonaktifkan'){
            $data=Uang_keluar_list::find($id)->update(['status'=>'n']);
        }else{
            $data=false;
        }

        $this->log_web('/'.$action.'_list_uang_keluar');

        if($data){
            return response()->json(['message' => 'Berhasil '.$action.' data kategori']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_tambah_paket(Request $data) {
        $cek_validator=$this->validator($data,[
            'judul'    => 'required',
            'harga'    => 'required',
            // 'deskripsi'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_paket');

            Daftar_paket::create([
                'judul'   => $data->judul,
                'harga'   => $data->harga,
                'deskripsi'   => $data->deskripsi,
                'userid'   => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_paket() {

        $data=Daftar_paket::all();

        return response()->json($data);
    }

    function ajax_ubah_paket($action,$id){
        if($action == 'hapus'){
            if(Anggota::where('paket',$id)->first()){
                return response()->json(['message' => 'Tidak bisa dihapus karena paket telah didaftarkan ke anggota'], 404);
            }
            $data=Daftar_paket::find($id)->delete();
        }elseif($action == 'aktifkan'){
            $data=Daftar_paket::find($id)->update(['status'=>'y']);
        }elseif($action == 'nonaktifkan'){
            $data=Daftar_paket::find($id)->update(['status'=>'n']);
        }else{
            $data=false;
        }

        $this->log_web('/'.$action.'_paket');

        if($data){
            return response()->json(['message' => 'Berhasil '.$action.' data paket']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_edit_pass_user(Request $data){
        $cek_validator=$this->validator($data,[
            'pass_lama'    => 'required',
            'pass_baru'    => 'required',
            'pass_baru2'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/edit_pass_user');

            if ( !(Auth::attempt(['id' => Auth::user()->id, 'password' => $data->pass_lama]))) {
                return response()->json(['message' => 'Password yang lama salah'], 404);
            }

            if($data->pass_baru != $data->pass_baru2){
                return response()->json(['message' => 'Inputan password yang baru tidak sama'], 404);
            }

            if($data->pass_lama == $data->pass_baru){
                return response()->json(['message' => 'Password lama dan baru sama'], 404);
            }

            User::find(Auth::user()->id)->update(['password'=>bcrypt($data->pass_baru)]);

            DB::commit();
            return response()->json(['message' => 'Berhasil edit password']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }

    }

    function ajax_edit_user(Request $data){
        $cek_validator=$this->validator($data,[
            'id'    => 'required',
            'nama'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/edit_nama_user');

            $user=User::find($data->id);
            if(!$user){
                return response()->json(['message' => 'User tidak ditemukan'], 404);
            }
            $user->update(['name'=>$data->nama]);

            DB::commit();
            return response()->json(['message' => 'Edit berhasil']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }

    }

    function ajax_get_barang(Request $data) {

        // Ambil query dari parameter 'q' yang dikirim oleh Select2
        $search = $data->input('q');

        $barang=Barang::select(
                'id_barang as id',
                'nama as text',
            )
            ->where('nama','like','%'.$search.'%')
            ->get();

        // Mengembalikan data dalam format JSON
        return response()->json(['items' => $barang]);
    }

    function ajax_barang_masuk(Request $data) {
        $cek_validator=$this->validator($data,[
            'banyak'    => 'required',
            'barang'    => 'required',
            // 'ket'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/barang_masuk');

            // cek barang
            $barang=Barang::find($data->barang);
            if(!$barang){
                $barang=Barang::create([
                    'nama'  => $data->barang,
                    'stok'  => $data->banyak,
                    'userid'    => Auth::user()->id
                ]);

                Log_barang::create([
                    'id_barang'   => $barang->id_barang,
                    'banyak'   => $data->banyak,
                    'ket'   => $data->ket,
                    'userid'   => Auth::user()->id,
                ]);
            }else{
                Log_barang::create([
                    'id_barang'   => $barang->id_barang,
                    'banyak'   => $data->banyak,
                    'ket'   => $data->ket,
                    'userid'   => Auth::user()->id,
                ]);
                $barang->update([
                    'stok'  => $barang->stok + $data->banyak
                ]);

            }

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan barang masuk']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_barang_masuk() {

        $data=Log_barang::select(
                'barang.nama',
                'barang.stok',
                'log_barang.*'
            )
            ->join('barang','barang.id_barang','=','log_barang.id_barang')
            ->where('log_barang.jenis','masuk')
            ->get();

        return response()->json($data);
    }

    function ajax_hapus_barang_masuk($id){
        DB::beginTransaction();
        try {
            $this->log_web('/hapus_barang_masuk');

            $barang_masuk=Log_barang::find($id);
            if(!$barang_masuk){
                return response()->json(['message' => 'Gagal hapus data'], 404);
            }

            $barang=Barang::find($barang_masuk->id_barang);

            $barang->update([
                'stok'  => $barang->stok - $barang_masuk->banyak
            ]);

            $barang_masuk->delete();

            DB::commit();
            return response()->json(['message' => 'Berhasil hapus data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_barang_keluar(Request $data) {
        $cek_validator=$this->validator($data,[
            'banyak'    => 'required',
            'barang'    => 'required',
            // 'ket'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/barang_keluar');

            // cek barang
            $barang=Barang::find($data->barang);
            if($barang){
                if($barang->stok - $data->banyak < 0){
                    return response()->json(['message' => 'Stok barang hanya tersisa '.$barang->stok], 404);
                }

                Log_barang::create([
                    'id_barang'   => $barang->id_barang,
                    'banyak'   => $data->banyak,
                    'jenis'   => 'keluar',
                    'ket'   => $data->ket,
                    'userid'   => Auth::user()->id,
                ]);
                $barang->update([
                    'stok'  => $barang->stok - $data->banyak
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan barang keluar']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_get_barang_keluar() {

        $data=Log_barang::select(
                'barang.nama',
                'barang.stok',
                'log_barang.*'
            )
            ->join('barang','barang.id_barang','=','log_barang.id_barang')
            ->where('log_barang.jenis','keluar')
            ->get();

        return response()->json($data);
    }

    function ajax_hapus_barang_keluar($id){
        DB::beginTransaction();
        try {
            $this->log_web('/hapus_barang_keluar');

            $barang_masuk=Log_barang::find($id);
            if(!$barang_masuk){
                return response()->json(['message' => 'Gagal hapus data'], 404);
            }

            $barang=Barang::find($barang_masuk->id_barang);

            $barang->update([
                'stok'  => $barang->stok + $barang_masuk->banyak
            ]);

            $barang_masuk->delete();

            DB::commit();
            return response()->json(['message' => 'Berhasil hapus data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

    function ajax_get_bank() {

        $data=Bank::all();

        return response()->json($data);
    }

    function ajax_tambah_bank(Request $data) {
        $cek_validator=$this->validator($data,[
            'nama'    => 'required',
        ]);
        if(!empty($cek_validator)){
            return response()->json(['message' => $cek_validator], 404);
        }


        DB::beginTransaction();
        try {
            $this->log_web('/tambah_bank');

            Bank::create([
                'nama_bank'   => $data->nama,
                'userid'   => Auth::user()->id,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil menambahkan data']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Harap ulangi beberapa menit kemudian'], 404);
        }
    }

    function ajax_ubah_bank($action,$id){
        if($action == 'hapus'){
            if(Anggota::where('bank',$id)->first()){
                return response()->json(['message' => 'Tidak bisa dihapus karena bank telah didaftarkan ke anggota'], 404);
            }
            $data=Bank::find($id)->delete();
        }elseif($action == 'aktifkan'){
            $data=Bank::find($id)->update(['status'=>'y']);
        }elseif($action == 'nonaktifkan'){
            $data=Bank::find($id)->update(['status'=>'n']);
        }else{
            $data=false;
        }

        $this->log_web('/'.$action.'_bank');

        if($data){
            return response()->json(['message' => 'Berhasil '.$action.' data bank']);
        }else{
            return response()->json(['message' => 'Gagal hapus data'], 404);
        }
    }

}
