<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.PR_CONFIG = {
        csrf: {
            name: '<?= csrf_token() ?>',
            token: '<?= csrf_hash() ?>',
        },
        url: {
            store: '<?= site_url('pemantauan-risiko/store') ?>',
            detail: (id) => `<?= site_url('pemantauan-risiko/detail') ?>/${id}`,
            delete: (id) => `<?= site_url('pemantauan-risiko/delete') ?>/${id}`,
            deleteBukti: (id) => `<?= site_url('pemantauan-risiko/bukti') ?>/${id}`,
            viewBukti: (id) => `<?= site_url('pemantauan-risiko/bukti/view') ?>/${id}`,
            downloadBukti: (id) => `<?= site_url('pemantauan-risiko/bukti/download') ?>/${id}`,
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
                            <li class="breadcrumb-item active">Pemantauan Risiko</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Pemantauan Risiko</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('pemantauan_risiko/_context_selector', [
        'listKonteks'   => $listKonteks,
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <!-- Jika ada konteks aktif -->
    <?php if ($activeKonteks): ?>

        <!-- Info Konteks -->
        <?= view('pemantauan_risiko/_context_active', [
            'activeKonteks' => $activeKonteks
        ]) ?>

        <!-- Summary Cards -->
        <?= view('pemantauan_risiko/_summary_cards', [
            'totalRtp'      => $totalRtp,
            'distribusi'    => $distribusi,
            'activeKonteks' => $activeKonteks,
            'filter'        => $filter ?? '',
        ]) ?>

    <?php endif; ?>

    <!-- TABLE -->
    <?= view('pemantauan_risiko/_table_section', [
        'data'          => $data,
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <!-- Offcanvas Form -->
    <?= view('pemantauan_risiko/_offcanvas_form', [
        'activeKonteks' => $activeKonteks,
    ]) ?>

</div>

<!-- CSS -->
<link rel="stylesheet" href="<?= base_url('assets/css/pemantauan-risiko.css') ?>">

<!-- JS -->
<script src="<?= base_url('assets/js/modules/pemantauan_risiko/context-selector.js') ?>"></script>
<script src="<?= base_url('assets/js/modules/pemantauan_risiko/pemantauan.js') ?>"></script>

<script>
    // simpan posisi scroll
    document.querySelectorAll('.pr-stat-link').forEach(el => {
        el.addEventListener('click', function() {
            sessionStorage.setItem('prScrollY', window.scrollY);
        });
    });

    // restore scroll
    window.addEventListener('load', function() {
        const y = sessionStorage.getItem('prScrollY');
        if (y !== null) {
            window.scrollTo(0, parseInt(y));
            sessionStorage.removeItem('prScrollY');
        }
    });
</script>

<?= $this->endSection() ?>