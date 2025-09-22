<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagangApplication extends Model
{
    protected $fillable = [
        'user_id', 
        'tanggal_mulai_usulan', 
        'tanggal_selesai_usulan',
        'unit_penempatan', 
        'durasi_magang', 
        'alasan_pilih_telkom',
        'status', 
        'approved_by', 
        'approved_at',
        'bersedia'
    ];

    protected $casts = [
        'tanggal_mulai_usulan' => 'datetime',
        'tanggal_selesai_usulan' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // public function magangDocument()
    // {
    //     return $this->hasOne(MagangDocument::class, 'user_id', 'user_id');
    // }

    public function toggleFlag($id)
    {
        $peserta = MagangApplication::findOrFail($id);
        $peserta->is_flagged = !$peserta->is_flagged;
        $peserta->save();
    }

    public function document()
    {
        return $this->hasOne(MagangDocument::class, 'application_id', 'id');
    }


}
