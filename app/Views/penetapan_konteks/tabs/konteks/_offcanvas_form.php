<div class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasKonteks">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="pkOffcanvasTitle">
            Tambah Konteks
        </h5>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form id="pkFormKonteks">

            <input type="hidden" name="mode" id="pkMode" value="create">
            <input type="hidden" name="id_konteks" id="pkId">

            <!-- FIELD TAHUN -->
            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="text"
                    name="tahun"
                    id="pkTahun"
                    class="form-control">
            </div>

            <!-- FIELD PENGELOLA -->
            <div class="mb-3">
                <label class="form-label">Pengelola Risiko</label>
                <input type="text"
                    name="pengelola_risiko"
                    id="pkPengelola"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Pemangku Kepentingan</label>
                <select name="pemangku[]" multiple class="form-select">
                    <?php foreach ($listPemangku as $p): ?>
                        <option value="<?= $p['id_pemangku'] ?>">
                            <?= esc($p['nama_instansi']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Peraturan Terkait</label>
                <select name="peraturan[]" multiple class="form-select">
                    <?php foreach ($listPeraturan as $pr): ?>
                        <option value="<?= $pr['id_peraturan'] ?>"
                            <?= $pr['is_default'] ? 'selected' : '' ?>>
                            <?= esc($pr['nama_peraturan']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="d-flex justify-content-between mt-4">

                <button type="button"
                    class="btn btn-outline-secondary"
                    id="pkBtnEdit"
                    onclick="pkSwitchToEditMode()"
                    style="display:none;">
                    Edit
                </button>

                <button type="submit"
                    class="btn btn-primary"
                    id="pkBtnSubmit">
                    Simpan
                </button>

            </div>

        </form>

    </div>
</div>