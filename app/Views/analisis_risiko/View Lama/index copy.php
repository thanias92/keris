<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .bg-orange {
        background-color: #fd7e14 !important;
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-block">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Manajemen Risiko</a>
            </li>
            <li class="breadcrumb-item active">Analisis Risiko</li>
        </ul>
        <h2>Analisis Risiko</h2>
    </div>
</div>

<!-- TABLE -->
<?= view('analisis_risiko/_table', ['risiko' => $risiko]) ?>

<!-- MODAL -->
<?= view('analisis_risiko/_modal') ?>

<!-- SCRIPT -->
<?= view('analisis_risiko/_script') ?>

<?= $this->endSection() ?>