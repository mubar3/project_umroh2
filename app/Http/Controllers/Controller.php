<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar_paket;
use Validator;

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
}
