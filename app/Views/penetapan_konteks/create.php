<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- [ page-header ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('penetapan-konteks') ?>">Penetapan Konteks</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ul>
                <div class="page-header-title">
                    <h3 class="m-b-5">Tambah Penetapan Konteks</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ page-header ] end -->

<form action="<?= base_url('penetapan-konteks/store') ?>" method="post">
    <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-8">

            <!-- Informasi Umum -->
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Umum</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit Kerja</label>
                            <input type="text" name="unit_kerja" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" placeholder="2025" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Tujuan & Sasaran -->
            <div class="card">
                <div class="card-header">
                    <h5>Tujuan & Sasaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tujuan Kegiatan</label>
                        <textarea name="tujuan_kegiatan" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sasaran</label>
                        <textarea name="sasaran" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Indikator Keberhasilan</label>
                        <textarea name="indikator_keberhasilan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Ruang Lingkup & Asumsi -->
            <div class="card">
                <div class="card-header">
                    <h5>Ruang Lingkup & Asumsi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Ruang Lingkup</label>
                        <textarea name="ruang_lingkup" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asumsi</label>
                        <textarea name="asumsi" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterbatasan</label>
                        <textarea name="keterbatasan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Faktor Risiko -->
            <div class="card">
                <div class="card-header">
                    <h5>Faktor Risiko</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Faktor Internal</label>
                        <textarea name="faktor_internal" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Faktor Eksternal</label>
                        <textarea name="faktor_eksternal" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-body">
                    <p class="text-muted">
                        Pastikan konteks yang dibuat sudah mencerminkan kondisi kegiatan secara menyeluruh,
                        karena akan digunakan pada proses identifikasi dan analisis risiko.
                    </p>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            Simpan Konteks
                        </button>
                        <a href="<?= base_url('penetapan-konteks') ?>" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<?= $this->endSection() ?>