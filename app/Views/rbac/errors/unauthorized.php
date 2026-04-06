<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="text-center mt-5">
    <h1 class="text-danger">403</h1>
    <h4>Akses Ditolak</h4>
    <p>Kamu tidak memiliki izin untuk mengakses halaman ini.</p>

    <a href="<?= site_url('/') ?>" class="btn btn-primary mt-3">
        Kembali ke Dashboard
    </a>
</div>

<?= $this->endSection() ?>