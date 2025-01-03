<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
}
