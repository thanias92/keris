<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="muForm">

    <div class="offcanvas-header border-bottom">

        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold"
                id="muOffcanvasTitle">
                Detail User
            </h5>

            <small>Manajemen User</small>
        </div>

    </div>

    <div class="offcanvas-body">

        <input type="hidden" id="muMode" value="view">
        <input type="hidden" id="muId">

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text"
                id="muNama"
                class="form-control"
                placeholder="Masukkan nama user">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email"
                id="muEmail"
                class="form-control"
                placeholder="Masukkan email user">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>

            <div class="position-relative">
                <input type="password"
                    id="muPassword"
                    class="form-control pe-5"
                    placeholder="Masukkan password">

                <button type="button"
                    id="muTogglePassword"
                    class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent">
                    <i class="ti ti-eye"></i>
                </button>
            </div>

            <small id="muPasswordHint" class="text-muted">
                Kosongkan jika tidak ingin mengganti password
            </small>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>

            <select id="muRole"
                class="form-select">
                <option value="">Pilih Role</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tim Kerja</label>

            <select id="muTim"
                class="form-select">
                <option value="">Pilih Tim Kerja</option>
            </select>
        </div>

        <div class="d-flex align-items-center pt-3 border-top mt-3">

            <div>
                <button id="muBtnDelete"
                    class="btn btn-sm btn-danger d-none">
                    <i class="ti ti-trash"></i>
                </button>
            </div>

            <div class="ms-auto d-flex gap-2">

                <button id="muBtnEdit"
                    class="btn btn-sm btn-warning text-white d-none">
                    <i class="ti ti-pencil me-1"></i>Edit
                </button>

                <button id="muBtnBatal"
                    class="btn btn-sm btn-light d-none">
                    Batal
                </button>

                <button id="muBtnSimpan"
                    class="btn btn-sm btn-primary px-4 d-none">
                    <i class="ti ti-device-floppy me-1"></i>Simpan
                </button>

                <button id="muBtnTutup"
                    class="btn btn-sm btn-light">
                    Tutup
                </button>

            </div>

        </div>

    </div>

</div>