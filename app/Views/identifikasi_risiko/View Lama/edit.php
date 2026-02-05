<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- PAGE HEADER / BREADCRUMB -->
<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('identifikasi-risiko') ?>">Identifikasi Risiko</a>
            </li>
            <li class="breadcrumb-item active">Ubah</li>
        </ul>
        <h2>Ubah Identifikasi Risiko</h2>
    </div>
</div>

<!-- FORM -->
<?= $this->include('identifikasi_risiko/form') ?>

<?= $this->endSection() ?>