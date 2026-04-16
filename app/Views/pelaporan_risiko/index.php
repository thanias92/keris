<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">Pelaporan Risiko</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Pelaporan Risiko</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <a href="<?= base_url('pelaporan-risiko/print') ?>" target="_blank" class="btn btn-outline-secondary me-2">
                        🖨️ Print PDF
                    </a>

                    <a href="<?= base_url('pelaporan-risiko/export') ?>" class="btn btn-primary">
                        ⬇️ Export Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?= view('pelaporan_risiko/_context_selector', [
        'listKonteks' => $listKonteks,
        'periode'     => $periode,
        'userRole'    => $userRole,
        'ketuaInfo'   => $ketuaInfo ?? null,
    ]) ?>

    <?= view('pelaporan_risiko/_summary_cards', [
        'summary' => $summary,
    ]) ?>

    <?= view('pelaporan_risiko/_table_section', [
        'data'    => $data,
        'pager'   => $pager   ?? null,
        'perPage' => $perPage ?? 10,
        'total'   => $total   ?? count($data),
        'from'    => $from    ?? 1,
        'to'      => $to      ?? count($data),
    ]) ?>

    <?= view('pelaporan_risiko/_offcanvas_form') ?>

    <div class="card mt-3">
        <div class="card-body small text-muted">
            <strong>Catatan:</strong><br>
            Laporan ini dihasilkan otomatis dari data Pemantauan Risiko
            dan digunakan sebagai bahan evaluasi manajemen risiko.
        </div>
    </div>

</div>

<link rel="stylesheet" href="<?= base_url('assets/css/pelaporan-risiko.css') ?>">
<script>
    window.USER_ROLE = "<?= session('user_role') ?>";
</script>

<script src="<?= base_url('assets/js/modules/pelaporan_risiko/pelaporan.js') ?>"></script>

<?= $this->endSection() ?>