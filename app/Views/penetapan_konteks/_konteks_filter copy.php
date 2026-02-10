<?php if (isset($filterOptions)): ?>
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">

            <div class="row gy-3">

                <!-- ROW 1 -->
                <div class="col-md-6">
                    <div class="row align-items-center">
                        <label class="col-4 text-muted small">Satuan Kerja</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm filter-input" data-filter="satuan_kerja">
                                <?php foreach ($filterOptions['satuan_kerja'] as $sk): ?>
                                    <option value="<?= $sk['id_satuan_kerja'] ?>">
                                        <?= esc($sk['nama_satuan_kerja']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row align-items-center">
                        <label class="col-4 text-muted small">Tahun</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm filter-input" data-filter="tahun">
                                <option value="">Semua</option>
                                <?php foreach ($filterOptions['tahun'] as $v): ?>
                                    <option value="<?= esc($v) ?>"><?= esc($v) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ROW 2 -->
                <div class="col-md-6">
                    <div class="row align-items-center">
                        <label class="col-4 text-muted small">Pengelola Risiko</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm filter-input" data-filter="pengelola_risiko">
                                <option value="">Semua</option>
                                <?php foreach ($filterOptions['pengelola_risiko'] as $v): ?>
                                    <option value="<?= esc($v) ?>"><?= esc($v) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row align-items-center">
                        <label class="col-4 text-muted small">Sasaran Strategis</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm filter-input" data-filter="sasaran_strategis">
                                <?php foreach ($filterOptions['sasaran_strategis'] as $v): ?>
                                    <option value="<?= esc($v['id_sasaran_strategis']) ?>">
                                        <?= esc($v['kode_sasaran']) ?> - <?= esc($v['uraian_sasaran']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                </div>

                <!-- ROW 3 -->
                <div class="col-md-6">
                    <div class="row align-items-center">
                        <label class="col-4 text-muted small">Kegiatan</label>
                        <div class="col-8">
                            <select class="form-select form-select-sm filter-input" data-filter="kegiatan">
                                <option value="">Semua</option>
                                <?php foreach ($filterOptions['kegiatan'] as $v): ?>
                                    <option value="<?= esc($v) ?>"><?= esc($v) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex align-items-end justify-content-end">
                    <button type="button"
                        class="btn btn-sm btn-outline-secondary px-4"
                        id="btnResetFilter">
                        Reset
                    </button>
                </div>

            </div>

        </div>
    </div>
<?php endif; ?>