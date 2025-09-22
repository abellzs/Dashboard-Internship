<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lowongan;

class LowonganSeeder extends Seeder {
    public function run(): void {
        Lowongan::truncate();
        
        Lowongan::create([
            'nama_unit' => 'Human Capital',
            'deskripsi' => 'Bertanggung jawab dalam pengelolaan administrasi anak magang, termasuk pencatatan data, monitoring absensi, dan pengarsipan dokumen terkait sumber daya manusia.',
            'major' => 'Manajemen, Psikologi',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 3,
        ]);

        Lowongan::create([
            'nama_unit' => 'Sekretaris',
            'deskripsi' => 'Mengelola administrasi perkantoran, seperti surat masuk dan keluar, dokumentasi kegiatan pimpinan dan perusahaan, persiapan rapat, serta pembuatan berita acara kegiatan pimpinan.',
            'major' => 'Administrasi Publik, Administrasi Perkantoran, Manajemen, Administrasi Bisnis',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 4,
        ]);

        Lowongan::create([
            'nama_unit' => 'Asset & Facility',
            'deskripsi' => 'Membuat dokumen perjanjian kerja sama terkait sewa lahan, melakukan survei lokasi untuk perangkat ODC Telkom, serta menyusun dokumen pertanggungjawaban dana kegiatan internal Witel.',
            'major' => 'Ilmu Komunikasi, Teknik Informatika',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 3,
        ]);

        Lowongan::create([
            'nama_unit' => 'Financial Collection',
            'deskripsi' => 'Melakukan pengarsipan dokumen keuangan, verifikasi dokumen, pencatatan jurnal, serta mendukung proses penagihan (billing collection).',
            'major' => 'Akuntansi, Manajemen, Keuangan',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 3,
        ]);

        Lowongan::create([
            'nama_unit' => 'Business Service',
            'deskripsi' => 'Bertugas dalam bidang digital marketing, administrasi, dan telemarketing. Kegiatan meliputi pembuatan konten media sosial Indibiz dan pemetaan pasar (market mapping).',
            'major' => 'Manajemen, Ilmu Komunikasi, Ilmu Ekonomi, Desain Komunikasi Visual, Administrasi Bisnis, Marketing',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'Government Service',
            'deskripsi' => 'Melakukan pengecekan dokumen, survei, peninjauan kontrak, serta seluruh proses administrasi yang berkaitan dengan kerja sama pemerintah.',
            'major' => 'Manajemen, Ilmu Komunikasi, Ilmu Ekonomi, Desain Komunikasi Visual, Administrasi Bisnis, Administrasi Perkantoran, Teknik Industri, Hukum, Marketing',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'Enterprise Service',
            'deskripsi' => 'Menangani kegiatan administrasi, pemantauan jaringan melalui Network Monitoring System (NMS), serta melakukan pembaruan data dan proses order layanan.',
            'major' => 'Manajemen, Hukum, Administrasi Bisnis, Administrasi Perkantoran, Teknik Industri, Ilmu Komunikasi',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'Performance, Risk & QOS (PRQ)',
            'deskripsi' => 'Bertugas dalam pengolahan dan analisis data menggunakan Microsoft Excel untuk mendukung laporan performa dan penilaian risiko.',
            'major' => 'Ilmu Komunikasi, Statistika, Hukum',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'BGES & MBB Service Operation',
            'deskripsi' => 'Berkaitan dengan pengelolaan akses jaringan dan layanan. Jobdesk mencakup tugas lapangan, input data, kegiatan pemasaran, dan manajemen operasional.',
            'major' => 'Manajemen, Ilmu Komputer',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Yogyakarta',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'HOTD (Head of Telkom Daerah Bantul)',
            'deskripsi' => 'Menangani tugas administrasi dan marketing, seperti pemetaan pelanggan, telemarketing, kunjungan pelanggan (visitasi), survei lapangan, dan penyusunan berita acara.',
            'major' => 'Manajemen, Statistika, Marketing, Teknik',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Bantul',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'HOTD (Head of Telkom Daerah Gunung Kidul)',
            'deskripsi' => 'Menangani tugas administrasi dan marketing, seperti pemetaan pelanggan, telemarketing, kunjungan pelanggan (visitasi), survei lapangan, dan penyusunan berita acara.',
            'major' => 'Manajemen, Statistika, Marketing, Teknik',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Gunung Kidul',
            'durasi' => 2,
        ]);

        Lowongan::create([
            'nama_unit' => 'HOTD (Head of Telkom Daerah Sleman)',
            'deskripsi' => 'Menangani tugas administrasi dan marketing, seperti pemetaan pelanggan, telemarketing, kunjungan pelanggan (visitasi), survei lapangan, dan penyusunan berita acara.',
            'major' => 'Manajemen, Statistika, Marketing, Teknik',
            'ketersediaan' => 'Tersedia',
            'lokasi' => 'Sleman',
            'durasi' => 2,
        ]);
    }
}
