<div class="offcanvas sk-offcanvas" id="tkForm">

    <div class="sk-container">

        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title mb-0 fw-semibold">Tambah Tim Kerja & Kegiatan</h5>
                <small>Tim Kerja & Kegiatan</small>
            </div>
        </div>

        <div class="offcanvas-body">

            <input type="hidden" id="tkMode" value="view">
            <input type="hidden" id="tkId">

            <div class="mb-3">
                <label class="form-label">Nama Tim Kerja</label>
                <input type="text" id="tkNama" class="form-control">
            </div>

            <div class="mt-4">
                <label class="form-label fw-semibold">
                    Kegiatan
                </label>

                <div id="tkKegiatanList">
                    Memuat...
                </div>
            </div>

            <div class="d-flex align-items-center pt-3 border-top">

                <div>
                    <button id="tkBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button id="tkBtnEdit" class="btn btn-sm btn-warning d-none">Edit</button>
                    <button id="tkBtnBatal" class="btn btn-sm btn-light d-none">Batal</button>
                    <button id="tkBtnSimpan" class="btn btn-sm btn-primary d-none">Simpan</button>
                    <button class="btn btn-sm btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                </div>

            </div>

        </div>

    </div>

</div>