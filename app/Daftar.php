<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    protected $fillable = ['id_soal', 'id_user', 'status_daftar'];
    // ket: 
    // 1 = Daftar
    // 0 = Belum Daftar
}
