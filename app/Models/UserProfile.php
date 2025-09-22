<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'tgl_lahir', 'no_hp', 'domisili', 'jenjang_pendidikan',
        'instansi', 'jurusan', 'thn_masuk', 'semester',
        'alasan_pilih_telkom', 'bersedia_ditempatkan', 'jenis_kelamin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
