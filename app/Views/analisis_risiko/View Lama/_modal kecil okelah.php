<div class="modal fade" id="modalAnalisisRisiko" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="formAnalisisRisiko">
                <div class="modal-header">
                    <h5 class="modal-title">Analisis Risiko</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_identifikasi" id="modalId">

                    <div class="mb-2">
                        <small>Kode Risiko</small>
                        <div class="fw-bold" id="modalKode"></div>
                    </div>

                    <div class="mb-3">
                        <small>Pernyataan Risiko</small>
                        <div id="modalPernyataan"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label>P</label>
                            <select id="modalP" name="kemungkinan" class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>D</label>
                            <select id="modalD" name="dampak" class="form-select" disabled>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Efektivitas</label>
                            <select id="modalEfektivitas" name="efektivitas_pengendalian" class="form-select" disabled>
                                <option>Efektif</option>
                                <option>Kurang Efektif</option>
                                <option>Tidak Efektif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Pengendalian Eksisting</label>
                        <textarea id="modalPengendalian" name="pengendalian_eksisting"
                            class="form-control" disabled></textarea>
                    </div>

                    <div class="mt-3">
                        <label>Catatan Analisis</label>
                        <textarea id="modalCatatan" name="catatan_analisis"
                            class="form-control" disabled></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnEdit" class="btn btn-warning">Ubah</button>
                    <button type="submit" id="btnSimpan" class="btn btn-primary d-none">Simpan</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>

        </div>
    </div>
</div>