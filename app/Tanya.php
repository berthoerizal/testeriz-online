<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanya extends Model
{
    //url_video
    protected $fillable = ['id_soal', 'pertanyaan', 'gambar', 'jawaban', 'pilihan1', 'pilihan2', 'pilihan3', 'pilihan4', 'pilihan_benar', 'url_video'];
}
