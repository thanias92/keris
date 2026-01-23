<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- PAGE HEADER / BREADCRUMB -->
<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('penetapan-risiko') ?>">Penetapan Konteks</a>
            </li>
            <li class="breadcrumb-item active">Detail</li>
        </ul>
        <h2>Detail Penetapan Konteks</h2>
    </div>
</div>

<!-- FORM -->
<?= $this->include('penetapan_konteks/form') ?>

<?= $this->endSection() ?>