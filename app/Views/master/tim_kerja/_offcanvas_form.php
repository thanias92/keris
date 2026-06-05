<div class="offcanvas sk-offcanvas" id="skForm">

    <div class="sk-container">

        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title mb-0 fw-semibold">Tambah Tim Kerja</h5>
                <small>Tim Kerja</small>
            </div>
        </div>

        <div class="offcanvas-body">

            <input type="hidden" id="skMode" value="view">
            <input type="hidden" id="skId">

            <div class="mb-3">
                <label class="form-label">Nama Tim Kerja</label>
                <input type="text" id="skNama" class="form-control">
            </div>

            <div class="d-flex align-items-center pt-3 border-top">

                <div>
                    <button id="skBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button id="skBtnEdit" class="btn btn-sm btn-warning d-none">Edit</button>
                    <button id="skBtnBatal" class="btn btn-sm btn-light d-none">Batal</button>
                    <button id="skBtnSimpan" class="btn btn-sm btn-primary d-none">Simpan</button>
                    <button class="btn btn-sm btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                </div>

            </div>

        </div>

    </div>

</div>