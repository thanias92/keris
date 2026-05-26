<?php
$idKonteks = $activeKonteks['id_konteks'] ?? null;
$teknis    = array_filter($allProses ?? [], fn($p) => $p['jenis_proses'] === 'Teknis');
$nonTeknis = array_filter($allProses ?? [], fn($p) => $p['jenis_proses'] === 'Non-Teknis');
?>

<div class="offcanvas offcanvas-end pk-offcanvas" tabindex="-1" id="offcanvasProsesBisnis">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0">Pilih Proses Bisnis</h5>
            <small class="text-muted">Centang proses yang digunakan pada konteks ini</small>
        </div>
    </div>

    <div class="offcanvas-body">
        <?php if (!$idKonteks): ?>
            <div class="alert alert-warning">
                <i class="ti ti-alert-circle me-1"></i>
                Pilih konteks aktif terlebih dahulu.
            </div>
        <?php else: ?>
            <form id="pbFormSync">
                <input type="hidden" name="id_konteks" value="<?= $idKonteks ?>">

                <div class="row g-3">

                    <!-- KOLOM KIRI: TEKNIS -->
                    <div class="col-6">
                        <p class="fw-semibold text-primary mb-2">Teknis</p>
                        <?php foreach ($teknis as $p): ?>
                            <div class="form-check py-2 border-bottom">
                                <input class="form-check-input" type="checkbox"
                                    name="id_proses[]"
                                    value="<?= $p['id_proses'] ?>"
                                    id="pb_<?= $p['id_proses'] ?>"
                                    <?= in_array($p['id_proses'], $selectedProses ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="pb_<?= $p['id_proses'] ?>">
                                    <span class="badge bg-primary-subtle text-primary me-1">
                                        <?= esc($p['kode_proses']) ?>
                                    </span>
                                    <?= esc($p['uraian_proses']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- KOLOM KANAN: NON-TEKNIS -->
                    <div class="col-6">
                        <p class="fw-semibold text-warning mb-2">Non-Teknis</p>
                        <?php foreach ($nonTeknis as $p): ?>
                            <div class="form-check py-2 border-bottom">
                                <input class="form-check-input" type="checkbox"
                                    name="id_proses[]"
                                    value="<?= $p['id_proses'] ?>"
                                    id="pb_<?= $p['id_proses'] ?>"
                                    <?= in_array($p['id_proses'], $selectedProses ?? []) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="pb_<?= $p['id_proses'] ?>">
                                    <span class="badge bg-warning-subtle text-warning me-1">
                                        <?= esc($p['kode_proses']) ?>
                                    </span>
                                    <?= esc($p['uraian_proses']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($idKonteks): ?>
        <div class="offcanvas-footer border-top p-3">
            <div class="pk-action-wrapper">

                <!-- VIEW MODE -->
                <div class="pk-mode" id="pbBtnView">
                    <button type="button" class="btn btn-danger" id="pbBtnDelete">
                        <i class="ti ti-trash"></i>
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                        <button type="button" class="btn btn-warning text-white" id="pbBtnSwitchEdit">Edit</button>
                    </div>
                </div>

                <!-- EDIT MODE -->
                <div class="pk-mode" id="pbBtnEdit" style="display:none;">
                    <button type="button" class="btn btn-light" id="pbBtnCancelEdit">Batal</button>
                    <button type="button" class="btn btn-primary" id="pbBtnSimpan"> Simpan</button>
                </div>

            </div>
        </div>
    <?php endif; ?>
</div>