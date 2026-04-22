<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.SK_CONFIG = {
        url: {
            table: '<?= site_url('master/satuan-kerja/table') ?>',
            store: '<?= site_url('master/satuan-kerja/store') ?>',
            update: (id) => `<?= site_url('master/satuan-kerja/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/satuan-kerja/delete') ?>/${id}`,
            detail: (id) => `<?= site_url('master/satuan-kerja/detail') ?>/${id}`
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
                        <li class="breadcrumb-item active">Tim Kerja</li>
                    </ol>
                    <h2 class="page-title mb-0">Tim Kerja</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/satuan_kerja/_table_section') ?>
    <?= view('master/satuan_kerja/_offcanvas_form') ?>

</div>

<script src="<?= base_url('assets/js/modules/master/satuanKerja.js') ?>"></script>

<?= $this->endSection() ?>