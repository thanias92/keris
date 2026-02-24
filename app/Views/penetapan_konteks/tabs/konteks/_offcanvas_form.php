<div class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasKonteks">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Form Konteks</h5>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <form method="post"
            action="<?= site_url('penetapan-konteks/konteks/store') ?>">

            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number"
                    name="tahun"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Satuan Kerja</label>
                <select name="id_satuan_kerja"
                    class="form-select"
                    required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Sasaran Strategis</label>
                <select name="id_sasaran_strategis"
                    class="form-select"
                    required>
                    <option value="">-- Pilih --</option>
                </select>
            </div>

            <div class="mt-4">
                <button class="btn btn-primary w-100">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>