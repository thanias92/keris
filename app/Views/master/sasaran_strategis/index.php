<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.SS_CONFIG = {
        url: {
            table: '<?= site_url('master/sasaran-strategis/table') ?>',
            store: '<?= site_url('master/sasaran-strategis/store') ?>',
            update: (id) => `<?= site_url('master/sasaran-strategis/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/sasaran-strategis/delete') ?>/${id}`
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
                        <li class="breadcrumb-item active">Sasaran Strategis</li>
                    </ol>
                    <h2 class="page-title mb-0">Sasaran Strategis</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">
                        <i class="ti ti-plus"></i> Sasaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/sasaran_strategis/_table_section') ?>
    <?= view('master/sasaran_strategis/_offcanvas_form') ?>

</div>

<script src="<?= base_url('assets/js/modules/master/sasaran_strategis.js') ?>"></script>

<?= $this->endSection() ?>