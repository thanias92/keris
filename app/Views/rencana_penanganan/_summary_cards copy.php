<?php
$qCtx = $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '';
?>

<div class="d-flex flex-wrap gap-2 mb-3 er-summary-row">

    <!-- TOTAL RISIKO DITANGANI -->
    <div class="er-stat-card">
        <div class="er-stat-label">Total Risiko Ditangani</div>
        <div class="er-stat-value"><?= $totalRisiko ?></div>
    </div>

    <!-- SUDAH ADA RTP -->
    <div class="er-stat-card <?= $filter === 'sudah' ? 'er-stat-active-sudah' : '' ?>"
        style="cursor:pointer"
        onclick="window.location='<?= site_url('rencana-penanganan') ?>?filter=sudah<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>'">
        <div class="er-stat-label">Sudah Ada RTP</div>
        <div class="er-stat-value text-success"><?= $totalSudah ?></div>
    </div>

    <!-- BELUM ADA RTP -->
    <div class="er-stat-card <?= $filter === 'belum' ? 'er-stat-active-belum' : '' ?>"
        style="cursor:pointer"
        onclick="window.location='<?= site_url('rencana-penanganan') ?>?filter=belum<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>'">
        <div class="er-stat-label">Belum Ada RTP</div>
        <div class="er-stat-value text-warning"><?= $totalBelum ?></div>
    </div>

    <!-- DISTRIBUSI LEVEL -->
    <?php if (!empty($levelRisiko)): ?>
        <div class="er-stat-card er-stat-dist ms-auto">
            <div class="er-stat-label mb-1">Distribusi Level</div>

            <?php
            $colorMap = [
                'Rendah'  => ['bg' => '#198754', 'text' => '#fff'],
                'Sedang'  => ['bg' => '#0dcaf0', 'text' => '#000'],
                'Tinggi'  => ['bg' => '#ffc107', 'text' => '#000'],
                'Ekstrem' => ['bg' => '#dc3545', 'text' => '#fff'],
            ];

            foreach ($levelRisiko as $level => $jumlah):
                $c = $colorMap[$level] ?? ['bg' => '#6c757d', 'text' => '#fff'];
            ?>
                <div class="d-flex align-items-center justify-content-between gap-3 er-dist-row">
                    <span class="er-dist-label"><?= esc($level) ?></span>
                    <span class="er-dist-badge"
                        style="background:<?= $c['bg'] ?>;color:<?= $c['text'] ?>">
                        <?= $jumlah ?>
                    </span>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>

</div>