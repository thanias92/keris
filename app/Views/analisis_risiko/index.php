<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">

                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">Analisis Risiko</li>
                        </ol>
                    </nav>

                    <div class="d-flex align-items-center gap-3">
                        <h2 class="page-title mb-0">Analisis Risiko</h2>

                        <?php if (!$activeKonteks): ?>
                            <span class="badge bg-warning-subtle text-warning border border-warning">
                                Konteks belum dipilih
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button class="btn btn-primary"
                        <?= !$activeKonteks ? 'disabled' : '' ?>
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAnalisis"
                        onclick="resetAnalisisForm()">
                        <i class="ti ti-plus"></i> Analisis
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('analisis_risiko/_context_selector', [
        'konteksList'   => $konteksList,
        'activeKonteks' => $activeKonteks,
        'selectedContext' => $selectedContext ?? null
    ]) ?>

    <!-- Konteks Aktif -->
    <?php if ($activeKonteks): ?>
        <?= view('analisis_risiko/_context_active', [
            'activeKonteks' => $activeKonteks
        ]) ?>
    <?php endif; ?>

    <!-- Summary Card -->
    <?= view('analisis_risiko/_summary_cards', [
        'totalRisiko' => $totalRisiko,
        'totalSudah'  => $totalSudah,
        'totalBelum'  => $totalBelum,
        'activeKonteks' => $activeKonteks
    ]) ?>

    <?php if ($filter): ?>
        <div class="mb-3 d-flex align-items-center gap-2">

            <span class="text-muted small">Menampilkan:</span>

            <?php if ($filter === 'sudah'): ?>
                <span class="badge bg-success-subtle text-success border border-success">
                    Sudah Dianalisis
                </span>
            <?php elseif ($filter === 'belum'): ?>
                <span class="badge bg-warning-subtle text-warning border border-warning">
                    Belum Dianalisis
                </span>
            <?php endif; ?>

            <a href="<?= site_url('analisis-risiko') ?><?= $activeKonteks ? '?id_konteks=' . $activeKonteks['id_konteks'] : '' ?>"
                class="small text-decoration-none text-danger ms-2">
                ✕ Clear Filter
            </a>

        </div>
    <?php endif; ?>

    <!-- Table Section -->
    <?= view('analisis_risiko/_table_section', [
        'data'  => $data,
        'pager' => $pager ?? null,
        'activeKonteks' => $activeKonteks
    ]) ?>

    <!-- Offcanvas -->
    <?= view('analisis_risiko/_offcanvas_form', [
        'activeKonteks'   => $activeKonteks,
        'kemungkinanList' => $kemungkinanList,
        'dampakList'      => $dampakList
    ]) ?>
</div>
<?= $this->endSection() ?>

<script>
    function openAnalisisForm(idIdentifikasi, idPenilaian = null) {

        const offcanvas = new bootstrap.Offcanvas('#offcanvasAnalisis');
        offcanvas.show();

        document.getElementById('id_identifikasi').value = idIdentifikasi;

        if (idPenilaian) {
            // MODE EDIT
            fetch(`<?= site_url('analisis-risiko/detail') ?>/${idPenilaian}`)
                .then(res => res.json())
                .then(data => {

                    document.getElementById('id_penilaian').value = data.id_penilaian;
                    document.querySelector('[name="id_kemungkinan"]').value = data.id_kemungkinan;
                    document.querySelector('[name="id_dampak"]').value = data.id_dampak;

                    updateLiveCalculation();

                    document.getElementById('btnSubmit').innerText = 'Update Analisis';

                });

        } else {
            // MODE CREATE
            resetAnalisisForm();
            document.getElementById('btnSubmit').innerText = 'Simpan Analisis';
        }

    }
</script>