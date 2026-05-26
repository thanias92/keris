<?php
$idKonteks = $activeKonteks['id_konteks'] ?? null;
?>

<div class="offcanvas pk-offcanvas-rl"
    tabindex="-1"
    id="offcanvasProsesBisnis">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold" id="pbTitle">
                Tambah Proses Bisnis
            </h5>

            <small class="text-muted">
                Penetapan Konteks
            </small>
        </div>
    </div>

    <div class="offcanvas-body">

        <form id="pbForm" novalidate>

            <input type="hidden"
                name="id_konteks"
                value="<?= $idKonteks ?>">

            <input type="hidden"
                name="id_konteks_proses"
                id="pbId">

            <input type="hidden"
                id="pbMode"
                value="create">

            <div id="pbInfoPanel"
                class="ar-info-panel d-none">

                <div class="ar-section-title">
                    <i class="ti ti-info-circle me-1"></i>
                    Detail Proses Bisnis
                </div>

                <div class="ar-info-row">
                    <span class="ar-info-label">Kode</span>
                    <span class="ar-info-value" id="pbViewKode">-</span>
                </div>

                <div class="ar-info-row">
                    <span class="ar-info-label">Jenis</span>
                    <span class="ar-info-value" id="pbViewJenis">-</span>
                </div>

                <div class="ar-info-row">
                    <span class="ar-info-label">Proses Bisnis</span>
                    <span class="ar-info-value" id="pbViewNama">-</span>
                </div>

            </div>

            <div id="pbInputZone">

                <div class="mb-3">

                    <label class="ar-form-label">
                        Proses Bisnis
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-select"
                        name="id_proses"
                        id="pbProses"
                        required>

                        <option value="">
                            Pilih Proses Bisnis
                        </option>

                        <?php foreach (($allProses ?? []) as $p): ?>
                            <option value="<?= $p['id_proses'] ?>">
                                [<?= esc($p['kode_proses']) ?>]
                                <?= esc($p['uraian_proses']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="ar-form-label">
                        Deskripsi Proses
                    </label>

                    <textarea class="form-control"
                        rows="5"
                        name="deskripsi_proses"
                        id="pbDeskripsi"
                        placeholder="Jelaskan proses bisnis pada konteks ini..."
                        required></textarea>

                </div>

                <div class="mb-2">
                    <label class="ar-form-label">Sasaran Kinerja</label>
                    <textarea class="form-control"
                        rows="5"
                        name="uraian_sasaran"
                        id="pbSasaran"
                        placeholder="Masukkan sasaran kinerja proses bisnis..."
                        required></textarea>

                </div>

            </div>

            <hr class="ar-divider">

            <div class="d-flex align-items-center pt-2 border-top mt-1">

                <div>
                    <button type="button"
                        id="pbBtnDelete"
                        class="btn btn-sm btn-danger d-none">

                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">

                    <button type="button"
                        id="pbBtnEdit"
                        class="btn btn-sm btn-warning text-white d-none">

                        Edit
                    </button>

                    <button type="button"
                        id="pbBtnBatal"
                        class="btn btn-sm btn-light"
                        data-bs-dismiss="offcanvas">

                        Batal
                    </button>

                    <button type="submit"
                        id="pbBtnSave"
                        class="btn btn-sm btn-primary px-4">

                        <i class="ti ti-device-floppy me-1"></i>
                        Simpan
                    </button>

                    <button type="button"
                        id="pbBtnTutup"
                        class="btn btn-sm btn-light d-none"
                        data-bs-dismiss="offcanvas">

                        Tutup
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>