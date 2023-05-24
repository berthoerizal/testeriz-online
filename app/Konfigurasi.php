<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konfigurasi extends Model
{
    protected $fillable = ['author', 'namaweb', 'email', 'desc1', 'desc2', 'keywords'];
}
