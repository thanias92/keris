<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- [ page-header ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('dashboard') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('identifikasi-risiko') ?>">Identifikasi Risiko</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ul>
                <div class="page-header-title">
                    <h2 class="m-b-10">Tambah Identifikasi Risiko</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ page-header ] end -->

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Form Identifikasi Risiko</h5>
            </div>
            <div class="card-body">

                <form action="<?= base_url('identifikasi-risiko/store') ?>" method="post">

                    <div class="mb-3">
                        <label class="form-label">Kode Risiko</label>
                        <input type="text" name="kode" class="form-control" placeholder="R-001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Risiko</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Operasional">Operasional</option>
                            <option value="Teknis">Teknis</option>
                            <option value="Strategis">Strategis</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Level Risiko</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <a href="<?= base_url('identifikasi-risiko') ?>" class="btn btn-light">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>