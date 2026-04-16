<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- HEADER -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">Manajemen Risiko</li>
                            <li class="breadcrumb-item active">MR Instansi</li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">MR Instansi (SICAPKIN)</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button id="btnSync" class="btn btn-primary">
                        Ambil Data SICAPKIN
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex gap-2 flex-wrap">

            <select id="filterTahun" class="form-select w-auto">
                <option value="">Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
            </select>

            <select id="filterTriwulan" class="form-select w-auto">
                <option value="">Triwulan</option>
                <option value="1">TW I</option>
                <option value="2">TW II</option>
                <option value="3">TW III</option>
                <option value="4">TW IV</option>
            </select>

            <button id="btnFilter" class="btn btn-light">
                <i class="ti ti-search"></i>
            </button>

        </div>
    </div>

    <!-- TABLE -->
    <?= view('mr_instansi/_table_section') ?>

</div>

<link rel="stylesheet" href="<?= base_url('assets/css/mr-instansi.css') ?>">
<script src="<?= base_url('assets/js/mrInstansi.js') ?>"></script>

<?= $this->endSection() ?>