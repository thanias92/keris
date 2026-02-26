<?php
$filters = $filters ?? [];

$selectedSk = $filters['sk'] ?? '';
$selectedPr = $filters['pr'] ?? '';
$selectedTh = $filters['th'] ?? '';
$selectedKg = $filters['kg'] ?? '';
$selectedSs = $filters['ss'] ?? '';

// Ambil distinct value
$skList = array_unique(array_column($listKonteks, 'nama_satuan_kerja'));
$prList = array_unique(array_column($listKonteks, 'pengelola_risiko'));
$thList = array_unique(array_column($listKonteks, 'tahun'));
$kgList = array_unique(array_column($listKonteks, 'kegiatan'));
$ssList = array_unique(array_column($listKonteks, 'uraian_sasaran'));
?>

<div class="card shadow-sm mb-4">
    <div class="card-body">

        <form id="contextFilterForm" method="get" action="<?= site_url('penetapan-konteks') ?>">

            <div class="row g-3 align-items-end">

                <div class="col-md">
                    <label class="form-label small text-muted">Satuan Kerja</label>
                    <select name="sk" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($skList as $sk): ?>
                            <option value="<?= esc($sk) ?>"
                                <?= $selectedSk == $sk ? 'selected' : '' ?>>
                                <?= esc($sk) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md">
                    <label class="form-label small text-muted">Pengelola Risiko</label>
                    <select name="pr" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($prList as $pr): ?>
                            <option value="<?= esc($pr) ?>"
                                <?= $selectedPr == $pr ? 'selected' : '' ?>>
                                <?= esc($pr) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md">
                    <label class="form-label small text-muted">Tahun</label>
                    <select name="th" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($thList as $th): ?>
                            <option value="<?= esc($th) ?>"
                                <?= $selectedTh == $th ? 'selected' : '' ?>>
                                <?= esc($th) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md">
                    <label class="form-label small text-muted">Kegiatan</label>
                    <select name="kg" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($kgList as $kg): ?>
                            <option value="<?= esc($kg) ?>"
                                <?= $selectedKg == $kg ? 'selected' : '' ?>>
                                <?= esc($kg) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md">
                    <label class="form-label small text-muted">Sasaran Strategis</label>
                    <select name="ss" class="form-select">
                        <option value="">Semua</option>
                        <?php foreach ($ssList as $ss): ?>
                            <option value="<?= esc($ss) ?>"
                                <?= $selectedSs == $ss ? 'selected' : '' ?>>
                                <?= esc($ss) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-auto d-flex gap-2 pk-filter">
                    <button type="submit"
                        class="btn btn-primary btn-icon"
                        title="Terapkan Filter">
                        <i class="ti ti-search"></i>
                    </button>

                    <a href="<?= site_url('penetapan-konteks') ?>"
                        class="btn btn-outline-secondary btn-icon"
                        title="Reset Filter">
                        <i class="ti ti-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('contextFilterForm');

        if (form) {
            form.addEventListener('submit', function() {
                localStorage.setItem('scrollPosition', window.scrollY);
            });
        }

        window.scrollTo({
            top: parseInt(scrollPosition),
            behavior: 'smooth'
        });
        if (scrollPosition !== null) {
            window.scrollTo(0, parseInt(scrollPosition));
            localStorage.removeItem('scrollPosition');
        }

    });
</script>