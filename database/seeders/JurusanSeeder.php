<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Jurusan::truncate();
        DB::statement('ALTER TABLE instansis AUTO_INCREMENT = 1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['name' => 'Administrasi Bisnis'],
            ['name' => 'Administrasi Perkantoran'],
            ['name' => 'Akuntansi'],
            ['name' => 'Ilmu Ekonomi'],
            ['name' => 'Manajemen Sumber Daya Manusia'],
            ['name' => 'Manajemen Pemasaran'],
            ['name' => 'Manajemen Keuangan'],
            ['name' => 'Ekonomi Pembangunan'],
            ['name' => 'Hubungan Internasional'],
            ['name' => 'Ilmu Administrasi Bisnis'],
            ['name' => 'Informatika/Komputer'],
            ['name' => 'Ilmu Komunikasi'],
            ['name' => 'Elektro'],
            ['name' => 'Psikologi'],
            ['name' => 'Sistem Informasi'],
            ['name' => 'Statistika'],
            ['name' => 'Teknik Industri'],
            ['name' => 'Telekomunikasi'],
        ];

        foreach ($data as $item) {
            Jurusan::create($item);
        }
    }
}
