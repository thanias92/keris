<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="modal fade" id="modalAnalisisRisiko" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="formAnalisisRisiko">

                <div class="modal-header">
                    <h5 class="mb-0">Analisis Risiko</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id_identifikasi" id="modalId">

                    <!-- KODE + NILAI -->
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <div class="text-muted small">Kode Risiko</div>
                            <div class="fs-5 fw-semibold" id="modalKode">-</div>
                        </div>

                        <div class="text-center">
                            <div id="modalNilaiRisiko" class="badge fs-4 px-3 py-2 mb-1">-</div>
                            <div id="modalLevelRisiko" class="small text-muted">-</div>
                        </div>
                    </div>

                    <!-- PERNYATAAN -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pernyataan Risiko</label>
                        <div id="modalPernyataan" class="form-control bg-light" style="min-height:48px">-</div>
                    </div>

                    <!-- P D E -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Probability (P)</label>
                            <select id="modalP" name="kemungkinan" class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Dampak (D)</label>
                            <select id="modalD" name="dampak" class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Efektivitas</label>
                            <select id="modalEfektivitas" name="efektivitas_pengendalian" class="form-select" disabled>
                                <option>Efektif</option>
                                <option>Kurang Efektif</option>
                                <option>Tidak Efektif</option>
                            </select>
                        </div>
                    </div>

                    <!-- PENGENDALIAN -->
                    <div class="mb-3">
                        <label class="form-label">Pengendalian Eksisting</label>
                        <textarea id="modalPengendalian" name="pengendalian_eksisting" rows="4"
                            class="form-control" disabled></textarea>
                    </div>

                    <!-- CATATAN -->
                    <div class="mb-2">
                        <label class="form-label">Catatan Analisis</label>
                        <textarea id="modalCatatan" name="catatan_analisis" rows="4"
                            class="form-control" disabled></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnEdit" class="btn btn-warning">Ubah</button>
                    <button type="button" id="btnSimpan" class="btn btn-primary d-none">Simpan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>

            </form>
        </div>
    </div>
</div>