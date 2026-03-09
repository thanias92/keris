<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">

                <!-- LEFT SIDE -->
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

                <!-- RIGHT SIDE BUTTON -->
                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">

                    <?php
                    $btn = pk_module_config('penetapan_konteks', $activeTab);
                    ?>

                    <?php if ($btn): ?>
                        <button class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvas<?= ucfirst($btn['module']) ?>"
                            onclick="pkOpenCreateMode()">
                            <i class="ti ti-plus"></i> <?= esc($btn['label']) ?>
                        </button>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
    <!-- ================= END HEADER ================= -->

    <!-- ================= TABS ================= -->
    <?= view('penetapan_konteks/shared/_tabs', ['activeTab' => $activeTab]) ?>

    <!-- ================= CONTEXT SELECTOR ================= -->
    <?= view('penetapan_konteks/shared/_context_selector') ?>

    <!-- ================= CONTEXT ACTIVE ================= -->
    <?php if ($activeTab !== 'konteks'): ?>
        <?= view('penetapan_konteks/shared/_context_active') ?>
    <?php endif; ?>

    <!-- ================= TAB CONTENT ================= -->
    <div class="card mt-3">
        <div class="card-body">
            <?= view('penetapan_konteks/tabs/' . $activeTab . '/content') ?>
        </div>
    </div>

</div>
<?php if ($btn): ?>
    <?= view('penetapan_konteks/tabs/' . $btn['module'] . '/_offcanvas_form') ?>
<?php endif; ?>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>

<script src="<?= base_url('assets/js/modules/penetapan_konteks/' . $activeTab . '.js') ?>"></script>

<?= $this->endSection() ?>