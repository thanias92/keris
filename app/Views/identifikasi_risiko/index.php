<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- PAGE HEADER -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">

                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">Identifikasi Risiko</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Identifikasi Risiko</h2>
                </div>

                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button class="btn btn-primary"
                        <?= !$activeKonteks ? 'disabled' : '' ?>
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasRisiko"
                        onclick="irResetForm()">
                        <i class="ti ti-plus"></i> Risiko
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Context Selector -->
    <?= view('identifikasi_risiko/_context_selector', [
        'listKonteks'   => $listKonteks,
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <!-- Context Active -->
    <?= view('identifikasi_risiko/_context_active', [
        'activeKonteks' => $activeKonteks,
    ]) ?>

    <!-- Content: filter + table -->
    <?= view('identifikasi_risiko/content', [
        'data'           => $data,
        'pager'          => $pager,
        'activeKonteks'  => $activeKonteks,
        'kategoriList'   => $kategoriList,
        'filterKategori' => $filterKategori,
    ]) ?>

</div>

<!-- Offcanvas Form -->
<?= view('identifikasi_risiko/_offcanvas_form', [
    'listKonteksProses' => $listKonteksProses,
    'activeKonteks'     => $activeKonteks,
    'areaDampakList'    => $areaDampakList,
    'kategoriList'      => $kategoriList,
]) ?>

<!-- JS Modules -->
<script src="<?= base_url('assets/js/modules/identifikasi_risiko/context-selector.js') ?>"></script>
<script src="<?= base_url('assets/js/modules/identifikasi_risiko/risiko.js') ?>"></script>

<?= $this->endSection() ?>