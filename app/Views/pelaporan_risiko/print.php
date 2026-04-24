<!DOCTYPE html>
<html>

<head>
    <title>Laporan Risiko</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/pelaporan-risiko-print.css') ?>">
</head>

<body>

    <!-- HEADER -->
    <table width="100%">
        <tr>
            <td width="80">
                <img src="<?= FCPATH . 'assets/images/logo-bps.png' ?>" width="70">
            </td>
            <td style="text-align:center;">
                <div style="font-size:14px; font-weight:bold;">BADAN PUSAT STATISTIK</div>
                <div style="font-size:13px;">PROVINSI RIAU</div>
            </td>
            <td width="80"></td>
        </tr>
    </table>

    <hr style="border:1.5px solid black;">

    <!-- TITLE -->
    <div class="title">
        <h3>LAPORAN RISIKO</h3>
        <p>Periode: <?= $bulan ?> <?= $tahun ?></p>
    </div>

    <!-- INFO -->
    <div class="info">
        <p><strong>Tim Kerja:</strong> <?= $timkerja ?></p>
        <p><strong>Tanggal Cetak:</strong> <?= date('d-m-Y') ?></p>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Risiko</th>
                <th>RTP</th>
                <th>Output</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $d): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($d['pernyataan_risiko']) ?></td>
                    <td><?= esc($d['uraian_rtp']) ?></td>
                    <td><?= esc($d['realisasi_output']) ?></td>
                    <td class="text-center">
                        <?php if ($d['status'] === 'Selesai'): ?>
                            <span class="status-selesai">Selesai</span>
                        <?php else: ?>
                            <span class="status-belum"><?= esc($d['status']) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <!-- TTD -->
    <div class="ttd">
        <p>Pekanbaru, <?= date('d F Y') ?></p>
        <p>Ketua Tim,</p>

        <br><br><br>

        <p><strong><?= $nama_ketua ?></strong></p>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>
<link rel="stylesheet" href="<?= base_url('assets/css/pelaporan-risiko-print.css') ?>">