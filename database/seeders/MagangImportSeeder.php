<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\MagangApplication;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MagangImportSeeder extends Seeder
{
    public function run(): void
    {
        // Path file Excel
        $filePath = storage_path('app/public/DataMagang.xlsx');

        // Load file Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Skip header row
        $headerSkipped = false;

        foreach ($rows as $row) {
            if (!$headerSkipped) {
                $headerSkipped = true;
                continue;
            }

            // Ambil data dari Excel
            $name = $row['A'];
            $email = $row['B'];
            $password = $row['C'];
            $tgl_lahir = $this->formatTanggal($row['D']);
            $no_hp = $row['F'];
            $domisili = $row['G'];
            $jenjang_pendidikan = $row['H'];
            $instansi = $row['I'];
            $jurusan = $row['J'];
            $thn_masuk = $row['K'] ?? null;
            $semester = $row['L'] ?? null;
            $tanggal_mulai = $this->formatTanggal($row['M']);
            $tanggal_selesai = $this->formatTanggal($row['N']);
            $unit_penempatan = $row['O'];
            $durasi_magang = $row['P'];
            $alasan = $row['Q'] ?? null;
            $status = $row['R'] ?? 'waiting';

            DB::transaction(function () use (
                $name, $email, $password, $tgl_lahir, $no_hp, $domisili, $jenjang_pendidikan,
                $instansi, $jurusan, $thn_masuk, $semester, $tanggal_mulai, $tanggal_selesai,
                $unit_penempatan, $durasi_magang, $alasan, $status
            ) {
                // 1. Insert ke tabel users
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);

                // 2. Insert ke tabel user_profiles
                UserProfile::create([
                    'user_id' => $user->id,
                    'tgl_lahir' => $tgl_lahir,
                    'no_hp' => $no_hp,
                    'domisili' => $domisili,
                    'jenjang_pendidikan' => $jenjang_pendidikan,
                    'instansi' => $instansi,
                    'jurusan' => $jurusan,
                    'thn_masuk' => $thn_masuk ?? now()->year, // default tahun sekarang kalau null
                    'semester' => $semester ?? 1, // default semester 1 kalau null
                ]);

                // 3. Insert ke tabel magang_applications
                MagangApplication::create([
                    'user_id' => $user->id,
                    'tanggal_mulai_usulan' => $tanggal_mulai,
                    'tanggal_selesai_usulan' => $tanggal_selesai,
                    'unit_penempatan' => $unit_penempatan,
                    'durasi_magang' => $durasi_magang,
                    'alasan_pilih_telkom' => $alasan,
                    'status' => $status,
                ]);
            });
        }
    }

    // Fungsi untuk konversi tanggal dari Excel ke Y-m-d
    private function formatTanggal($value)
    {
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        if ($value) {
            return date('Y-m-d', strtotime($value));
        }
        return null;
    }
}
