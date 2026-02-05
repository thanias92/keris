<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">

    <!-- HEADER -->
    <div class="page-header pk-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">Manajemen Risiko</li>
                        <li class="breadcrumb-item active">Identifikasi Risiko</li>
                    </ul>
                    <h2 class="m-b-10">Identifikasi Risiko</h2>
                </div>

                <div class="col-md-6 text-end">
                    <button
                        class="btn btn-primary"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasIdentifikasi">
                        + Identifikasi Risiko
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <small class="text-muted">
                    Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('identifikasi') ?> data
                </small>
                <?= $pager->links('identifikasi', 'default_full') ?>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th style="width:220px">Proses Bisnis</th>
                            <th>Uraian Kegiatan</th>
                            <th style="width:160px">Kategori</th>
                            <th style="width:80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Data identifikasi risiko belum tersedia
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>Proses #<?= esc($row['id_proses']) ?></td>
                                    <td><?= esc($row['uraian_kegiatan']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary">Belum Ditentukan</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?= $this->include('identifikasi_risiko/identifikasi_form') ?>

</div>

<?= $this->endSection() ?>