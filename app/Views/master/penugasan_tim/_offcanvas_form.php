<div class="offcanvas pt-offcanvas" id="ptForm">
    <div class="pt-container">

        <div class="offcanvas-header border-bottom">
            <div>
                <h5 class="offcanvas-title mb-0 fw-semibold" id="ptOffcanvasTitle">Tambah Penugasan</h5>
                <small>Penugasan Tim</small>
            </div>
        </div>

        <div class="offcanvas-body">

            <input type="hidden" id="ptMode" value="view">
            <input type="hidden" id="ptId">

            <div class="mb-3">
                <label class="form-label">Pengelola</label>
                <select id="ptPengelola" class="form-control"></select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tim Kerja</label>
                <select id="ptTimKerja" class="form-control"></select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tahun</label>
                <input type="number" id="ptTahun" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Peran Tim</label>

                <div class="form-check">
                    <input class="form-check-input"
                        type="radio"
                        name="ptRole"
                        id="ptRoleKetua"
                        value="ketua">

                    <label class="form-check-label" for="ptRoleKetua">
                        Ketua Tim
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input"
                        type="radio"
                        name="ptRole"
                        id="ptRoleOperator"
                        value="operator"
                        checked>

                    <label class="form-check-label" for="ptRoleOperator">
                        Operator
                    </label>
                </div>
            </div>

            <div class="d-flex align-items-center pt-3 border-top">
                <div>
                    <button id="ptBtnDelete" class="btn btn-sm btn-danger d-none">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <button id="ptBtnEdit" class="btn btn-sm btn-warning d-none">Edit</button>
                    <button id="ptBtnBatal" class="btn btn-sm btn-light d-none">Batal</button>
                    <button id="ptBtnSimpan" class="btn btn-sm btn-primary d-none">Simpan</button>
                    <button id="ptBtnClose" class="btn btn-sm btn-light">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</div>