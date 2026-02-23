<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- ================= PAGE HEADER ================= -->
    <div class=" page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">

                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">Identifikasi Risiko</li>
                        </ol>
                    </nav>

                    <div class="d-flex align-items-center gap-3">
                        <h2 class="page-title mb-0">Identifikasi Risiko</h2>

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
                        data-bs-target="#offcanvasRisiko"
                        onclick="resetIdentifikasiForm()">
                        <i class="ti ti-plus"></i> Risiko
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('identifikasi_risiko/_context_selector', [
        'konteksList'   => $konteksList,
        'activeKonteks' => $activeKonteks
    ]) ?>

    <!-- Konteks Aktif -->
    <?php if ($activeKonteks): ?>
        <?= view('identifikasi_risiko/_context_active', [
            'activeKonteks' => $activeKonteks
        ]) ?>
    <?php endif; ?>

    <!-- Filter Section -->
    <?= view('identifikasi_risiko/_filter_section', [
        'kategoriList'  => $kategoriList,
        'activeKonteks' => $activeKonteks,
        'filterKategori' => $filterKategori
    ]) ?>

    <!-- Table Section -->
    <?= view('identifikasi_risiko/_table_section', [
        'data'  => $data,
        'pager' => $pager,
        'activeKonteks' => $activeKonteks
    ]) ?>

</div>

<?= view('identifikasi_risiko/identifikasi_form', [
    'listProses'      => $listProses,
    'activeKonteks'   => $activeKonteks,
    'areaDampakList'  => $areaDampakList,
    'kategoriList'    => $kategoriList
]) ?>

<script src="<?= base_url('assets/js/identifikasi-risiko.alert.js') ?>"></script>

<?= $this->endSection() ?>