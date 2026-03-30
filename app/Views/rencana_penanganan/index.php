<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.RTP_CONFIG = {
        csrf: {
            name: '<?= csrf_token() ?>',
            token: '<?= csrf_hash() ?>',
        },
        url: {
            store: '<?= site_url('rencana-penanganan/store') ?>',
            update: (id) => `<?= site_url('rencana-penanganan/update') ?>/${id}`,
            delete: (id) => `<?= site_url('rencana-penanganan/delete') ?>/${id}`,
            detail: (id) => `<?= site_url('rencana-penanganan/detail') ?>/${id}`,
            detailEvaluasi: (id) => `<?= site_url('rencana-penanganan/detail-evaluasi') ?>/${id}`,
            preview: '<?= site_url('analisis-risiko/preview') ?>',
        }
    };
</script>

<div class="pk-page">

    <!-- PAGE HEADER -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">RTP</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Rencana Tindak Penanganan Risiko</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('rencana_penanganan/_context_selector', [
        'listKonteks'   => $listKonteks,
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <?php if ($activeKonteks): ?>

        <!-- Konteks Aktif Info -->
        <?= view('rencana_penanganan/_context_active', [
            'activeKonteks' => $activeKonteks,
        ]) ?>

        <!-- Summary Cards -->
        <?= view('rencana_penanganan/_summary_cards', [
            'totalRisiko'   => $totalRisiko,
            'totalSudah'    => $totalSudah,
            'totalBelum'    => $totalBelum,
            'levelRisiko'   => $levelRisiko,
            'activeKonteks' => $activeKonteks,
            'filter'        => $filter,
        ]) ?>

        <!-- Filter Badge -->
        <?php if ($filter): ?>
            <div class="mb-3 d-flex align-items-center gap-2">
                <span class="text-muted small">Menampilkan:</span>

                <?php if ($filter === 'sudah'): ?>
                    <span class="badge bg-success-subtle text-success border border-success">
                        Sudah Ada RTP
                    </span>
                <?php elseif ($filter === 'belum'): ?>
                    <span class="badge bg-warning-subtle text-warning border border-warning">
                        Belum Ada RTP
                    </span>
                <?php endif; ?>

                <a href="<?= site_url('rencana-penanganan') ?>"
                    class="small text-decoration-none text-danger ms-2">
                    ✕ Clear Filter
                </a>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- Table -->
    <?= view('rencana_penanganan/_table_section', [
        'grouped'       => $grouped,
        'activeKonteks' => $activeKonteks,
        'total'         => $total   ?? 0,
        'from'          => $from    ?? 1,
        'to'            => $to      ?? count($grouped),
        'perPage'       => $perPage ?? 10,
        'filter'        => $filter  ?? '',
        'pager'         => $pager   ?? null,
    ]) ?>

    <!-- Offcanvas Form -->
    <?= view('rencana_penanganan/_offcanvas_form', [
        'activeKonteks'       => $activeKonteks,
        'kriteriaKemungkinan' => $kriteriaKemungkinan ?? [],
        'kriteriaDampak'      => $kriteriaDampak      ?? [],
    ]) ?>

</div>

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/rencana-penanganan.css') ?>">

<!-- JS Modules -->
<script src="<?= base_url('assets/js/modules/rencana_penanganan/context-selector.js') ?>"></script>
<script src="<?= base_url('assets/js/modules/rencana_penanganan/rencana.js') ?>"></script>

<?= $this->endSection() ?>