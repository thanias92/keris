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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="width:70px">Kode</th>
                            <th>Nama Kegiatan</th>
                            <th>Unit Kerja</th>
                            <th>Tahun</th>
                            <th>Penanggung Jawab</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($konteks as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <a href="<?= base_url('penetapan-konteks/view/' . $r['id_konteks']) ?>"
                                        class="text-decoration-none fw-semibold">
                                        <?= esc($r['kode_konteks']) ?>
                                    </a>
                                </td>
                                <td><?= esc($r['nama_kegiatan']) ?></td>
                                <td><?= esc($r['unit_kerja']) ?></td>
                                <td><?= esc($r['tahun']) ?></td>
                                <td><?= esc($r['penanggung_jawab']) ?></td>
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