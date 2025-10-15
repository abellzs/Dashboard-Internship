<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    protected $table = 'certificates';

    protected $fillable = [
        'user_id',
        'magang_application_id',
        'nomor_dinas_masuk',
        'nomor_dinas_keluar',
    ];
}
