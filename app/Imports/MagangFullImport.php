<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\MagangApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class MagangFullImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {

            // 1. Insert ke users
            $user = User::create([
                'name'     => $row['name'],
                'email'    => $row['email'],
                'password' => Hash::make($row['password']),
            ]);

            // 2. Insert ke user_profiles
            UserProfile::create([
                'user_id'            => $user->id,
                'instansi_id'        => $row['instansi_id'] ?? null,
                'tgl_lahir'          => $this->transformDate($row['tgl_lahir']),
                'no_hp'              => $row['no_hp'],
                'domisili'           => $row['domisili'],
                'jenjang_pendidikan' => $row['jenjang_pendidikan'],
                'instansi'           => $row['instansi'],
                'jurusan'            => $row['jurusan'],
                'thn_masuk'          => $row['thn_masuk'],
                'semester'           => $row['semester'] ?? null,
            ]);

            // 3. Insert ke magang_applications
            MagangApplication::create([
                'user_id'              => $user->id,
                'tanggal_mulai_usulan' => $this->transformDate($row['tanggal_mulai_usulan']),
                'tanggal_selesai_usulan'=> $this->transformDate($row['tanggal_selesai_usulan']),
                'unit_penempatan'      => $row['unit_penempatan'],
                'durasi_magang'        => $row['durasi_magang'],
                'alasan_pilih_telkom'  => $row['alasan_pilih_telkom'] ?? null,
                'bersedia'             => $row['bersedia'] ?? null,
                'status'               => $row['status'] ?? 'waiting',
                'approved_by'          => $row['approved_by'] ?? null,
                'approved_at'          => $row['approved_at'] ?? null,
            ]);

            return $user;
        });
    }

    private function transformDate($value, $format = 'Y-m-d')
    {
        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)->format($format);
            }
            return Carbon::parse($value)->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}
