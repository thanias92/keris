<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<div class="dash-wrap">
    <div class="dash-header">
        <div>
            <h4>Dashboard Manajemen Risiko</h4>
            <p>Ringkasan dan analisis data risiko organisasi</p>
        </div>
        <div class="dash-date" id="dashDate"></div>
    </div>

    <?= view('dashboard/filters') ?>

    <?= view('dashboard/_kpi_cards') ?>

    <?= view('dashboard/_heatmap', [
        'matriks' => $matriks,
        'heatmap' => $heatmap
    ]) ?>

    <?= view('dashboard/_status_rtp') ?>

    <?= view('dashboard/_progress') ?>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const DATA_URL = '<?= base_url('dashboard/data') ?>';
</script>

<script src="<?= base_url('assets/js/modules/dashboard/dashboard.js') ?>"></script>

<?= $this->endSection() ?>