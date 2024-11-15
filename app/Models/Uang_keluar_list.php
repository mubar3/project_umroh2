<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uang_keluar_list extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'uang_keluar_list';
    protected $primaryKey = 'id_list';
}
