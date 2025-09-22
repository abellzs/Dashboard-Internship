<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagangDocument extends Model
{
    protected $fillable = [
        'user_id',
        'application_id',
        'cv_path',
        'surat_permohonan_path',
        'proposal_path',
        'foto_diri_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function magangApplication()
    {
        return $this->belongsTo(MagangApplication::class, 'application_id');
    }

    public function application()
    {
        return $this->belongsTo(MagangApplication::class, 'application_id', 'id');
    }


}
