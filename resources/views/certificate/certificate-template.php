<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat Telkom Indonesia</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
            background-color: #e5e7eb;
            align-items: center;
        }

        .certif-container {
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            background-image: url('<?php echo public_path('images/certif_bg.png'); ?>');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            align-items: center;
        }

        .certif-content {
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            overflow: hidden;
        }

        .certif-header {
            margin-bottom: 24px;
            margin-top: 120px;
        }

        .certif-title {
            font-style: italic;
            margin-bottom: 16px;
            font-size: 70px;
            font-family: 'Times New Roman', Times, serif;
            line-height: 1;
        }

        .certif-number {
            font-size: 20px;
            font-family: 'Times New Roman', Times, serif;
        }

        .certif-body {
            margin-bottom: 32px;
        }

        .certif-label {
            font-size: 14px;
            font-family: 'Times New Roman', Times, serif;
            margin-bottom: 8px;
        }

        .certif-name {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .certif-description {
            font-size: 18px;
            max-width: 768px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.5;
        }

        .certif-footer {
            margin-left: 8px;
            margin-right: 8px;
        }

        .certif-date {
            font-size: 18px;
            margin-bottom: 16px;
        }

        .certif-position-1 {
            margin-top: 16px;
            font-weight: bold;
            font-size: 18px;
            font-family: 'Times New Roman', Times, serif;
        }

        .certif-position-2 {
            font-size: 18px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }

        .certif-signature {
            width: 160px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .certif-name-sign {
            text-decoration: underline;
            font-weight: bold;
            font-size: 18px;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .certif-nik {
            font-size: 18px;
            font-weight: 600;
        }

        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .certif-container {
                margin: 0 auto !important;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>

<body>
    <div class="certif-container">
        <div class="certif-content">
            <!-- Judul Sertifikat -->
            <div class="certif-header">
                <h1 class="certif-title">Sertifikat</h1>
                <p class="certif-number">Nomor: <?php echo isset($certificate->nomor_dinas_keluar) ? $certificate->nomor_dinas_keluar : 'Not Available'; ?></p>
            </div>

            <!-- Isi Sertifikat -->
            <div class="certif-body">
                <p class="certif-label">Diberikan Kepada:</p>
                <h2 class="certif-name">
                    <?php echo strtoupper(isset($magang->user->name) ? $magang->user->name : 'Not Available'); ?>
                </h2>
                <p class="certif-description">
                    Atas peran serta dalam pelaksanaan<br>
                    Internship di <strong>PT. TELKOM INDONESIA (Persero), Tbk Witel Yogya Jateng Selatan</strong><br>
                    yang dilaksanakan pada tanggal <strong><?php echo isset($magang->tanggal_mulai_usulan) ? strftime('%d %B %Y', strtotime($magang->tanggal_mulai_usulan)) : 'Not Available'; ?></strong> s/d
                    <strong><?php echo isset($magang->tanggal_selesai_usulan) ? strftime('%d %B %Y', strtotime($magang->tanggal_selesai_usulan)) : 'Not Available'; ?></strong>.
                </p>
            </div>

            <!-- Tanggal & TTD -->
            <div class="certif-footer">
                <p class="certif-date">Yogyakarta, <?php echo isset($certificate->updated_at) ? $certificate->updated_at->format('d F Y') : 'Not Available'; ?></p>
                <p class="certif-position-1">Telkom Witel Yogya Jateng Selatan</p>
                <p class="certif-position-2">Manager Shared Service &amp; General Support</p>
                <img src="<?php echo public_path('images/ttd-mba-rama-1.png'); ?>" alt="Tanda Tangan" class="certif-signature">
                <p class="certif-name-sign">Rama Kumala Sari</p>
                <p class="certif-nik">NIK. 810120</p>
            </div>
        </div>
    </div>
</body>

</html>