<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- [ page-header ] start -->
<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('penetapan-konteks') ?>">Penetapan Konteks</a>
            </li>
            <li class="breadcrumb-item active">Tambah</li>
        </ul>
        <h2>Tambah Penetapan Konteks</h2>
    </div>
</div>
<!-- [ page-header ] end -->

<!-- FORM -->
<?= $this->include('penetapan_konteks/form') ?>

<?= $this->endSection() ?>