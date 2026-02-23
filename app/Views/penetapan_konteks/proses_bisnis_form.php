<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasProsesBisnis"
    style="width:420px">

    <!-- ================= HEADER ================= -->
    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 id="offcanvasTitle" class="mb-0 fw-semibold">
                Tambah Proses Bisnis
            </h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
    </div>

    <!-- ================= BODY ================= -->
    <div class="offcanvas-body">

        <!-- ===== INFO KONTEKS (BAGIAN B) ===== -->
        <div class="card bg-light border-0 mb-3">
            <div class="card-body py-2">
                <div class="row small text-muted">
                    <div class="col-6">
                        <strong>Satuan Kerja</strong><br>
                        <?= esc($activeKonteks['nama_satuan_kerja'] ?? '-') ?>
                    </div>
                    <div class="col-6">
                        <strong>Tahun</strong><br>
                        <?= esc($activeKonteks['tahun'] ?? '-') ?>
                    </div>
                    <div class="col-6 mt-2">
                        <strong>Kegiatan</strong><br>
                        <?= esc($activeKonteks['kegiatan'] ?? '-') ?>
                    </div>
                    <div class="col-6 mt-2">
                        <strong>Sasaran Strategis</strong><br>
                        <?= esc($activeKonteks['uraian_sasaran'] ?? '-') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= FORM ================= -->
        <form id="formProsesBisnis"
            method="post"
            action="<?= site_url('penetapan-konteks/proses-bisnis/store') ?>">

            <?= csrf_field() ?>

            <input type="hidden" name="id_proses" id="id_proses">
            <input type="hidden" name="id_konteks" id="id_konteks"
                value="<?= esc($activeKonteks['id_konteks'] ?? '') ?>">

            <!-- ===== JENIS PROSES (UI ASLI) ===== -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Jenis Proses</label>
                <div class="d-flex gap-3 mt-2">

                    <label class="form-check border rounded px-3 py-2 flex-fill jenis-card">
                        <input class="form-check-input me-2"
                            type="radio"
                            name="jenis_proses"
                            value="S"
                            required>
                        <strong>Teknis</strong>
                        <div class="text-muted small">Proses inti operasional</div>
                    </label>

                    <label class="form-check border rounded px-3 py-2 flex-fill jenis-card">
                        <input class="form-check-input me-2"
                            type="radio"
                            name="jenis_proses"
                            value="K">
                        <strong>Non-Teknis</strong>
                        <div class="text-muted small">Proses pendukung</div>
                    </label>

                </div>
            </div>

            <!-- ===== KODE ===== -->
            <div class="mb-3">
                <label class="form-label">Kode Proses</label>
                <input type="text"
                    id="kode_proses"
                    name="kode_proses"
                    class="form-control bg-light"
                    placeholder="Otomatis"
                    readonly>
            </div>

            <!-- ===== URAIAN ===== -->
            <div class="mb-3">
                <label class="form-label">Uraian Proses</label>
                <input type="text"
                    name="uraian_proses"
                    class="form-control"
                    maxlength="100"
                    required>
            </div>

            <!-- ================= ACTION ================= -->
            <div class="d-flex align-items-center gap-2 pt-3 border-top">

                <div class="me-auto">
                    <button type="button"
                        id="btnDeleteProses"
                        class="btn btn-outline-danger btn-icon d-none"
                        title="Hapus">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <button type="button"
                    class="btn btn-light"
                    data-bs-dismiss="offcanvas">
                    Tutup
                </button>

                <button type="button"
                    id="btnEditProses"
                    class="btn btn-warning d-none">
                    Edit
                </button>

                <button type="button"
                    id="btnSimpanProses"
                    class="btn btn-primary px-4">
                    Simpan
                </button>

            </div>
        </form>

        <!-- DELETE FORM -->
        <form id="formDeleteProses" method="post" class="d-none"></form>
    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
    /* === GENERATE KODE === */
    document.querySelectorAll('input[name="jenis_proses"]').forEach(radio => {
        radio.addEventListener('change', function() {

            document.querySelectorAll('.jenis-card')
                .forEach(el => el.classList.remove('border-primary', 'bg-light'));

            this.closest('.jenis-card')
                .classList.add('border-primary', 'bg-light');

            fetch(
                    "<?= site_url('penetapan-konteks/proses-bisnis/generate-kode') ?>?jenis=" + this.value
                )
                .then(r => r.json())
                .then(d => document.getElementById('kode_proses').value = d.kode);
        });
    });

    /* === SUBMIT HANDLER === */
    document.getElementById('btnSimpanProses')
        .addEventListener('click', function() {

            const form = document.getElementById('formProsesBisnis');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (formMode === 'edit') {
                confirmUpdateProsesBisnis(form);
            } else {
                confirmSaveProsesBisnis(form);
            }
        });
</script>

<!-- SWEET ALERT -->
<script src="<?= base_url('assets/js/proses-bisnis.alert.js') ?>"></script>