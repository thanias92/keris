<div class="row g-3 mb-3">

    <div class="col-md-3">
        <div class="pl-stat-card">
            <div class="pl-stat-label">Total RTP</div>
            <div class="pl-stat-value"><?= $summary['total'] ?></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="pl-stat-card">
            <div class="pl-stat-label">Selesai</div>
            <div class="pl-stat-value pl-success"><?= $summary['selesai'] ?></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="pl-stat-card">
            <div class="pl-stat-label">Dalam Proses</div>
            <div class="pl-stat-value pl-warning"><?= $summary['dalam_proses'] ?></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="pl-stat-card">
            <div class="pl-stat-label">Belum / Terlambat</div>
            <div class="pl-stat-value pl-danger">
                <?= $summary['belum'] + $summary['terlambat'] ?>
            </div>
        </div>
    </div>

</div>