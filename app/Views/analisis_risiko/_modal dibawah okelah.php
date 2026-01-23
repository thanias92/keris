<div class="modal fade" id="modalAnalisisRisiko" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="formAnalisisRisiko">

                <!-- HEADER -->
                <div class="modal-header">
                    <div>
                        <h5 class="mb-0">Analisis Risiko</h5>
                        <small class="text-muted">
                            Kode: <strong id="modalKode"></strong>
                        </small>
                    </div>

                    <div class="ms-auto text-end">
                        <span id="modalNilaiRisiko"
                            class="badge fs-4 px-3 py-2">
                            -
                        </span>
                        <small id="modalLevelRisiko"
                            class="d-block text-muted">
                            -
                        </small>
                    </div>
                </div>

                <!-- BODY (SCROLLABLE FIX) -->
                <div class="modal-body"
                    style="max-height:70vh; overflow-y:auto;">

                    <input type="hidden" name="id_identifikasi" id="modalId">

                    <!-- Pernyataan Risiko -->
                    <div class="card mb-3">
                        <div class="card-header py-2">
                            <strong>Pernyataan Risiko</strong>
                        </div>
                        <div class="card-body small" id="modalPernyataan">
                            -
                        </div>
                    </div>

                    <!-- Skor -->
                    <div class="row g-3 mb-3">
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

                    <!-- Pengendalian -->
                    <div class="mb-3">
                        <label class="form-label">Pengendalian Eksisting</label>
                        <textarea id="modalPengendalian"
                            name="pengendalian"
                            rows="4"
                            class="form-control"
                            disabled></textarea>
                        <small class="text-muted">
                            Gunakan Enter untuk poin otomatis
                        </small>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-2">
                        <label class="form-label">Catatan Analisis</label>
                        <textarea id="modalCatatan"
                            name="catatan_analisis"
                            rows="4"
                            class="form-control"
                            disabled></textarea>
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