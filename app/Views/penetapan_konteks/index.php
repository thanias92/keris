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
                        Penetapan Konteks
                    </li>
                </ul>
                <div class="page-header-title">
                    <h2 class="m-b-10">Penetapan Konteks</h2>
                </div>
            </div>

            <div class="col-md-6 text-end">
                <a href="<?= base_url('penetapan-konteks/create') ?>" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Konteks
                </a>
            </div>
        </div>
    </div>
</div>
<!-- [ page-header ] end -->

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Kegiatan</th>
                        <th>Unit Kerja</th>
                        <th width="8%">Tahun</th>
                        <th>Penanggung Jawab</th>
                        <th width="15%">Dibuat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($konteks)) : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada data konteks risiko
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1;
                        foreach ($konteks as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= esc($row['nama_kegiatan']) ?></strong>
                                </td>
                                <td><?= esc($row['unit_kerja']) ?></td>
                                <td><?= esc($row['tahun']) ?></td>
                                <td><?= esc($row['penanggung_jawab']) ?></td>
                                <td>
                                    <?= $row['created_at']
                                        ? date('d M Y', strtotime($row['created_at']))
                                        : '-' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('penetapan-konteks/edit/' . $row['id_konteks']) ?>"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="<?= base_url('penetapan-konteks/delete/' . $row['id_konteks']) ?>"
                                        method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus konteks ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>