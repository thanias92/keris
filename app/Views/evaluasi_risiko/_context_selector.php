<?php
$konteksMap     = [];
$satuanKerjaOpt = [];
$tahunOpt       = [];
$kegiatanOpt    = [];
$pengelolaOpt   = [];

foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];

    $konteksMap[$id] = [
        'id_satuan_kerja'     => $k['id_satuan_kerja']     ?? '',
        'pengelola_risiko_id' => $k['pengelola_risiko_id'] ?? '',
        'id_kegiatan'         => $k['id_kegiatan']         ?? '',
        'tahun'               => $k['tahun'],
    ];

    if (!empty($k['id_satuan_kerja']))
        $satuanKerjaOpt[$k['id_satuan_kerja']] = $k['nama_satuan_kerja'];
    if (!empty($k['tahun']))
        $tahunOpt[$k['tahun']] = true;
    if (!empty($k['id_kegiatan']))
        $kegiatanOpt[$k['id_kegiatan']] = $k['nama_kegiatan'];
    if (!empty($k['pengelola_risiko_id']))
        $pengelolaOpt[$k['pengelola_risiko_id']] = $k['nama_pengelola'];
}

asort($satuanKerjaOpt);
asort($kegiatanOpt);
asort($pengelolaOpt);
ksort($tahunOpt);

$sel = $activeKonteks ?? [];
?>

<div class="card shadow-sm mb-3 pk-context-filter">
    <div class="card-body">
        <form id="erContextSelectorForm" method="post"
            action="<?= site_url('evaluasi-risiko/set-active') ?>">

            <?= csrf_field() ?>
            <input type="hidden" name="id_konteks" id="erCsIdKonteks">

            <div class="row">
                <!-- LEFT SIDE -->
                <div class="col-7">
                    <div class="pk-filter-row">
                        <label>Tim Kerja</label>
                        <select class="pk-select" id="erCsSatuanKerja">
                            <option value="">– Pilih –</option>
                            <?php foreach ($satuanKerjaOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['id_satuan_kerja']) && (string)$sel['id_satuan_kerja'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Pengelola Risiko</label>
                        <select class="pk-select" id="erCsPengelola">
                            <option value="">– Pilih –</option>
                            <?php foreach ($pengelolaOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['pengelola_risiko_id']) && (string)$sel['pengelola_risiko_id'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Kegiatan</label>
                        <select class="pk-select" id="erCsKegiatan">
                            <option value="">– Pilih –</option>
                            <?php foreach ($kegiatanOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['id_kegiatan']) && (string)$sel['id_kegiatan'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="col-4 pk-right-side">
                    <div class="pk-filter-row">
                        <label>Tahun</label>
                        <select class="pk-select" id="erCsTahun" style="width:80px;">
                            <option value="">– Pilih –</option>
                            <?php foreach ($tahunOpt as $tahun => $_): ?>
                                <option value="<?= $tahun ?>"
                                    <?= isset($sel['tahun']) && (string)$sel['tahun'] === (string)$tahun ? 'selected' : '' ?>>
                                    <?= esc($tahun) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-action-wrapper">
                        <button type="submit" class="btn btn-primary btn-icon"
                            id="erCsBtnApply" title="Terapkan" disabled>
                            <i class="ti ti-search"></i>
                        </button>

                        <button type="button" class="btn btn-light btn-icon"
                            id="erCsBtnReset" title="Reset Konteks"
                            style="<?= $activeKonteks ? '' : 'display:none;' ?>">
                            <i class="ti ti-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<form id="erResetForm" method="post"
    action="<?= site_url('evaluasi-risiko/reset-active') ?>"
    style="display:none;">
    <?= csrf_field() ?>
</form>

<script>
    window.ER_CS_DATA = {
        konteksMap: <?= json_encode($konteksMap) ?>,
        hasActive: <?= $activeKonteks ? 'true' : 'false' ?>,
    };
</script>