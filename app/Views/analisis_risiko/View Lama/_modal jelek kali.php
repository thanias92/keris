<div class="modal fade" id="modalAnalisisRisiko" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <form id="formAnalisisRisiko">

                <!-- HEADER -->
                <div class="modal-header py-2">
                    <div>
                        <h6 class="mb-0">Analisis Risiko</h6>
                        <small class="text-muted">
                            Kode: <strong id="modalKode"></strong>
                        </small>
                    </div>

                    <div class="ms-auto text-end">
                        <span id="modalNilaiRisiko"
                            class="badge bg-secondary px-3 py-1">
                            -
                        </span>
                        <small id="modalLevelRisiko"
                            class="d-block text-muted">
                            -
                        </small>
                    </div>

                    <button type="button"
                        class="btn-close ms-2"
                        data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">
                    <input type="hidden" name="id_identifikasi" id="modalId">

                    <!-- PERNYATAAN -->
                    <div class="mb-3">
                        <label class="form-label text-muted">
                            Pernyataan Risiko
                        </label>
                        <div id="modalPernyataan"
                            class="p-3 bg-light border rounded small">
                        </div>
                    </div>

                    <!-- P D EFEKTIVITAS -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Probability (P)</label>
                            <select id="modalP" name="kemungkinan"
                                class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Dampak (D)</label>
                            <select id="modalD" name="dampak"
                                class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Efektivitas</label>
                            <select id="modalEfektivitas"
                                name="efektivitas_pengendalian"
                                class="form-select" disabled>
                                <option>Efektif</option>
                                <option>Kurang Efektif</option>
                                <option>Tidak Efektif</option>
                            </select>
                        </div>
                    </div>

                    <!-- PENGENDALIAN -->
                    <div class="mb-3">
                        <label class="form-label">
                            Pengendalian Eksisting
                        </label>
                        <textarea id="modalPengendalian" rows="2"></textarea>
                        <small class="text-muted">
                            Gunakan Enter untuk poin otomatis
                        </small>
                    </div>

                    <!-- CATATAN -->
                    <div>
                        <label class="form-label">Catatan Analisis</label>
                        <textarea id="modalCatatan" rows="2"></textarea>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button"
                        id="btnEdit"
                        class="btn btn-warning">
                        Ubah
                    </button>

                    <button type="submit"
                        id="btnSimpan"
                        class="btn btn-primary d-none">
                        Simpan
                    </button>

                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>