<?php $idKonteks = $activeKonteks['id_konteks'] ?? null; ?>

<div class="offcanvas offcanvas-end pk-offcanvas" tabindex="-1" id="offcanvasPemangku"
    style="width: 420px;">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0" id="pmOffcanvasTitle">Tambah Pemangku Kepentingan</h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <?php if (!$idKonteks): ?>
            <div class="alert alert-warning">
                <i class="ti ti-alert-circle me-1"></i>
                Pilih konteks aktif terlebih dahulu.
            </div>
        <?php else: ?>
            <form id="pmForm">
                <input type="hidden" id="pmIdPemangku" name="id_pemangku">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Instansi</label>
                    <input type="text" name="nama_instansi" id="pmNamaInstansi"
                        class="form-control"
                        placeholder="Contoh: BPS Provinsi Riau"
                        maxlength="255">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Hubungan</label>
                    <input type="text" name="hubungan" id="pmHubungan"
                        class="form-control"
                        placeholder="Contoh: Penyedia data"
                        maxlength="150">
                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($idKonteks): ?>
        <div class="offcanvas-footer border-top p-3">
            <div class="pk-action-wrapper">

                <!-- VIEW MODE -->
                <div class="pk-mode" id="pmBtnView" style="display:none;">
                    <button type="button" class="btn btn-danger" id="pmBtnDelete">
                        <i class="ti ti-trash"></i>
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                        <button type="button" class="btn btn-warning text-white" id="pmBtnSwitchEdit">
                            <i class="ti ti-pencil me-1"></i> Edit
                        </button>
                    </div>
                </div>

                <!-- CREATE / EDIT MODE -->
                <div class="pk-mode" id="pmBtnEdit" style="display:none;">
                    <button type="button" class="btn btn-light" id="pmBtnCancel">Batal</button>
                    <button type="button" class="btn btn-primary" id="pmBtnSimpan">
                        <i class="ti ti-device-floppy me-1"></i> Simpan
                    </button>
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>