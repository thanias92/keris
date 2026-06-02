<div class="offcanvas pk-offcanvas-rl" tabindex="-1" id="offcanvasRuangLingkup">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold" id="rlOffcanvasTitle">Tambah Ruang Lingkup</h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
    </div>

    <div class="offcanvas-body">
        <form id="formRuangLingkup" novalidate>
            <pre>
                <?php print_r(session('user')); ?>
            </pre>

            <input type="hidden" id="rlMode" value="create">
            <input type="hidden" id="rlId" value="">

            <!-- INFO PANEL (view mode) -->
            <div id="rlInfoPanel" class="ar-info-panel d-none">
                <div class="ar-section-title"><i class="ti ti-info-circle me-1"></i>Detail Ruang Lingkup</div>
                <div class="ar-info-row">
                    <span class="ar-info-label">Tahun</span>
                    <span class="ar-info-value" id="rlViewTahun">-</span>
                </div>
                <div class="ar-info-row">
                    <span class="ar-info-label">Tim Kerja</span>
                    <span class="ar-info-value" id="rlViewTim">-</span>
                </div>
                <div class="ar-info-row">
                    <span class="ar-info-label">Kegiatan</span>
                    <span class="ar-info-value" id="rlViewKegiatan">-</span>
                </div>
            </div>

            <!-- INPUT ZONE -->
            <div id="rlInputZone">
                <div class="mb-2">
                    <label class="ar-form-label">Tahun <span class="text-danger">*</span></label>
                    <input type="text" name="tahun" id="rlTahun" class="form-control" value="<?= date('Y') ?>" autocomplete="off" required>
                </div>

                <div class="mb-2">
                    <label class="ar-form-label">Tim Kerja <span class="text-danger">*</span></label>
                    <select name="id_tim" id="rl_tim" class="form-select" required>
                        <option value="">Pilih Tim Kerja</option>
                        <?php foreach ($listTimKerja as $tim): ?>
                            <option value="<?= $tim['id_tim'] ?>"><?= esc($tim['nama_tim']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="ar-form-label">Kegiatan <span class="text-danger">*</span></label>
                    <select name="id_kegiatan" id="rl_kegiatan" class="form-select" required>
                        <option value="">Pilih Kegiatan</option>
                    </select>
                </div>
            </div>

            <hr class="ar-divider">

            <!-- BUTTONS -->
            <div class="d-flex align-items-center pt-2 border-top mt-1">
                <div>
                    <button type="button" id="rlBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <button type="button" id="rlBtnEdit" class="btn btn-sm btn-warning text-white d-none">Edit</button>
                    <button type="button" id="rlBtnBatal" class="btn btn-sm btn-light d-none" data-bs-dismiss="offcanvas">Batal</button>
                    <button type="submit" id="rlBtnSimpan" class="btn btn-sm btn-primary px-4 d-none">
                        <i class="ti ti-device-floppy me-1"></i>Simpan
                    </button>
                    <button type="button" id="rlBtnTutup" class="btn btn-sm btn-light d-none" data-bs-dismiss="offcanvas">Tutup</button>
                </div>
            </div>

        </form>
    </div>
</div>