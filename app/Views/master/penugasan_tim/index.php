<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.PT_CONFIG = {
        url: {
            table: '<?= site_url('master/penugasan-tim/table') ?>',
            store: '<?= site_url('master/penugasan-tim/store') ?>',
            update: (id) => `<?= site_url('master/penugasan-tim/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/penugasan-tim/delete') ?>/${id}`,

            timTable: '<?= site_url('master/tim-kerja/table') ?>',
            pengelolaTable: '<?= site_url('master/pengelola/table') ?>'
        }
    };
</script>

<div class="pk-page">
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item">Administrasi</li>
                        <li class="breadcrumb-item active">Penugasan Tim</li>
                    </ol>
                    <h2 class="page-title mb-0">Penugasan Tim</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/penugasan_tim/_table_section') ?>
    <?= view('master/penugasan_tim/_offcanvas_form') ?>

</div>

<script src="<?= base_url('assets/js/modules/master/penugasan_tim.js') ?>"></script>

<?= $this->endSection() ?>