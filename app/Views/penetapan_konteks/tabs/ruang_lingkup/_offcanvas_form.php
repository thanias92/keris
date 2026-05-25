<div
    class="offcanvas offcanvas-end pk-offcanvas-sm"
    tabindex="-1"
    id="offcanvasRuangLingkup">

    <div class="offcanvas-header">
        <div>
            <h5 class="offcanvas-title mb-1">
                Tambah Ruang Lingkup
            </h5>

            <small class="text-muted">
                Buat ruang lingkup untuk penyusunan konteks risiko
            </small>
        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <form id="formRuangLingkup">

            <!-- Tahun -->
            <div class="mb-3">
                <label class="form-label">Tahun</label>

                <input
                    type="number"
                    name="tahun"
                    class="form-control"
                    value="<?= date('Y') ?>"
                    required>
            </div>

            <!-- Tim Kerja -->
            <div class="mb-3">
                <label class="form-label">Tim Kerja</label>

                <select
                    name="id_tim"
                    id="rl_tim"
                    class="form-select"
                    required>

                    <option value="">Pilih Tim Kerja</option>

                    <?php foreach ($listTimKerja as $tim): ?>
                        <option value="<?= $tim['id_tim'] ?>">
                            <?= esc($tim['nama_tim']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Kegiatan -->
            <div class="mb-4">
                <label class="form-label">Kegiatan</label>

                <select
                    name="id_kegiatan"
                    id="rl_kegiatan"
                    class="form-select"
                    required>

                    <option value="">Pilih Kegiatan</option>

                </select>
            </div>

            <!-- Footer -->
            <div class="d-flex justify-content-end gap-2">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="offcanvas">

                    Batal

                </button>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Simpan

                </button>

            </div>

        </form>

    </div>
</div>