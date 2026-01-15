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
                            <th>Kode</th>
                            <th>Nama Risiko</th>
                            <th>Kategori</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($risiko as $r): ?>
                            <tr>
                                <td><?= esc($r['kode']) ?></td>
                                <td><?= esc($r['nama']) ?></td>
                                <td><?= esc($r['kategori']) ?></td>
                                <td>
                                    <span class="badge bg-warning"><?= esc($r['level']) ?></span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-warning">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>