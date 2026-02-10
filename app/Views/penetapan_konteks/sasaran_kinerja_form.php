<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasSasaranKinerja"
    style="width:420px">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 id="offcanvasTitleSasaran" class="mb-0 fw-semibold">
                Tambah Sasaran Kinerja
            </h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <form id="formSasaranKinerja"
            method="post"
            action="<?= site_url('penetapan-konteks/sasaran-kinerja/store') ?>">

            <input type="hidden" name="id_sasaran" id="id_sasaran">
            <input type="hidden" name="id_konteks" value="<?= esc($activeKonteks['id_konteks']) ?>">

            <!-- KODE SASARAN -->
            <div class="mb-3">
                <label class="form-label">Kode Sasaran</label>
                <input type="text"
                    id="kode_sasaran"
                    name="kode_sasaran"
                    class="form-control bg-light"
                    placeholder="Otomatis"
                    readonly>
            </div>

            <!-- PROSES BISNIS -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Proses Bisnis</label>
                <select name="id_proses"
                    id="id_proses"
                    class="form-select"
                    required>
                    <option value="">-- Pilih Proses Bisnis --</option>
                    <?php foreach ($listProses as $p): ?>
                        <option value="<?= $p['id_proses'] ?>">
                            <?= esc($p['kode_proses']) ?> - <?= esc($p['uraian_proses']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SASARAN KINERJA -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Sasaran Kinerja</label>
                <textarea name="uraian_sasaran"
                    id="uraian_sasaran"
                    class="form-control"
                    rows="4"
                    placeholder="Contoh: Tersedianya daftar sampel yang berkualitas"
                    required></textarea>
            </div>

            <!-- ACTION BUTTON -->
            <div class="d-flex align-items-center mt-4 pt-3 border-top">
                <div class="me-auto">
                    <button type="button"
                        id="btnDeleteSasaran"
                        class="btn btn-outline-danger btn-icon d-none"
                        title="Hapus Sasaran Kinerja">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="offcanvas">
                        Tutup
                    </button>

                    <button type="button"
                        id="btnEditSasaran"
                        class="btn btn-warning d-none">
                        Edit
                    </button>

                    <button type="button"
                        id="btnSimpanSasaran"
                        class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        <form id="formDeleteSasaran" method="post" class="d-none"></form>

    </div>
</div>