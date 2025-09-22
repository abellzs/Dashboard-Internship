<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InstansiSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Instansi::truncate();
        DB::statement('ALTER TABLE instansis AUTO_INCREMENT = 1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $instansis = [
            'ASMI Santa Maria Yogyakarta',
            'Institut Telknologi Telkom Purwokerto',
            'Institut Seni Indonesia',
            'Institut Teknologi Sepuluh Nopember',
            'STIA "AAN" Notokusumo Yogyakarta',
            'STIE Widya Wiwaha Yogyakarta',
            'STIM YKPN Yogyakarta',
            'STMIK AKAKOM Yogyakarta',
            'UIN Sunan Kalijaga Yogyakarta',
            'Uniersitas Muhammadiyah Yogyakarta',
            'Universitas Ahmad Dahlan',
            'Universitas Amikom Yogyakarta',
            'Universitas Atma Jaya Yogyakarta',
            'Universitas Diponegoro',
            'Universitas Gadjah Mada',
            'Universitas Islam Indonesia',
            'Universitas Janabadra',
            'Universitas Kristen Duta Wacana',
            'Universitas Negeri Yogyakarta',
            'Universitas Pembangunan Nasional "Veteran" Yogyakarta',
            'Universitas Widya Mataram Yogyakarta',
            'Universitas Sanata Dharma',
            'Universitas Sebelas Maret Surakarta',
            'Universitas Teknologi Yogyakarta',
            'Sekolah Tinggi Multi Media "MMTC" Yogyakarta',
            'Institut Teknologi Nasional Bandung',
            'Universitas Alma Ata Yogyakarta',
            'Universitas Jenderal Achmad Yani',
            'Universitas Mercu Buana Yogyakarta',
            'Universitas Teknologi Digital Indonesia',
        ];

        foreach ($instansis as $nama) {
            Instansi::create([
                'nama' => $nama,
                'jenjang' => 'Sarjana',
            ]);
        }

        $this->command->info('Data instansi berhasil disimpan ke tabel instansis.');
    }
}