<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


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
