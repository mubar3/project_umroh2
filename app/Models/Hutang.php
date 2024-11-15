<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'hutang';
    protected $primaryKey = 'id_hutang';
}
