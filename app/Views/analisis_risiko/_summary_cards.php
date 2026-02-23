<?php
$currentUrl = site_url('analisis-risiko');
$queryContext = $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '';
?>

<div class="row g-3 mb-4">

    <!-- TOTAL RISIKO -->
    <div class="col-md-3">
        <a href="<?= site_url('analisis-risiko') ?><?= $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '' ?>"
            class="text-decoration-none">
            <div class="card shadow-sm h-100 summary-card <?= !$filter ? 'active-total' : '' ?>">
                <div class="card-body">
                    <h6>Total Risiko</h6>
                    <h3><?= $totalRisiko ?></h3>
                </div>
            </div>
        </a>
    </div>

    <!-- SUDAH DIANALISIS -->
    <div class="col-md-3">
        <a href="<?= site_url('analisis-risiko') ?>?filter=sudah<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>"
            class="text-decoration-none">
            <div class="card shadow-sm h-100 summary-card <?= $filter === 'sudah' ? 'active-sudah' : '' ?>">
                <div class="card-body">
                    <h6>Sudah Dianalisis</h6>
                    <h3 class="text-success"><?= $totalSudah ?></h3>
                </div>
            </div>
        </a>
    </div>

    <!-- BELUM DIANALISIS -->
    <div class="col-md-3">
        <a href="<?= site_url('analisis-risiko') ?>?filter=belum<?= $activeKonteks ? '&id_konteks=' . $activeKonteks['id_konteks'] : '' ?>"
            class="text-decoration-none">
            <div class="card shadow-sm h-100 summary-card <?= $filter === 'belum' ? 'active-belum' : '' ?>">
                <div class="card-body">
                    <h6>Belum Dianalisis</h6>
                    <h3 class="text-warning"><?= $totalBelum ?></h3>
                </div>
            </div>
        </a>
    </div>

    <!-- DISTRIBUSI LEVEL -->
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted mb-2">Distribusi Level Risiko</h6>

                <?php foreach ($levelRisiko as $level => $jumlah): ?>

                    <?php
                    $badgeColor = match ($level) {
                        'Rendah'  => 'success',
                        'Sedang'  => 'info',
                        'Tinggi'  => 'warning',
                        'Ekstrem' => 'danger',
                        default   => 'secondary'
                    };
                    ?>

                    <div class="d-flex justify-content-between small mb-1">
                        <span><?= $level ?></span>
                        <span class="badge bg-<?= $badgeColor ?>">
                            <?= $jumlah ?>
                        </span>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>

</div>