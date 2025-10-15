<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Selesai Praktik Kerja Lapangan</title>
    <style>
        @page {
            margin: 20mm 10mm;
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

        table {
            border-collapse: collapse;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .content-section {
            margin-bottom: 15px;
            text-align: justify;
        }

        .signature-section {
            margin-top: 30px;
        }

        .data-table {
            width: 100%;
            margin: 15px 0;
            font-size: 11pt;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .data-table th {
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
            <p style="margin: 0;">Nomor : <?php echo isset($certificate) ? $certificate->nomor_dinas_keluar : '-'; ?></p>
            <p style="margin: 5px 0 0 0; text-align: right;">
                Yogyakarta,
                <?php
                if (isset($certificate->updated_at)) {
                    $formatter = new IntlDateFormatter(
                        'id_ID',
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE
                    );
                    echo $formatter->format($certificate->updated_at);
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
                    <td style="vertical-align: top; padding: 2px 0;">-</td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding: 2px 0;">Perihal</td>
                    <td style="vertical-align: top; padding: 2px 0;">:</td>
                    <td style="vertical-align: top; padding: 2px 0;"><strong>Surat Keterangan Selesai Praktik Kerja Lapangan PT Telkom Witel Yogya Jateng Selatan</strong></td>
                </tr>
            </table>
        </div>

        <!-- Isi Surat -->
        <div class="content-section">
            <p style="margin: 0 0 15px 0;">
                Merujuk surat Saudara perihal Permohonan Praktik Kerja Lapangan di PT Telkom Witel Yogya Jateng Selatan, bagi siswa dengan nama berikut.
            </p>

            <!-- Tabel Data Mahasiswa -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 12%;">NIM</th>
                        <th style="width: 10%;">Program Studi</th>
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
                        <td style="text-align: center;">
                            <?php echo isset($magang->unit_penempatan) ? $magang->unit_penempatan : '-'; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo isset($pembimbing) ? $pembimbing : '-'; ?>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="margin: 15px 0;">
                Bahwa yang bersangkutan telah selesai melaksanakan Praktik Kerja Lapangan di PT Telkom Witel Yogya Jateng Selatan.
            </p>

            <p style="margin: 15px 0;">
                Selama pelaksanaan Praktik Kerja Lapangan yang bersangkutan melaksanakan Praktik Kerja Lapangan dengan baik, sangat memperhatikan peraturan yang kami terapkan dan setelah selesai, ybs. masih menjalin hubungan baik dengan pihak PT Telkom Witel Yogya Jateng Selatan tanpa ada masalah yang tidak terselesaikan.
            </p>

            <p style="margin: 15px 0;">
                Demikian kami sampaikan, dan terima kasih atas kerjasamanya.
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
</body>

</html>