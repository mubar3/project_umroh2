<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uang_keluar extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'uang_keluar';
    protected $primaryKey = 'id';
}
