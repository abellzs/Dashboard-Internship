<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ganti dari Model
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\magangApplication;
use App\Models\UserProfile;
use App\Models\MagangDocument;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nim',
        'nim_magang',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function approvals()
    {
        return $this->hasMany(MagangApplication::class, 'approved_by');
    }

    public function magangDocument()
    {
        return $this->hasOne(MagangDocument::class);
    }

    public function initials()
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        return $initials;
    }

    public function registrasi()
    {
        return $this->hasOne(Registrasi::class);
    }

    public function magangApplication()
    {
        return $this->hasMany(MagangApplication::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHc(): bool
    {
        return $this->role === 'hc';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan akses panel admin untuk user dengan role admin atau hc
        if ($panel->getId() === 'admin') {
            return $this->isAdmin();
        }

        // Untuk panel lainnya, izinkan semua user yang sudah login
        return true;
    }

}
