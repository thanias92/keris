<div class="offcanvas pk-offcanvas-rl"
    tabindex="-1"
    id="offcanvasCreatePemangku">

    <div class="offcanvas-header border-bottom">

        <div>
            <h5 class="offcanvas-title mb-0 fw-semibold">
                Tambah Pemangku Kepentingan
            </h5>

            <small class="text-muted">
                Master Pemangku Kepentingan
            </small>
        </div>

    </div>

    <div class="offcanvas-body">
        <form id="pmQuickCreateForm">
            <div class="mb-3">
                <label class="ar-form-label">
                    Nama Instansi
                    <span class="text-danger">*</span>
                </label>

                <input type="text"
                    class="form-control"
                    id="pmQuickNama"
                    name="nama_instansi"
                    required>

            </div>

            <div class="mb-3">

                <label class="ar-form-label">
                    Hubungan
                    <span class="text-danger">*</span>
                </label>

                <select class="form-select"
                    id="pmQuickHubungan"
                    name="hubungan"
                    required>

                    <option value="">
                        Pilih Hubungan
                    </option>

                    <option value="Pembina">
                        Pembina
                    </option>

                    <option value="Pimpinan Lembaga">
                        Pimpinan Lembaga
                    </option>

                    <option value="Mitra Kerja Internal">
                        Mitra Kerja Internal
                    </option>

                    <option value="Mitra Kerja Eksternal">
                        Mitra Kerja Eksternal
                    </option>

                </select>

            </div>

            <hr class="ar-divider">

            <div class="d-flex justify-content-end gap-2">

                <button type="button"
                    class="btn btn-sm btn-light"
                    data-bs-dismiss="offcanvas"> Batal
                </button>

                <button type="submit"
                    class="btn btn-sm btn-primary px-4">
                    <i class="ti ti-device-floppy me-1"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>