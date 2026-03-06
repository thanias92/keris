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

<div class="card shadow-sm mb-4 pk-context-filter">
    <div class="card-body">

        <form id="contextFilterForm" method="get" action="<?= site_url('penetapan-konteks') ?>">

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-7">

                    <!-- Satuan Kerja -->
                    <div class="pk-filter-row">
                        <label>Satuan Kerja</label>
                        <select name="sk" class="pk-select">
                            <option value="">– Pilih –</option>
                            <?php foreach ($skList as $sk): ?>
                                <option value="<?= esc($sk) ?>" <?= $selectedSk == $sk ? 'selected' : '' ?>>
                                    <?= esc($sk) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Pengelola Risiko -->
                    <div class="pk-filter-row">
                        <label>Pengelola Risiko</label>
                        <select name="pr" class="pk-select">
                            <option value="">– Pilih –</option>
                            <?php foreach ($prList as $pr): ?>
                                <option value="<?= esc($pr) ?>" <?= $selectedPr == $pr ? 'selected' : '' ?>>
                                    <?= esc($pr) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kegiatan -->
                    <div class="pk-filter-row">
                        <label>Kegiatan</label>
                        <select name="kg" class="pk-select">
                            <option value="">– Pilih –</option>
                            <?php foreach ($kgList as $kg): ?>
                                <option value="<?= esc($kg) ?>" <?= $selectedKg == $kg ? 'selected' : '' ?>>
                                    <?= esc($kg) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Sasaran Strategis -->
                    <div class="pk-filter-row">
                        <label>Sasaran Strategis</label>
                        <select name="ss" class="pk-select">
                            <option value="">– Pilih –</option>
                            <?php foreach ($ssList as $ss): ?>
                                <option value="<?= esc($ss) ?>" <?= $selectedSs == $ss ? 'selected' : '' ?>>
                                    <?= esc($ss) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-4 pk-right-side">

                    <!-- Tahun -->
                    <div class="pk-filter-row">
                        <label>Tahun</label>
                        <select name="th" class="pk-select">
                            <option value="">– Pilih –</option>
                            <?php foreach ($thList as $th): ?>
                                <option value="<?= esc($th) ?>" <?= $selectedTh == $th ? 'selected' : '' ?>>
                                    <?= esc($th) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pk-action-wrapper">
                        <button type="submit" class="btn btn-primary btn-icon" title="Terapkan">
                            <i class="ti ti-search"></i>
                        </button>

                        <a href="<?= site_url('penetapan-konteks') ?>"
                            class="btn btn-light btn-icon"
                            title="Reset">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>

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