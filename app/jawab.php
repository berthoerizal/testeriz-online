<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jawab extends Model
{
    protected $fillable = ['id_user', 'id_soal', 'id_tanya', 'jawaban_benar', 'jawaban_user', 'status_jawab'];
}
