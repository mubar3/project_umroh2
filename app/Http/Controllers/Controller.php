<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar_paket;
use Validator;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function index() {
        $daftar_paket=Daftar_paket::select(
                '*',
                DB::raw("CONCAT('Rp ', FORMAT(harga, 0, 'de_DE')) as harga"),
            )
            ->where('status','y')
            ->get();

        return view('landing_page')->with([
            'daftar_paket'   => $daftar_paket,
        ]);
    }

    public function isNullOrEmpty($variable) {
        return ( !isset($variable) || $variable === null || $variable === '' || $variable === 'null');
    }


    public function validator($data,$validator)
    {
        $pesan=[];
        foreach ($validator as $key => $value) {
            $validator = Validator::make($data->all(),[
                $key => $value,
            ]);
            if($validator->fails() || $data->$key == "null"){
                array_push($pesan,ucfirst(str_replace('_', ' ', $key)));
            }
        }
        if(count($pesan) > 0){
            return implode(', ',$pesan).' Kosong';
        }else{
            return '';
        }
    }

    public function provinces()
    {
        return \Indonesia::allProvinces();
    }

    public function cities(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }

    public function upload_foto($foto,$lokasi,$namafile) {
        // Buat instance gambar dari file
        $image = Image::read($foto);

        // Kompres gambar (menyesuaikan ukuran dan kualitas)
        $image->scale(width: 300);

        return $image->save($lokasi.'/'.$namafile);
    }

}
