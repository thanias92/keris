<?php
$konteksMap = [];
$satuanKerjaOpt = [];
$tahunOpt = [];
$pengelolaOpt = [];
foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];
    $konteksMap[$id] = [
        'id_satuan_kerja' => $k['id_satuan_kerja'] ?? '',
        'pengelola_risiko_id' => $k['pengelola_risiko_id'] ?? '',
        'id_kegiatan' => $k['id_kegiatan'] ?? '',
        'tahun' => $k['tahun'],
    ];
    if (!empty($k['id_satuan_kerja'])) $satuanKerjaOpt[$k['id_satuan_kerja']] = $k['nama_satuan_kerja'];
    if (!empty($k['tahun'])) $tahunOpt[$k['tahun']] = true;
    if (!empty($k['pengelola_risiko_id'])) $pengelolaOpt[$k['pengelola_risiko_id']] = $k['nama_pengelola'];
}
asort($satuanKerjaOpt);
asort($pengelolaOpt);
ksort($tahunOpt);
$sel = $activeKonteks ?? [];
$currentMonth = $periode['bulan'] ?? date('m');
$currentYear = $periode['tahun'] ?? date('Y');
$currentPeriode = $currentYear . '-' . $currentMonth;
?>

<div class="card pl-filter-card mb-3">
    <div class="card-body">

        <form id="plContextSelectorForm" method="post" action="<?= site_url('pelaporan-risiko/set-active') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id_konteks" id="plCsIdKonteks">

            <div class="row">

                <div class="col-md-7">

                    <div class="pl-filter-row">
                        <label>Tim Kerja</label>
                        <div class="pl-filter-field">
                            <?php if ($userRole === 'admin' || $userRole === 'operator'): ?>
                                <select class="pl-select" id="plCsSatuanKerja">
                                    <option value="">– Pilih –</option>
                                    <?php foreach ($satuanKerjaOpt as $id => $nama): ?>
                                        <option value="<?= $id ?>" <?= ($sel['id_satuan_kerja'] ?? '') == $id ? 'selected' : '' ?>>
                                            <?= esc($nama) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="pl-readonly"><?= esc($ketuaInfo['nama_satuan_kerja'] ?? '-') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pl-filter-row">
                        <label>Pengelola Risiko</label>
                        <div class="pl-filter-field">
                            <?php if ($userRole === 'admin' || $userRole === 'operator'): ?>
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

                </div>

                <div class="col-md-5">

                    <div class="pl-filter-row">
                        <label>Kegiatan</label>
                        <div class="pl-filter-field">
                            <div class="pl-readonly">Semua Kegiatan</div>
                        </div>
                    </div>

                    <div class="pl-filter-row">
                        <label>Periode</label>
                        <div class="pl-filter-field d-flex align-items-center gap-2">
                            <input type="month" id="plCsPeriode" name="periode" class="pl-periode" value="<?= $currentPeriode ?>">
                            <button type="submit" class="btn btn-primary btn-sm pl-search-btn">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
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