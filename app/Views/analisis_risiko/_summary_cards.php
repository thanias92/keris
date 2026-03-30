<?php
$qCtx = $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '';
?>

<div class="d-flex flex-wrap gap-2 mb-3 ar-summary-row">

    <!-- TOTAL -->
    <a href="<?= site_url('analisis-risiko') . $qCtx ?>" class="text-decoration-none">
        <div class="ar-stat-card <?= !$filter ? 'ar-stat-active' : '' ?>">
            <div class="ar-stat-label">Total Risiko</div>
            <div class="ar-stat-value"><?= $totalRisiko ?></div>
        </div>
    </a>

    <!-- SUDAH -->
    <a href="<?= site_url('analisis-risiko') ?>?filter=sudah<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>" class="text-decoration-none">
        <div class="ar-stat-card <?= $filter === 'sudah' ? 'ar-stat-active-sudah' : '' ?>">
            <div class="ar-stat-label">Sudah Dianalisis</div>
            <div class="ar-stat-value text-success"><?= $totalSudah ?></div>
        </div>
    </a>

    <!-- BELUM -->
    <a href="<?= site_url('analisis-risiko') ?>?filter=belum<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>" class="text-decoration-none">
        <div class="ar-stat-card <?= $filter === 'belum' ? 'ar-stat-active-belum' : '' ?>">
            <div class="ar-stat-label">Belum Dianalisis</div>
            <div class="ar-stat-value text-warning"><?= $totalBelum ?></div>
        </div>
    </a>

    <!-- DISTRIBUSI -->
    <?php if (!empty($levelRisiko)): ?>
        <div class="ar-stat-card ar-stat-dist ms-auto">
            <div class="ar-stat-label mb-1">Distribusi Level</div>
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
                <div class="d-flex align-items-center justify-content-between gap-3 ar-dist-row">
                    <span class="ar-dist-label"><?= esc($level) ?></span>
                    <span class="ar-dist-badge" style="background:<?= $c['bg'] ?>;color:<?= $c['text'] ?>">
                        <?= $jumlah ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>  