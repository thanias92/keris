<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.PR_CONFIG = {
        url: {
            table: '<?= site_url('master/pengelola-risiko/table') ?>',
            wilayah: '<?= site_url('master/pengelola-risiko/wilayah') ?>',
            store: '<?= site_url('master/pengelola-risiko/store') ?>',
            update: (id) => `<?= site_url('master/pengelola-risiko/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/pengelola-risiko/delete') ?>/${id}`,
            wilayahTable: '<?= site_url('master/wilayah/table') ?>',
        }
    }
</script>

<div class="pk-page">
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item active">Pengelola Risiko</li>
                    </ol>
                    <h2 class="page-title mb-0">Pengelola Risiko</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">
                        <i class="ti ti-plus"></i> Pengelola
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/pengelola_risiko/_table_section') ?>
    <?= view('master/pengelola_risiko/_offcanvas_form') ?>

</div>

<link rel="stylesheet" href="<?= base_url('assets/css/module/master/pengelola-risiko.css') ?>">
<script src="<?= base_url('assets/js/modules/master/pengelola_risiko.js') ?>"></script>

<?= $this->endSection() ?>