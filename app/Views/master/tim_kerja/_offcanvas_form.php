<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="tkForm">

    <!-- HEADER -->
    <div class="offcanvas-header border-bottom">

        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold"
                id="tkOffcanvasTitle">
                Tim Kerja & Kegiatan
            </h5>

            <small>Master Data</small>
        </div>

    </div>

    <!-- BODY -->
    <div class="offcanvas-body">

        <input type="hidden" id="tkMode" value="view">
        <input type="hidden" id="tkId">

        <!-- INFORMASI TIM -->
        <div class="tk-info-panel">

            <div class="tk-section-title">
                <i class="ti ti-users me-1"></i>
                Informasi Tim Kerja
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nama Tim Kerja
                </label>

                <input type="text"
                    id="tkNama"
                    class="form-control">
            </div>

        </div>

        <!-- KEGIATAN -->
        <div id="tkKegiatanSection" class="mt-4">

            <div class="tk-section-title">
                <i class="ti ti-list me-1"></i>
                Kegiatan
            </div>

            <div class="tk-kegiatan-card">
                <!-- MODE VIEW -->
                <div id="tkKegiatanView" class="d-none"></div>

                <!-- MODE CREATE / EDIT -->
                <div id="tkKegiatanContainer"></div>

                <template id="tkKegiatanTemplate">
                    <div class="tk-kegiatan-item">

                        <div class="tk-kegiatan-header">
                            <span>Kegiatan</span>

                            <button type="button"
                                class="tk-kegiatan-remove">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>

                        <input type="text"
                            class="form-control tk-kegiatan-input"
                            placeholder="Nama kegiatan">

                    </div>
                </template>

                <div id="tkAddWrapper" class="mt-2">
                    <button type="button"
                        id="tkAddKegiatan"
                        class="btn btn-light btn-sm">
                        <i class="ti ti-plus"></i>
                        Tambah Kegiatan
                    </button>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="d-flex align-items-center pt-3 border-top mt-3">

            <div>
                <button id="tkBtnDelete"
                    class="btn btn-sm btn-danger d-none">
                    <i class="ti ti-trash"></i>
                </button>
            </div>

            <div class="ms-auto d-flex gap-2">

                <button id="tkBtnEdit"
                    class="btn btn-sm btn-warning text-white d-none">
                    <i class="ti ti-pencil me-1"></i>Edit
                </button>

                <button id="tkBtnBatal"
                    class="btn btn-sm btn-light d-none">
                    Batal
                </button>

                <button id="tkBtnSimpan"
                    class="btn btn-sm btn-primary px-4 d-none">
                    <i class="ti ti-device-floppy me-1"></i>Simpan
                </button>

                <button id="tkBtnTutup"
                    class="btn btn-sm btn-light"
                    data-bs-dismiss="offcanvas">
                    Tutup
                </button>

            </div>

        </div>

    </div>

</div>