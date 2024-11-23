<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_barang extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $guarded = [];
    protected $table = 'log_barang';
    protected $primaryKey = 'id';
}
