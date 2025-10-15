<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Persetujuan Kerja Praktik</title>
    <style>
        @page {
            margin: 20mm 15mm;
            size: A4;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.15;
        }

        .container {
            width: 100%;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
        }

        .header-section {
            margin-bottom: 15px;
        }

        .content-section {
            margin-bottom: 15px;
            text-align: justify;
        }

        .signature-section {
            margin-top: 30px;
        }

        .lampiran-table {
            width: 100%;
            margin-top: 20px;
        }

        .lampiran-table th,
        .lampiran-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .lampiran-table th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header-section">
            <p style="margin: 0;">Nomor : <?php echo isset($certificate->nomor_dinas_masuk) ? $certificate->nomor_dinas_masuk : '-'; ?></p>
            <p style="margin: 5px 0 0 0; text-align: right;">
                Yogyakarta,
                <?php
                if (isset($certificate->created_at)) {
                    $formatter = new IntlDateFormatter(
                        'id_ID', // Locale untuk bahasa Indonesia
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE
                    );
                    echo $formatter->format($certificate->created_at);
                } else {
                    echo '-';
                }
                ?>
            </p>
        </div>

        <!-- Kepada -->
        <div class="header-section">
            <p style="margin: 0;">Kepada Yth.</p>
            <p style="margin: 5px 0 0 0; font-weight: bold; max-width: 260px; word-wrap: break-word;"><?php echo isset($receiver) ? nl2br(htmlspecialchars($receiver)) : ''; ?></p>
        </div>

        <!-- Lampiran dan Perihal -->
        <div class="header-section">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 80px; vertical-align: top; padding: 2px 0;">Lampiran</td>
                    <td style="width: 20px; vertical-align: top; padding: 2px 0;">:</td>
                    <td style="vertical-align: top; padding: 2px 0;">1 Lembar</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 2px 0;">Perihal</td>
                    <td style="vertical-align: top; padding: 2px 0;">:</td>
                    <td style="vertical-align: top; padding: 2px 0;"><strong>Surat Persetujuan Kerja Praktik PT. Telkom Witel Yogya Jateng Selatan</strong></td>
                </tr>
            </table>
        </div>

        <!-- Isi Surat -->
        <div class="content-section">
            <p style="margin: 0 0 15px 0;">
                Merujuk surat Saudara/i perihal Surat Permohonan Kerja Praktik. Dengan ini kami beritahukan bahwa kami tidak keberatan atas permohonan Saudara/i tentang Permohonan izin yang dimaksud di PT. Telkom Witel Yogya Jateng Selatan, bagi mahasiswa/i atas nama <?php echo isset($magang->user->name) ? $magang->user->name : '-'; ?>.
            </p>

            <p style="margin: 0 0 10px 0;">
                Kepada mahasiswa/i tersebut diwajibkan untuk mengikuti dan melaksanakan tata tertib yang berlaku sebagai berikut :
            </p>

            <!-- Daftar Tata Tertib -->
            <div style="margin-bottom: 15px;">
                <p style="margin:0;">1. Jam kerja praktik mahasiswa yaitu Senin s/d Jum'at jam 08.00 s/d 17.00 WIB.</p>
                <p style="margin:0;">2. Pakaian hari Senin memakai baju putih & bawahan gelap, Selasa s/d Kamis pakaian sopan & rapi, dan Jum'at memakai baju batik serta memakai sepatu tertutup.</p>
                <p style="margin:0;">3. Harus menggunakan produk Telkomsel.</p>
                <p style="margin:0;">4. Menyerahkan satu set laporan kerja praktik (file pdf).</p>
                <p style="margin:0;">5. Wajib mengikuti periode PKL/Kerja Praktik sesuai dengan kesepakatan, apabila mengundurkan diri sebelum periode berakhir maka tidak akan mendapatkan sertifikat.</p>
                <p style="margin:0;">6. Wajib melakukan presentasi akhir sebagai syarat untuk mendapatkan sertifikat.</p>
                <p style="margin:0;">7. Tidak menyebarluaskan hasil penelitian / laporan kerja kepada pihak lain.</p>
                <p style="margin:0;">8. Menandatangani surat pernyataan di atas materai Rp.10.000,-.</p>
                <p style="margin:0;">9. Menyerahkan 1 (satu) lembar pas foto berwarna terbaru ukuran 3 X 4 cm.</p>
                <p style="margin:0;">10. Tidak menggunakan fasilitas/sarana TELKOM (telepon,fotocopy, dan komputer) untuk kepentingan pribadi.</p>
                <p style="margin:0;">11. Mentaati peraturan yang berhubungan dengan K3 (Kesehatan dan Keselamatan Kerja).</p>
                <p style="margin:0;">12. Tidak mendapat bantuan uang makan/transport, honor selama melaksanakan program praktik/magang/riset.</p>
                <p style="margin:0;">13. Membawa laptop sendiri dan tidak diperkenankan bermain game selama jam kerja.</p>
                <p style="margin:0;">14. Mengembalikan tanda pengenal ke HC TELKOM WITEL YOGYA JATENG SELATAN Jl. Yos Sudarso No. 09, YK.</p>
            </div>

            <p style="margin: 15px 0 10px 0;">
                Demikian pemberitahuan kami, atas perhatian Saudara kami ucapkan terimakasih.
            </p>
        </div>

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <p style="margin: 0;">Hormat Kami</p>
            <img src="<?php echo public_path('images/ttd-mba-rama-2.png'); ?>" alt="Tanda Tangan" style="width: 120px; height: auto;">
            <div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">Rama Kumala Sari</p>
                <p style="margin: 5px 0 0 0; font-size: 11pt;">MGR SHARED SERVICE & GENERAL SUPPORT YOGYA JATENG SELATAN</p>
            </div>
        </div>

        <!-- Tembusan -->
        <div style="margin-top: 20px;">
            <p style="margin: 0;">Tembusan</p>
            <p style="margin: 5px 0 0 0;">-</p>
        </div>

    </div>

    <!-- Halaman 2 - Lampiran -->
    <div class="container">

        <h3 style="text-align: center; font-size: 13pt; margin: 0 0 20px 0; font-weight: bold;">
            Daftar Peserta Kerja Praktik PT Telkom Witel Yogya Jateng Selatan<br>Periode
            <?php
            if (isset($certificate->created_at)) {
                $formatter = new IntlDateFormatter(
                    'id_ID',
                    IntlDateFormatter::LONG,
                    IntlDateFormatter::NONE
                );
                // Format hanya bulan dan tahun
                $date = new DateTime($certificate->created_at);
                $bulanTahun = $formatter->format($date);
                // Ambil hanya bulan dan tahun (hapus tanggal)
                $bulanTahun = preg_replace('/^\d+\s/', '', $bulanTahun);
                echo $bulanTahun;
            } else {
                echo '-';
            }
            ?>
        </h3>

        <!-- Tabel Data Mahasiswa -->
        <table class="lampiran-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 20%;">Nama</th>
                    <th style="width: 12%;">NIM</th>
                    <th style="width: 10%;">Jurusan</th>
                    <th style="width: 18%;">Periode Kerja Praktik</th>
                    <th style="width: 15%;">Unit</th>
                    <th style="width: 20%;">Pembimbing</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: center;">1.</td>
                    <td><?php echo isset($magang->user->name) ? $magang->user->name : '-'; ?></td>
                    <td style="text-align: center;"><?php echo isset($magang->user->nim_magang) ? $magang->user->nim_magang : '-'; ?></td>
                    <td style="text-align: center;"><?php echo isset($userProfile->jurusan) ? $userProfile->jurusan : '-'; ?></td>
                    <td style="text-align: center;">
                        <?php
                        if (isset($magang->tanggal_mulai_usulan) && isset($magang->tanggal_selesai_usulan)) {
                            // Format tanggal mulai: tanggal bulan (misal: 12 Juni)
                            $mulai = new DateTime($magang->tanggal_mulai_usulan);
                            $formatterMulai = new IntlDateFormatter(
                                'id_ID',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::NONE
                            );
                            $tglMulai = $mulai->format('j') . ' ' . $formatterMulai->getPattern();
                            // Ambil nama bulan dari IntlDateFormatter
                            $tglMulai = $formatterMulai->format($mulai);
                            // Hapus tahun dari hasil format
                            $tglMulai = preg_replace('/\s+\d{4}$/', '', $tglMulai);

                            // Format tanggal selesai: tanggal bulan tahun (misal: 15 September 2025)
                            $selesai = new DateTime($magang->tanggal_selesai_usulan);
                            $formatterSelesai = new IntlDateFormatter(
                                'id_ID',
                                IntlDateFormatter::LONG,
                                IntlDateFormatter::NONE
                            );
                            $tglSelesai = $formatterSelesai->format($selesai);

                            echo $tglMulai . ' s.d. ' . $tglSelesai;
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <td style="text-align: center;"><?php echo isset($magang->unit_penempatan) ? $magang->unit_penempatan : '-'; ?></td>
                    <td style="text-align: center;"><?php echo isset($pembimbing) ? $pembimbing : '-'; ?></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>

</html>