<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script>
    window.BANK_RISIKO_CONFIG = {
        url: {
            table: '<?= site_url('master/bank-risiko/table') ?>',
            store: '<?= site_url('master/bank-risiko/store') ?>',
            update: (id) => `<?= site_url('master/bank-risiko/update') ?>/${id}`,
            delete: (id) => `<?= site_url('master/bank-risiko/delete') ?>/${id}`,
            approve: (id) => `<?= site_url('master/bank-risiko/approve') ?>/${id}`,
            reject: (id) => `<?= site_url('master/bank-risiko/reject') ?>/${id}`
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
                        <li class="breadcrumb-item active">Bank Risiko</li>
                    </ol>
                    <h2 class="page-title mb-0">Bank Risiko</h2>
                </div>

                <div class="col-12 col-lg-4 text-lg-end mt-2 mt-lg-0">
                    <button class="btn btn-primary" id="btnTambah">Tambah</button>
                </div>

            </div>
        </div>
    </div>

    <?= view('master/bank_risiko/_table_section') ?>
    <?= view('master/bank_risiko/_offcanvas_form') ?>

</div>

<script src="<?= base_url('assets/js/modules/master/bank_risiko.js') ?>"></script>

<?= $this->endSection() ?>