<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model {
    protected $fillable = [
        'nama_unit',
        'deskripsi',
        'major',
        'ketersediaan',
        'lokasi',
        'durasi',
    ];
}

