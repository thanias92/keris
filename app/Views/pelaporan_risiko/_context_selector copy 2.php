<?php
$konteksMap = [];
$timKerjaOpt = [];
$pengelolaOpt = [];
foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];
    $konteksMap[$id] = [
        'id_tim' => $k['id_tim'] ?? '',
        'pengelola_risiko_id' => $k['pengelola_risiko_id'] ?? '',
        'id_kegiatan' => $k['id_kegiatan'] ?? '',
        'tahun' => $k['tahun'],
    ];
    if (!empty($k['id_tim'])) $timKerjaOpt[$k['id_tim']] = $k['nama_tim'];
    if (!empty($k['pengelola_risiko_id'])) $pengelolaOpt[$k['pengelola_risiko_id']] = $k['nama_pengelola'];
}
asort($timKerjaOpt);
asort($pengelolaOpt);

$sel = $activeKonteks ?? [];
$currentMonth = $periode['bulan'] ?? date('m');
$currentYear = $periode['tahun'] ?? date('Y');
$currentPeriode = $currentYear . '-' . $currentMonth;
$type = $tipe_periode ?? 'bulanan';
?>

<div class="card pl-filter-card mb-3">
    <div class="card-body">
        <form id="plContextSelectorForm" method="get" action="<?= site_url('pelaporan-risiko') ?>">
            <input type="hidden" name="id_konteks" id="plCsIdKonteks">

            <div class="row">

                <!-- LEFT: CONTEXT -->
                <div class="col-md-8">
                    <div class="pl-context-block">
                        <div class="pl-filter-row">
                            <label>Tim Kerja</label>
                            <div class="pl-filter-field">
                                <?php if ($userRole === 'admin'): ?>
                                    <select class="pl-select" id="plCsTimKerja">
                                        <option value="">– Pilih –</option>
                                        <?php foreach ($timKerjaOpt as $id => $nama): ?>
                                            <option value="<?= $id ?>" <?= ($sel['id_tim'] ?? '') == $id ? 'selected' : '' ?>>
                                                <?= esc($nama) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <div class="pl-readonly"><?= esc($ketuaInfo['nama_tim'] ?? '-') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="pl-filter-row">
                            <label>Pengelola</label>
                            <div class="pl-filter-field">
                                <?php if ($userRole === 'admin'): ?>
                                    <select class="pl-select" id="plCsPengelola">
                                        <option value="">– Pilih –</option>
                                        <?php foreach ($pengelolaOpt as $id => $nama): ?>
                                            <option value="<?= $id ?>" <?= ($sel['pengelola_risiko_id'] ?? '') == $id ? 'selected' : '' ?>>
                                                <?= esc($nama) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <div class="pl-readonly"><?= esc($ketuaInfo['nama'] ?? '-') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="pl-filter-row">
                            <label>Kegiatan</label>
                            <div class="pl-filter-field">
                                <div class="pl-readonly">Semua Kegiatan</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT: MAIN FILTER -->
                <div class="col-md-4">
                    <div class="pl-main-filter">

                        <div class="small text-muted mb-2">FILTER PERIODE</div>

                        <select name="tipe_periode" id="plCsType" class="pl-select mb-2">
                            <option value="bulanan" <?= $type === 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                            <option value="range" <?= $type === 'range' ? 'selected' : '' ?>>Range Bulan</option>
                        </select>

                        <div id="plSingle">
                            <input type="month" name="periode" id="plCsPeriode" class="pl-periode" value="<?= $currentPeriode ?>">
                        </div>

                        <div id="plRange" style="display:none;">
                            <div class="d-flex gap-2">
                                <input type="month" name="start_periode" id="plStart" class="pl-periode">
                                <span>→</span>
                                <input type="month" name="end_periode" id="plEnd" class="pl-periode">
                            </div>
                            <div id="plPreview" class="small text-muted mt-1"></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm pl-search-btn mt-2">
                            <i class="ti ti-search"></i> Tampilkan
                        </button>

                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    window.PL_CS_DATA = {
        konteksMap: <?= json_encode($konteksMap) ?>
    };
</script>