<div class="d-flex flex-wrap gap-2 mb-3 er-summary-row">
    <!-- DISTRIBUSI LEVEL -->
    <?php if (!empty($levelRisiko)): ?>

        <?php
        $order = ['Rendah', 'Sedang', 'Tinggi', 'Ekstrem'];

        $colorMap = [
            'Rendah'  => '#198754',
            'Sedang'  => '#0dcaf0',
            'Tinggi'  => '#ffc107',
            'Ekstrem' => '#dc3545',
        ];

        $totalLevel = array_sum($levelRisiko);
        ?>

        <div class="er-stat-card er-stat-dist">

            <div class="er-stat-label mb-2">
                Distribusi Level
            </div>

            <?php foreach ($order as $lvl):

                $jumlah = $levelRisiko[$lvl] ?? 0;
                $warna  = $colorMap[$lvl];
                $percent = $totalLevel > 0
                    ? ($jumlah / $totalLevel) * 100
                    : 0;
            ?>

                <div class="ar-dist-bar-row">
                    <span class="ar-dist-label">
                        <?= esc($lvl) ?>
                    </span>

                    <div class="ar-dist-bar">
                        <div class="ar-dist-fill"
                            style="width:<?= $percent ?>%;background:<?= $warna ?>">
                        </div>
                    </div>

                    <span class="ar-dist-value">
                        <?= $jumlah ?>
                    </span>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <!-- TOTAL RISIKO DITANGANI -->
    <div class="er-stat-card">
        <div class="er-stat-label">Total Risiko Ditangani</div>
        <div class="er-stat-value"><?= $totalRisiko ?></div>
    </div>

    <!-- SUDAH ADA RTP -->
    <div class="er-stat-card <?= $filter === 'sudah' ? 'er-stat-active-sudah' : '' ?>"
        style="cursor:pointer"
        onclick="window.location='<?= site_url('rencana-penanganan?filter=sudah') ?>'">
        <div class="er-stat-label">Sudah Ada RTP</div>
        <div class="er-stat-value text-success"><?= $totalSudah ?></div>
    </div>

    <!-- BELUM ADA RTP -->
    <div class="er-stat-card <?= $filter === 'belum' ? 'er-stat-active-belum' : '' ?>"
        style="cursor:pointer"
        onclick="window.location='<?= site_url('rencana-penanganan?filter=belum') ?>'">
        <div class="er-stat-label">Belum Ada RTP</div>
        <div class="er-stat-value text-warning"><?= $totalBelum ?></div>
    </div>
</div>