<?php
// Warna per status pemantauan
$statusConfig = [
    'Belum Dilaksanakan' => ['color' => '#6c757d', 'text' => 'text-secondary'],
    'Dalam Proses'       => ['color' => '#0d6efd', 'text' => 'text-primary'],
    'Selesai'            => ['color' => '#198754', 'text' => 'text-success'],
    'Terlambat'          => ['color' => '#dc3545', 'text' => 'text-danger'],
];

$totalDistribusi = array_sum($distribusi);
?>

<div class="d-flex flex-wrap gap-2 mb-3 er-summary-row">

    <!-- DISTRIBUSI STATUS -->
    <?php if (!empty($distribusi)): ?>
        <div class="er-stat-card er-stat-dist">
            <div class="er-stat-label mb-2">Distribusi Status</div>

            <?php foreach ($distribusi as $status => $jumlah): ?>
                <?php
                $warna   = $statusConfig[$status]['color'] ?? '#adb5bd';
                $percent = $totalDistribusi > 0 ? ($jumlah / $totalDistribusi) * 100 : 0;
                ?>
                <div class="er-dist-bar-row">
                    <span class="er-dist-label"><?= esc($status) ?></span>
                    <div class="er-dist-bar">
                        <div class="er-dist-fill"
                            style="width:<?= number_format($percent, 1) ?>%; background:<?= $warna ?>">
                        </div>
                    </div>
                    <span class="er-dist-value"><?= $jumlah ?></span>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <!-- TOTAL RTP -->
    <a href="<?= site_url('pemantauan-risiko') ?>" class="er-stat-link">
        <div class="er-stat-card <?= !$filter ? 'er-stat-active' : '' ?>">
            <div class="er-stat-label">Total RTP</div>
            <div class="er-stat-value"><?= $totalRtp ?></div>
        </div>
    </a>

    <!-- SUDAH DIPANTAU -->
    <a href="<?= site_url('pemantauan-risiko?filter=Selesai') ?>" class="er-stat-link">
        <div class="er-stat-card <?= $filter === 'Selesai' ? 'er-stat-active-sudah' : '' ?>">
            <div class="er-stat-label">Selesai</div>
            <div class="er-stat-value text-success"><?= $distribusi['Selesai'] ?? 0 ?></div>
        </div>
    </a>

    <!-- DALAM PROSES -->
    <a href="<?= site_url('pemantauan-risiko?filter=Dalam+Proses') ?>" class="er-stat-link">
        <div class="er-stat-card <?= $filter === 'Dalam Proses' ? 'er-stat-active' : '' ?>">
            <div class="er-stat-label">Dalam Proses</div>
            <div class="er-stat-value text-primary"><?= $distribusi['Dalam Proses'] ?? 0 ?></div>
        </div>
    </a>

    <!-- BELUM DILAKSANAKAN -->
    <a href="<?= site_url('pemantauan-risiko?filter=Belum+Dilaksanakan') ?>" class="er-stat-link">
        <div class="er-stat-card <?= $filter === 'Belum Dilaksanakan' ? 'er-stat-active-belum' : '' ?>">
            <div class="er-stat-label">Belum Dilaksanakan</div>
            <div class="er-stat-value text-secondary"><?= $distribusi['Belum Dilaksanakan'] ?? 0 ?></div>
        </div>
    </a>

    <!-- TERLAMBAT -->
    <a href="<?= site_url('pemantauan-risiko?filter=Terlambat') ?>" class="er-stat-link">
        <div class="er-stat-card <?= $filter === 'Terlambat' ? 'er-stat-active-belum' : '' ?>">
            <div class="er-stat-label">Terlambat</div>
            <div class="er-stat-value text-danger"><?= $distribusi['Terlambat'] ?? 0 ?></div>
        </div>
    </a>

</div>