<?php
$qCtx = $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '';
?>

<div class="d-flex flex-wrap gap-2 mb-3 ar-summary-row">

    <?php if (!empty($levelRisiko)): ?>

        <?php
        $order = ['Sangat Rendah', 'Rendah', 'Sedang', 'Tinggi', 'Sangat Tinggi'];

        $colorMap = [
            'Sangat Rendah' => '#0d6efd',
            'Rendah' => '#198754',
            'Sedang' => '#ffc107',
            'Tinggi' => '#fd7e14',
            'Sangat Tinggi' => '#dc3545'
        ];

        $totalLevel = array_sum($levelRisiko);
        ?>

        <div class="ar-stat-card ar-stat-dist">
            <div class="ar-stat-label mb-2">Distribusi Level</div>

            <?php foreach ($order as $lvl):
                $jumlah = $levelRisiko[$lvl] ?? 0;
                $warna = $colorMap[$lvl];
                $percent = $totalLevel > 0 ? ($jumlah / $totalLevel) * 100 : 0;
            ?>

                <div class="ar-dist-bar-row">
                    <span class="ar-dist-label"><?= esc($lvl) ?></span>

                    <div class="ar-dist-bar">
                        <div class="ar-dist-fill" style="width:<?= $percent ?>%;background:<?= $warna ?>"></div>
                    </div>

                    <span class="ar-dist-value"><?= $jumlah ?></span>
                </div>

            <?php endforeach; ?>

        </div>
    <?php endif; ?>

    <a href="<?= site_url('analisis-risiko') . $qCtx ?>" class="ar-stat-link">
        <div class="ar-stat-card <?= !$filter ? 'ar-stat-active' : '' ?>">
            <div class="ar-stat-label">Total Risiko</div>
            <div class="ar-stat-value"><?= $totalRisiko ?></div>
        </div>
    </a>

    <a href="<?= site_url('analisis-risiko') ?>?filter=sudah<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>" class="ar-stat-link">
        <div class="ar-stat-card <?= $filter === 'sudah' ? 'ar-stat-active-sudah' : '' ?>">
            <div class="ar-stat-label">Sudah Dianalisis</div>
            <div class="ar-stat-value text-success"><?= $totalSudah ?></div>
        </div>
    </a>

    <a href="<?= site_url('analisis-risiko') ?>?filter=belum<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>" class="ar-stat-link">
        <div class="ar-stat-card <?= $filter === 'belum' ? 'ar-stat-active-belum' : '' ?>">
            <div class="ar-stat-label">Belum Dianalisis</div>
            <div class="ar-stat-value text-warning"><?= $totalBelum ?></div>
        </div>
    </a>

</div>