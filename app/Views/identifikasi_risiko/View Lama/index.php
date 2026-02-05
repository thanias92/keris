<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- [ page-header ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0)">Manajemen Risiko</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Identifikasi Risiko
                    </li>
                </ul>
                <div class="page-header-title">
                    <h2 class="m-b-10">Identifikasi Risiko</h2>
                </div>
            </div>

            <div class="col-md-6 text-end">
                <a href="<?= base_url('identifikasi-risiko/create') ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Risiko
                </a>
            </div>
        </div>
    </div>
</div>
<!-- [ page-header ] end -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Uraian Kegiatan</th>
                            <th>Kategori</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($risiko as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <a href="<?= base_url('identifikasi-risiko/view/' . $r['id_identifikasi']) ?>"
                                        class="text-decoration-none fw-semibold">
                                        <?= esc($r['kode_risiko']) ?>
                                    </a>
                                </td>
                                <td><?= esc($r['uraian_kegiatan']) ?></td>
                                <td><?= esc($r['kategori_risiko']) ?></td>
                                <td>
                                    <span class="badge bg-warning">
                                        <?= esc($r['level_risiko'] ?? '-') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
            confirmButtonText: 'OK',
            width: 420,
            customClass: {
                popup: 'swal-mantis'
            }
        });
    </script>
<?php endif ?>

<?= $this->endSection() ?>