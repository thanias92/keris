<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasPemangkuKepentingan"
    style="width:420px">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 id="offcanvasTitlePemangku" class="mb-0 fw-semibold">
                Tambah Pemangku Kepentingan
            </h5>
            <small class="text-muted">Pemangku Kepentingan</small>
        </div>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <form id="formPemangkuKepentingan"
            method="post"
            action="<?= site_url('penetapan-konteks/pemangku/store') ?>">

            <input type="hidden" name="id_pemangku" id="id_pemangku">

            <!-- ===============================
                 NAMA INSTANSI
            ================================ -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Instansi</label>
                <input type="text"
                    name="nama_instansi"
                    id="nama_instansi"
                    class="form-control"
                    placeholder="Contoh: BPS Provinsi Riau"
                    maxlength="255"
                    required>
            </div>

            <!-- ===============================
                 HUBUNGAN
            ================================ -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Hubungan</label>
                <input type="text"
                    name="hubungan"
                    id="hubungan"
                    class="form-control"
                    placeholder="Contoh: Penyedia data"
                    maxlength="150"
                    required>
            </div>

            <!-- ===============================
                 ACTION BUTTON
            ================================ -->
            <div class="d-flex align-items-center mt-4 pt-3 border-top">
                <div class="me-auto">
                    <button type="button"
                        id="btnDeletePemangku"
                        class="btn btn-outline-danger btn-icon d-none"
                        title="Hapus Pemangku Kepentingan">
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
                        id="btnEditPemangku"
                        class="btn btn-warning d-none">
                        Edit
                    </button>

                    <button type="button"
                        id="btnSimpanPemangku"
                        class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>
            </div>

        </form>

        <!-- FORM DELETE -->
        <form id="formDeletePemangku" method="post" class="d-none"></form>

    </div>
</div>