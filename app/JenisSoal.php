<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSoal extends Model
{
    use HasFactory;
    protected $table = 'jenis_soal';
    protected $fillable = ['nama_jenis_soal'];
}
