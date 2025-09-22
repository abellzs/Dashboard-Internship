<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PesertaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $users = User::with('profile')->get();

        return $users->map(function ($user) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'nim' => $user->nim,
                'tgl_lahir' => $user->profile->tgl_lahir ?? '',
                'no_hp' => $user->profile->no_hp ?? '',
                'domisili' => $user->profile->domisili ?? '',
                'jenjang_pendidikan' => $user->profile->jenjang_pendidikan ?? '',
                'instansi' => $user->profile->instansi ?? '',
                'jurusan' => $user->profile->jurusan ?? '',
                'thn_masuk' => $user->profile->thn_masuk ?? '',
                'semester' => $user->profile->semester ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'NIM',
            'Tanggal Lahir',
            'No HP',
            'Domisili',
            'Jenjang Pendidikan',
            'Instansi',
            'Jurusan',
            'Tahun Masuk',
            'Semester',
        ];
    }
}
