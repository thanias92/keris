<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.ER_CONFIG = {
        csrf: {
            name: '<?= csrf_token() ?>',
            token: '<?= csrf_hash() ?>',
        },
        url: {
            store: '<?= site_url('evaluasi-risiko/store') ?>',
            update: (id) => `<?= site_url('evaluasi-risiko/update') ?>/${id}`,
            detail: (id) => `<?= site_url('evaluasi-risiko/detail') ?>/${id}`,
            detailAnalisis: (id) => `<?= site_url('evaluasi-risiko/detail-analisis') ?>/${id}`,
            analisisList: '<?= site_url('evaluasi-risiko/analisis-list') ?>',
            delete: (id) => `<?= site_url('evaluasi-risiko/delete') ?>/${id}`,
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
                            <li class="breadcrumb-item active">Evaluasi Risiko</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Evaluasi Risiko</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('evaluasi_risiko/_context_selector', [
        'listKonteks'   => $listKonteks,
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <!-- Konteks Aktif Info + Summary Cards + Filter Badge (hanya jika konteks aktif) -->
    <?php if ($activeKonteks): ?>

        <?= view('evaluasi_risiko/_context_active', ['activeKonteks' => $activeKonteks]) ?>

        <?= view('evaluasi_risiko/_summary_cards', [
            'totalRisiko'   => $totalRisiko,
            'totalSudah'    => $totalSudah,
            'totalBelum'    => $totalBelum,
            'levelRisiko'   => $levelRisiko,
            'activeKonteks' => $activeKonteks,
            'filter'        => $filter,
        ]) ?>

        <?php if ($filter): ?>
            <div class="mb-3 d-flex align-items-center gap-2">
                <span class="text-muted small">Menampilkan:</span>

                <?php if ($filter === 'sudah'): ?>
                    <span class="badge bg-success-subtle text-success border border-success">
                        Sudah Dievaluasi
                    </span>
                <?php elseif ($filter === 'belum'): ?>
                    <span class="badge bg-warning-subtle text-warning border border-warning">
                        Belum Dievaluasi
                    </span>
                <?php endif; ?>

                <a href="<?= site_url('evaluasi-risiko') ?>"
                    class="small text-decoration-none text-danger ms-2">
                    ✕ Clear Filter
                </a>
            </div>
        <?php endif; ?>

    <?php endif; ?>

    <!-- Table -->
    <?= view('evaluasi_risiko/_table_section', [
        'data'          => $data,
        'activeKonteks' => $activeKonteks,
        'total'         => $total   ?? 0,
        'from'          => $from    ?? 1,
        'to'            => $to      ?? count($data),
        'perPage'       => $perPage ?? 10,
        'filter'        => $filter  ?? '',
        'pager'         => $pager   ?? null,
    ]) ?>

    <!-- Offcanvas Form -->
    <?= view('evaluasi_risiko/_offcanvas_form', [
        'activeKonteks' => $activeKonteks,
    ]) ?>

</div>

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/evaluasi-risiko.css') ?>">

<!-- JS Modules -->
<script src="<?= base_url('assets/js/modules/evaluasi_risiko/context-selector.js') ?>"></script>
<script src="<?= base_url('assets/js/modules/evaluasi_risiko/evaluasi.js') ?>"></script>

<script>
    /* simpan posisi scroll saat klik summary card */
    document.querySelectorAll('.er-stat-link').forEach(el => {
        el.addEventListener('click', function() {
            sessionStorage.setItem('erScrollY', window.scrollY);
        });
    });

    /* kembalikan scroll setelah halaman reload */
    window.addEventListener('load', function() {
        const y = sessionStorage.getItem('erScrollY');
        if (y !== null) {
            window.scrollTo(0, parseInt(y));
            sessionStorage.removeItem('erScrollY');
        }
    });
</script>

<?= $this->endSection() ?>