<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<div class="container-fluid">

    <div class="mb-4">
        <h4>Dashboard Manajemen Risiko</h4>
        <small>Ringkasan data risiko</small>
    </div>

    <!-- KPI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="kpi">
                <i class="ti ti-alert-circle"></i>
                <div>
                    <span>Total Risiko</span>
                    <b><?= $totalRisiko ?></b>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi">
                <i class="ti ti-list-check"></i>
                <div>
                    <span>RTP</span>
                    <b><?= $totalRtp ?></b>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi">
                <i class="ti ti-progress"></i>
                <div>
                    <span>Realisasi</span>
                    <b><?= $realisasi ?>%</b>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi danger">
                <i class="ti ti-alert-triangle"></i>
                <div>
                    <span>Risiko Tinggi</span>
                    <b><?= $risikoTinggi ?></b>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">

        <!-- HEATMAP -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Peta Risiko (Heatmap)</div>
                <div class="card-body">

                    <table class="heatmap">
                        <?php for ($y = 5; $y >= 1; $y--): ?>
                            <tr>
                                <?php for ($x = 1; $x <= 5; $x++):
                                    $v = $heatmap[$y][$x];
                                    $class = 'low';
                                    if ($y >= 4 || $x >= 4) $class = 'high';
                                    elseif ($y >= 3 || $x >= 3) $class = 'medium';
                                ?>
                                    <td class="<?= $class ?>">
                                        <?= $v ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>

                    <div class="legend">
                        <span class="low">Rendah</span>
                        <span class="medium">Sedang</span>
                        <span class="high">Tinggi</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- TREND -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">Trend Risiko</div>
                <div class="card-body">
                    <canvas id="trend"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('trend'), {
        type: 'line',
        data: {
            labels: <?= json_encode($trendLabels) ?>,
            datasets: [{
                label: 'Risiko',
                data: <?= json_encode($trendValues) ?>,
                borderColor: '#3b82f6',
                tension: .3
            }]
        }
    })
</script>

<?= $this->endSection() ?>