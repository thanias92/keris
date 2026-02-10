<?php if (!isset($filterOptions, $activeFilter)) return; ?>

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form method="get" action="<?= site_url('penetapan-konteks/proses-bisnis') ?>">
            <div class="row gy-3 align-items-end">

                <!-- SATUAN KERJA -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Satuan Kerja</label>
                    <select name="satuan_kerja" class="form-select form-select-sm" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($filterOptions['satuan_kerja'] as $sk): ?>
                            <option value="<?= $sk['id_satuan_kerja'] ?>"
                                <?= ($activeFilter['satuan_kerja'] == $sk['id_satuan_kerja']) ? 'selected' : '' ?>>
                                <?= esc($sk['nama_satuan_kerja']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tahun</label>
                    <select name="tahun" class="form-select form-select-sm" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($filterOptions['tahun'] as $t): ?>
                            <option value="<?= $t ?>"
                                <?= ($activeFilter['tahun'] == $t) ? 'selected' : '' ?>>
                                <?= esc($t) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- SASARAN STRATEGIS -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Sasaran Strategis</label>
                    <select name="sasaran_strategis" class="form-select form-select-sm" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($filterOptions['sasaran_strategis'] as $ss): ?>
                            <option value="<?= $ss['id_sasaran_strategis'] ?>"
                                <?= ($activeFilter['sasaran_strategis'] == $ss['id_sasaran_strategis']) ? 'selected' : '' ?>>
                                <?= esc($ss['kode_sasaran']) ?> - <?= esc($ss['uraian_sasaran']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-md-1">
                    <button class="btn btn-sm btn-primary w-100">
                        Pilih
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>