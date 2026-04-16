<div class="offcanvas kg-offcanvas" id="kgForm">
    <div class="kg-container">
        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title mb-0 fw-semibold">Tambah Kegiatan</h5>
                <small>Kegiatan</small>
            </div>
        </div>

        <div class="offcanvas-body">

            <input type="hidden" id="kgMode" value="view">
            <input type="hidden" id="kgId">

            <div class="mb-3">
                <label class="form-label">Satuan Kerja</label>
                <select id="kgSatuanKerja" class="form-control"></select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Kegiatan</label>
                <input type="text" id="kgNama" class="form-control">
            </div>

            <div class="d-flex align-items-center pt-3 border-top">
                <div>
                    <button id="kgBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button id="kgBtnEdit" class="btn btn-sm btn-warning d-none">Edit</button>
                    <button id="kgBtnBatal" class="btn btn-sm btn-light d-none">Batal</button>
                    <button id="kgBtnSimpan" class="btn btn-sm btn-primary d-none">Simpan</button>
                    <button id="kgBtnClose" class="btn btn-sm btn-light">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>