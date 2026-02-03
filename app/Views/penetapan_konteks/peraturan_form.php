<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasPeraturan"
    style="width:420px">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 id="offcanvasTitlePeraturan" class="mb-0 fw-semibold">
                Tambah Peraturan Terkait
            </h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <form id="formPeraturan"
            method="post"
            action="<?= site_url('penetapan-konteks/peraturan/store') ?>">

            <?= csrf_field() ?>

            <input type="hidden" name="id_peraturan" id="id_peraturan">

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Peraturan</label>
                <input type="text"
                    name="nama_peraturan"
                    id="nama_peraturan"
                    class="form-control"
                    placeholder="Contoh: Undang-undang No. 16 Tahun 1997 tentang Statistik"
                    maxlength="255"
                    required>
            </div>

            <div class="d-flex align-items-center mt-4 pt-3 border-top">
                <div class="me-auto">
                    <button type="button"
                        id="btnDeletePeraturan"
                        class="btn btn-outline-danger btn-icon d-none"
                        title="Hapus Peraturan">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="offcanvas">
                        Tutup
                    </button>

                    <button type="button"
                        id="btnEditPeraturan"
                        class="btn btn-warning d-none">
                        Edit
                    </button>

                    <button type="button"
                        id="btnSimpanPeraturan"
                        class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        <!-- FORM DELETE -->
        <form id="formDeletePeraturan" method="post">
            <?= csrf_field() ?>
        </form>
    </div>
</div>