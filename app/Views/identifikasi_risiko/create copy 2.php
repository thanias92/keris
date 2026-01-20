<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- [ page-header ] start -->
<div class="page-header mb-2">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('identifikasi-risiko') ?>">Identifikasi Risiko</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ul>
                <div class="page-header-title">
                    <h3 class="m-b-5">Tambah Identifikasi Risiko</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ page-header ] end -->

<div class="row mt-0">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('identifikasi-risiko/store') ?>" method="post">

                    <!-- Kode Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Risiko</label>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control bg-light"
                                value="<?= esc($kodeRisiko) ?>"
                                readonly>
                        </div>
                    </div>

                    <!-- Konteks Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Konteks Risiko</label>
                        <div class="col-sm-9">
                            <select name="id_konteks" class="form-select" required>
                                <option value="">-- Pilih Konteks Risiko --</option>
                                <?php foreach ($konteksList as $konteks): ?>
                                    <option value="<?= $konteks['id_konteks'] ?>">
                                        <?= esc($konteks['nama_kegiatan']) ?> (<?= esc($konteks['tahun']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Uraian Proses -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Proses</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="uraian_kegiatan"
                                class="form-control"
                                placeholder="Uraian Proses"
                                required>
                        </div>
                    </div>

                    <!-- Pernyataan Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pernyataan Risiko</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="pernyataan_risiko"
                                class="form-control"
                                placeholder="Pernyataan Risiko"
                                required>
                        </div>
                    </div>

                    <!-- Penyebab Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Penyebab Risiko</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="penyebab_risiko"
                                class="form-control"
                                placeholder="Penyebab Risiko"
                                required>
                        </div>
                    </div>

                    <!-- Dampak Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Dampak Risiko</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="dampak_risiko"
                                class="form-control"
                                placeholder="Dampak Risiko"
                                required>
                        </div>
                    </div>

                    <!-- Kategori Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kategori Risiko</label>
                        <div class="col-sm-9 d-flex align-items-center">

                            <div class="form-check form-check-inline me-4">
                                <input class="form-check-input"
                                    type="radio"
                                    name="kategori_risiko"
                                    id="kategoriOperasional"
                                    value="Operasional"
                                    required>
                                <label class="form-check-label" for="kategoriOperasional">
                                    Operasional
                                </label>
                            </div>

                            <div class="form-check form-check-inline me-4">
                                <input class="form-check-input"
                                    type="radio"
                                    name="kategori_risiko"
                                    id="kategoriTeknis"
                                    value="Teknis">
                                <label class="form-check-label" for="kategoriTeknis">
                                    Teknis
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="kategori_risiko"
                                    id="kategoriStrategis"
                                    value="Strategis">
                                <label class="form-check-label" for="kategoriStrategis">
                                    Strategis
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- Sumber Risiko -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Sumber Risiko</label>
                        <div class="col-sm-9 d-flex align-items-center">

                            <div class="form-check form-check-inline me-4">
                                <input class="form-check-input"
                                    type="radio"
                                    name="sumber_risiko"
                                    id="sumberInternal"
                                    value="Internal"
                                    required>
                                <label class="form-check-label" for="sumberInternal">
                                    Internal
                                </label>
                            </div>

                            <div class="form-check form-check-inline me-4">
                                <input class="form-check-input"
                                    type="radio"
                                    name="sumber_risiko"
                                    id="sumberEksternal"
                                    value="Eksternal">
                                <label class="form-check-label" for="sumberEksternal">
                                    Eksternal
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- Action -->
                    <div class="row mt-4">
                        <div class="col-sm-9 offset-sm-3 text-end">

                            <a href="<?= base_url('identifikasi-risiko') ?>"
                                class="btn btn-outline-secondary me-2">
                                <i class="ti ti-arrow-left"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="ti ti-device-floppy"></i> Simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>