<?php $this->extend('layout/main'); ?>
<?php $this->section('content'); ?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Bank Risiko</h4>
            <small class="text-muted">Daftar pernyataan risiko sebagai referensi identifikasi risiko</small>
        </div>
        <?php if (session()->get('user_role') === 'admin'): ?>
            <button class="btn btn-primary" id="btnTambahBankRisiko">
                <i class="ti ti-plus me-1"></i> Tambah
            </button>
        <?php endif; ?>
    </div>

    <!-- TABLE CARD -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div id="bankRisikoTableWrapper">
                <?= view('bank_risiko/_table_section', ['data' => $data, 'pager' => $pager, 'perPage' => $perPage]) ?>
            </div>
        </div>
    </div>

</div>

<!-- MODAL FORM -->
<?= view('bank_risiko/_offcanvas_form') ?>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script src="<?= base_url('assets/js/modules/bank_risiko.js') ?>"></script>
<?php $this->endSection(); ?>