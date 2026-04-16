<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.KEGIATAN_CONFIG = {
        url: {
            table: '<?= site_url('master/kegiatan/table') ?>',
            store: '<?= site_url('master/kegiatan/store') ?>',
            update: (id) => `<?= site_url('master/kegiatan/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/kegiatan/delete') ?>/${id}`
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
                        <li class="breadcrumb-item active">Kegiatan</li>
                    </ol>
                    <h2 class="page-title mb-0">Kegiatan</h2>
                </div>
                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <?= view('master/kegiatan/_table_section') ?>
    <?= view('master/kegiatan/_offcanvas_form') ?>

</div>

<script src="<?= base_url('assets/js/modules/master/kegiatan.js') ?>"></script>

<?= $this->endSection() ?>