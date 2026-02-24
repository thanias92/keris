<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header">
        <div class="page-block">
            <div class="row">

                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="#">Manajemen Risiko</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Penetapan Konteks
                            </li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Penetapan Konteks</h2>
                </div>

            </div>
        </div>
    </div>
    <!-- ================= END HEADER ================= -->


    <!-- ================= CONTEXT SELECTOR ================= -->
    <?= view('penetapan_konteks/shared/_context_selector') ?>

    <!-- ================= CONTEXT ACTIVE ================= -->
    <?= view('penetapan_konteks/shared/_context_active') ?>

    <!-- ================= TABS ================= -->
    <?= view('penetapan_konteks/shared/_tabs', ['activeTab' => $activeTab]) ?>

    <!-- ================= TAB CONTENT ================= -->
    <div class="card mt-3">
        <div class="card-body">
            <?= view('penetapan_konteks/tabs/' . $activeTab . '/content') ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>