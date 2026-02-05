<div class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasIdentifikasi"
    aria-labelledby="offcanvasIdentifikasiLabel">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasIdentifikasiLabel">
            Tambah Identifikasi Risiko
        </h5>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        <form action="<?= site_url('identifikasi-risiko/store') ?>" method="post">
            <?= csrf_field() ?>

            <!-- PROSES BISNIS -->
            <div class="mb-3">
                <label class="form-label">
                    Proses Bisnis <span class="text-danger">*</span>
                </label>
                <input type="number"
                    name="id_proses"
                    class="form-control"
                    placeholder="ID Proses Bisnis"
                    required>
            </div>

            <!-- KODE RISIKO -->
            <div class="mb-3">
                <label class="form-label">
                    Kode Risiko <span class="text-danger">*</span>
                </label>
                <input type="text"
                    name="kode_risiko"
                    class="form-control"
                    placeholder="Contoh: IR-01"
                    required>
            </div>

            <!-- URAIAN KEGIATAN -->
            <div class="mb-3">
                <label class="form-label">
                    Uraian Kegiatan <span class="text-danger">*</span>
                </label>
                <textarea name="uraian_kegiatan"
                    class="form-control"
                    rows="3"
                    placeholder="Uraian kegiatan proses bisnis"
                    required></textarea>
            </div>

            <!-- PERNYATAAN RISIKO -->
            <div class="mb-3">
                <label class="form-label">
                    Pernyataan Risiko <span class="text-danger">*</span>
                </label>
                <textarea name="pernyataan_risiko"
                    class="form-control"
                    rows="3"
                    placeholder="Apa risiko yang mungkin terjadi?"
                    required></textarea>
            </div>

            <!-- DAMPAK RISIKO -->
            <div class="mb-3">
                <label class="form-label">
                    Dampak Risiko <span class="text-danger">*</span>
                </label>
                <textarea name="dampak_risiko"
                    class="form-control"
                    rows="2"
                    placeholder="Dampak yang ditimbulkan"
                    required></textarea>
            </div>

            <!-- PENYEBAB RISIKO -->
            <div class="mb-3">
                <label class="form-label">
                    Penyebab Risiko <span class="text-danger">*</span>
                </label>
                <textarea name="penyebab_risiko"
                    class="form-control"
                    rows="2"
                    placeholder="Penyebab terjadinya risiko"
                    required></textarea>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="offcanvas">
                    Batal
                </button>

                <button type="submit"
                    class="btn btn-primary">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>