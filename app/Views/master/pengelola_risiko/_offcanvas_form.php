<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="prForm">

    <div class="offcanvas-header border-bottom">

        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold"
                id="prOffcanvasTitle">
                Pengelola Risiko
            </h5>

            <small>Master Data</small>
        </div>

    </div>

    <div class="offcanvas-body">

        <input type="hidden" id="prMode" value="view">
        <input type="hidden" id="prId">

        <!-- INFORMASI PENGELOLA -->

        <div class="pr-info-panel">

            <div class="pr-section-title">
                <i class="ti ti-user me-1"></i>
                Informasi Pengelola
            </div>

            <div class="mb-3">
                <label class="form-label">Nama</label>

                <input type="text"
                    id="prNama"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NIP</label>

                <input type="text"
                    id="prNip"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>

                <input type="text"
                    id="prJabatan"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Wilayah</label>

                <select id="prWilayah"
                    class="form-select" required>
                    <option value="">Pilih Wilayah</option>
                </select>
            </div>

        </div>

        <!-- PENGATURAN -->

        <div class="mt-4">

            <div class="pr-section-title">
                <i class="ti ti-settings me-1"></i>
                Pengaturan
            </div>

            <div class="form-check mb-2">
                <input type="checkbox"
                    class="form-check-input"
                    id="prPemilik">

                <label class="form-check-label"
                    for="prPemilik">
                    Pemilik Risiko
                </label>
            </div>

            <div class="form-check">
                <input type="checkbox"
                    class="form-check-input"
                    id="prAktif">

                <label class="form-check-label"
                    for="prAktif">
                    Aktif
                </label>
            </div>

        </div>

        <!-- FOOTER -->

        <div class="d-flex align-items-center pt-3 border-top mt-3">

            <div>
                <button id="prBtnDelete"
                    class="btn btn-sm btn-danger d-none">
                    <i class="ti ti-trash"></i>
                </button>
            </div>

            <div class="ms-auto d-flex gap-2">
                <button id="prBtnEdit"
                    class="btn btn-sm btn-warning text-white d-none">
                    <i class="ti ti-pencil me-1"></i>Edit
                </button>

                <button id="prBtnBatal"
                    class="btn btn-sm btn-light d-none">
                    Batal
                </button>

                <button id="prBtnSimpan"
                    class="btn btn-sm btn-primary px-4 d-none">
                    <i class="ti ti-device-floppy me-1"></i>Simpan
                </button>

                <button id="prBtnTutup"
                    class="btn btn-sm btn-light"
                    data-bs-dismiss="offcanvas">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>