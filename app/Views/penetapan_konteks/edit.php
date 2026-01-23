<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- PAGE HEADER / BREADCRUMB -->
<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('penetapan-konteks') ?>">Penetapan Konteks</a>
            </li>
            <li class="breadcrumb-item active">Ubah</li>
        </ul>
        <h2>Ubah Penetapan Konteks</h2>
    </div>
</div>

<!-- FORM -->
<?= $this->include('penetapan_konteks/form') ?>

<?= $this->endSection() ?>