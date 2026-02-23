<?php

/**
 * REQUIREMENTS:
 * - $listKonteks      (array)
 * - $activeKonteks   (array|null)
 */

if (!isset($listKonteks)) {
    return;
}

$selectedId = $activeKonteks['id_konteks'] ?? '';
?>

<!-- CONTEXT SELECTOR -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">

        <form method="post" action="<?= site_url('penetapan-konteks/set-active-konteks') ?>">
            <?= csrf_field() ?>

            <!-- WAJIB: agar balik ke tab yang sama -->
            <input type="hidden" name="redirect" value="<?= current_url() ?>">

            <div class="row g-3 align-items-end">

                <!-- SATUAN KERJA -->
                <div class="col-md-4">
                    <label class="form-label text-muted small">Satuan Kerja</label>
                    <select class="form-select" disabled>
                        <option>
                            <?= $activeKonteks
                                ? esc($activeKonteks['nama_satuan_kerja'])
                                : '-- Pilih --' ?>
                        </option>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-3">
                    <label class="form-label text-muted small">Tahun</label>
                    <select class="form-select" disabled>
                        <option>
                            <?= $activeKonteks
                                ? esc($activeKonteks['tahun'])
                                : '-- Pilih --' ?>
                        </option>
                    </select>
                </div>

                <!-- SASARAN STRATEGIS -->
                <div class="col-md-3">
                    <label class="form-label text-muted small">Sasaran Strategis</label>
                    <select class="form-select" disabled>
                        <option>
                            <?= $activeKonteks
                                ? esc($activeKonteks['uraian_sasaran'])
                                : '-- Pilih --' ?>
                        </option>
                    </select>
                </div>

                <!-- TERAPKAN -->
                <div class="col-md-2">
                    <label class="form-label text-muted small d-block">&nbsp;</label>

                    <!-- SELECT KONTEKS SEBENARNYA (HIDDEN STYLE) -->
                    <select name="id_konteks" class="form-select d-none" required>
                        <option value="">-- Pilih Konteks --</option>
                        <?php foreach ($listKonteks as $k): ?>
                            <option value="<?= $k['id_konteks'] ?>"
                                <?= $selectedId == $k['id_konteks'] ? 'selected' : '' ?>>
                                <?= esc($k['nama_satuan_kerja']) ?>
                                · <?= esc($k['tahun']) ?>
                                · <?= esc($k['uraian_sasaran']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary w-100">
                        Terapkan
                    </button>
                </div>

            </div>
        </form>

    </div>
</div>