<?php $idKonteks = $activeKonteks['id_konteks'] ?? null; ?>

<div class="offcanvas offcanvas-end pk-offcanvas" tabindex="-1" id="offcanvasSasaranKinerja">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0" id="skOffcanvasTitle">Tambah Sasaran Kinerja</h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
    </div>

    <div class="offcanvas-body">
        <?php if (!$idKonteks): ?>
            <div class="alert alert-warning">
                <i class="ti ti-alert-circle me-1"></i>
                Pilih konteks aktif terlebih dahulu.
            </div>
        <?php else: ?>
            <form id="skForm">
                <input type="hidden" id="skIdSasaran" name="id_sasaran">
                <input type="hidden" name="id_konteks" value="<?= $idKonteks ?>">

                <!-- PROSES BISNIS -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Proses Bisnis</label>
                    <select name="id_konteks_proses" id="skIdKonteksProses" class="form-select" required>
                        <option value="">-- Pilih Proses Bisnis --</option>
                        <?php if (empty($listProses)): ?>
                            <option value="" disabled>Belum ada proses bisnis dipilih</option>
                        <?php else: ?>
                            <?php foreach ($listProses as $p): ?>
                                <option value="<?= $p['id_konteks_proses'] ?>">
                                    <?= esc($p['kode_proses']) ?> — <?= esc($p['uraian_proses']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- URAIAN SASARAN -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Uraian Sasaran Kinerja</label>
                    <textarea name="uraian_sasaran" id="skUraianSasaran"
                        class="form-control" rows="4"
                        placeholder="Contoh: Tersedianya daftar sampel yang berkualitas"
                        required></textarea>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($idKonteks): ?>
        <div class="offcanvas-footer border-top p-3">
            <div class="pk-action-wrapper">

                <!-- VIEW MODE -->
                <div class="pk-mode" id="skBtnView" style="display:none;">
                    <button type="button" class="btn btn-danger" id="skBtnDelete">
                        <i class="ti ti-trash"></i>
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                        <button type="button" class="btn btn-warning text-white" id="skBtnSwitchEdit">
                            <i class="ti ti-pencil me-1"></i> Edit
                        </button>
                    </div>
                </div>

                <!-- CREATE / EDIT MODE -->
                <div class="pk-mode" id="skBtnEdit" style="display:none;">
                    <button type="button" class="btn btn-light" id="skBtnCancel">Batal</button>
                    <button type="button" class="btn btn-primary" id="skBtnSimpan">Simpan</button>
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>