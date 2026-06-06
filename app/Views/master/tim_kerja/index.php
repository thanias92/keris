<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.TK_CONFIG = {
        url: {
            table: '<?= site_url('master/tim-kerja/table') ?>',
            store: '<?= site_url('master/tim-kerja/store') ?>',
            update: (id) => `<?= site_url('master/tim-kerja/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/tim-kerja/delete') ?>/${id}`,
            detail: (id) => `<?= site_url('master/tim-kerja/detail') ?>/${id}`
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
                        <li class="breadcrumb-item active">Tim Kerja & Kegiatan</li>
                    </ol>
                    <h2 class="page-title mb-0">Tim Kerja & Kegiatan</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">
                        <i class="ti ti-plus"></i> Tim
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/tim_kerja/_table_section') ?>
    <?= view('master/tim_kerja/_offcanvas_form') ?>

</div>
<link rel="stylesheet" href="<?= base_url('assets/css/module/master/tim-kerja.css') ?>">

<script src="<?= base_url('assets/js/modules/master/tim_kerja.js') ?>"></script>

<?= $this->endSection() ?>