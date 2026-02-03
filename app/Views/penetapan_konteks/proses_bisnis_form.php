<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasProsesBisnis"
    style="width: 420px">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 id="offcanvasTitle" class="mb-0 fw-semibold">
                Tambah Proses Bisnis
            </h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">
        <form id="formProsesBisnis"
            method="post"
            action="<?= site_url('penetapan-konteks/proses-bisnis/store') ?>">
            <input type="hidden" name="id_proses" id="id_proses">

            <!-- Jenis Proses -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Jenis Proses</label>
                <div class="d-flex gap-3 mt-2">
                    <label class="form-check border rounded px-3 py-2 flex-fill jenis-card">
                        <input class="form-check-input me-2"
                            type="radio"
                            name="jenis_proses"
                            value="S">
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

            <!-- Kode Proses -->
            <div class="mb-3">
                <label class="form-label">Kode Proses</label>
                <input type="text"
                    id="kode_proses"
                    name="kode_proses"
                    class="form-control bg-light"
                    placeholder="Otomatis"
                    readonly>
            </div>

            <!-- Uraian -->
            <div class="mb-3">
                <label class="form-label">Uraian Proses</label>
                <input type="text"
                    name="uraian_proses"
                    class="form-control"
                    placeholder="Contoh: Pengelolaan Arsip"
                    maxlength="100"
                    required>
            </div>

            <div class="d-flex align-items-center mt-4 pt-3 border-top">
                <div class="me-auto">
                    <button type="button"
                        id="btnDeleteProses"
                        class="btn btn-outline-danger btn-icon d-none"
                        title="Hapus Proses">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                    <button type="button" id="btnEditProses" class="btn btn-warning d-none">Edit</button>
                    <button type="button" id="btnSimpanProses" class="btn btn-primary px-4">Simpan</button>
                </div>
            </div>
        </form>
        <form id="formDeleteProses" method="post" action="" class="d-none">
        </form>
    </div>
</div>

<script>
    /* === OFFCANVAS LIFECYCLE === */
    const offcanvasEl = document.getElementById('offcanvasProsesBisnis');
    let offcanvasInstance = null;

    offcanvasEl.addEventListener('shown.bs.offcanvas', function() {
        if (formMode !== 'create') return;
        const firstRadio = document.querySelector('input[name="jenis_proses"]');
        if (firstRadio) {
            firstRadio.checked = true;
            firstRadio.dispatchEvent(new Event('change'));
        }
    });

    /* === JENIS PROSES → GENERATE KODE === */
    document.querySelectorAll('input[name="jenis_proses"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (formMode !== 'create') return;
            document.querySelectorAll('.jenis-card')
                .forEach(el => el.classList.remove('border-primary', 'bg-light'));

            this.closest('.jenis-card')
                .classList.add('border-primary', 'bg-light');

            fetch(
                    "<?= site_url('penetapan-konteks/proses-bisnis/generate-kode') ?>?jenis=" + this.value
                )
                .then(res => res.json())
                .then(data => {
                    document.querySelector('#kode_proses').value = data.kode;
                });
        });
    });

    /* === PREVENT CLOSE WHEN DIRTY === */
    offcanvasEl.addEventListener('hide.bs.offcanvas', function(e) {
        if (!isDirty) return;

        e.preventDefault();

        Swal.fire({
            title: 'Batalkan perubahan?',
            text: 'Perubahan yang belum disimpan akan hilang.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, tutup',
            cancelButtonText: 'Lanjut edit',
            customClass: {
                popup: 'swal-mantis'
            }
        }).then(result => {
            if (result.isConfirmed) {
                isDirty = false;
                offcanvasInstance.hide();
            }
        });

        if (offcanvasInstance) {
            offcanvasInstance.hide();
        }
    });

    /* === SUBMIT HANDLER (SAVE / UPDATE) === */
    document.getElementById('btnSimpanProses')
        .addEventListener('click', function() {

            if (!checkDirty()) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ada perubahan',
                    text: 'Tidak ada data yang diubah.',
                    customClass: {
                        popup: 'swal-mantis'
                    }
                });
                return;
            }

            const form = document.getElementById('formProsesBisnis');
            const isEdit = document.getElementById('id_proses').value !== '';

            if (isEdit) {
                confirmUpdateProsesBisnis(form);
            } else {
                confirmSaveProsesBisnis(form);
            }
        });
</script>

<script src="<?= base_url('assets/js/proses-bisnis.alert.js') ?>"></script>