<div class="offcanvas ss-offcanvas" id="ssForm">
    <div class="ss-container">

        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title mb-0 fw-semibold" id="ssOffcanvasTitle">Tambah Sasaran</h5>
                <small>Sasaran Strategis</small>
            </div>
        </div>

        <div class="offcanvas-body">

            <input type="hidden" id="ssMode" value="view">
            <input type="hidden" id="ssId">

            <div class="mb-3">
                <label class="form-label">Kode</label>
                <input type="text" id="ssKode" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Uraian</label>
                <input type="text" id="ssUraian" class="form-control">
            </div>

            <div class="d-flex align-items-center pt-3 border-top">
                <div>
                    <button id="ssBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button id="ssBtnEdit" class="btn btn-sm btn-warning d-none">Edit</button>
                    <button id="ssBtnBatal" class="btn btn-sm btn-light d-none">Batal</button>
                    <button id="ssBtnSimpan" class="btn btn-sm btn-primary d-none">Simpan</button>
                    <button id="ssBtnClose" class="btn btn-sm btn-light">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>