<!-- Modal Bank Risiko - posisi tengah atas -->
<div class="modal fade" tabindex="-1" id="modalBankRisiko" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 480px; margin: 80px auto 0;">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header border-bottom">
                <div>
                    <h5 class="modal-title mb-0 fw-semibold" id="bankRisikoModalTitle">Tambah Bank Risiko</h5>
                    <small class="text-muted">Master Data</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">
                <form id="bankRisikoForm">
                    <input type="hidden" id="bankRisikoId" name="id_bank_risiko">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pernyataan Risiko</label>
                        <textarea name="pernyataan_risiko" id="bankRisikoPernyataan"
                            class="form-control" rows="4"
                            placeholder="Contoh: Keterlambatan pelaksanaan tahapan kegiatan"
                            required></textarea>
                        <div class="invalid-feedback" id="bankRisikoPernyataanError"></div>
                    </div>
                </form>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-top">

                <!-- VIEW MODE -->
                <div class="br-mode w-100 d-flex justify-content-between align-items-center" id="bankRisikoBtnView">
                    <button type="button" class="btn btn-danger" id="bankRisikoBtnDelete">
                        <i class="ti ti-trash"></i>
                    </button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning text-white" id="bankRisikoBtnSwitchEdit">Edit</button>
                    </div>
                </div>

                <!-- CREATE / EDIT MODE -->
                <div class="br-mode w-100 d-flex justify-content-end gap-2" id="bankRisikoBtnEdit">
                    <button type="button" class="btn btn-light" id="bankRisikoBtnCancel">Batal</button>
                    <button type="button" class="btn btn-primary" id="bankRisikoBtnSimpan">Simpan</button>
                </div>

            </div>
        </div>
    </div>
</div>