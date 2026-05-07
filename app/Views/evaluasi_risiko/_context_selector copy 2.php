<?php
$konteksMap     = [];
$timKerjaOpt = [];
$tahunOpt       = [];
$kegiatanOpt    = [];
$pengelolaOpt   = [];

foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];

    $konteksMap[$id] = [
        'id_tim'              => $k['id_tim'] ?? '',
        'pengelola_risiko_id' => $k['pengelola_risiko_id'] ?? '',
        'nama_pengelola'      => $k['nama_pengelola'] ?? '',
        'id_kegiatan'         => $k['id_kegiatan'] ?? '',
        'nama_kegiatan'       => $k['nama_kegiatan'] ?? '',
        'tahun'               => $k['tahun'],
    ];

    if (!empty($k['id_tim']))
        $timKerjaOpt[$k['id_tim']] = $k['nama_tim'];
    if (!empty($k['tahun']))
        $tahunOpt[$k['tahun']] = true;
    if (!empty($k['id_kegiatan']))
        $kegiatanOpt[$k['id_kegiatan']] = $k['nama_kegiatan'];
    if (!empty($k['pengelola_risiko_id']))
        $pengelolaOpt[$k['pengelola_risiko_id']] = $k['nama_pengelola'];
}

asort($timKerjaOpt);
asort($kegiatanOpt);
asort($pengelolaOpt);
ksort($tahunOpt);

$sel = $activeKonteks ?? [];
$get = request()->getGet();

$sk = $get['sk'] ?? '';
$pg = $get['pg'] ?? '';
$kg = $get['kg'] ?? '';
$th = $get['th'] ?? '';
?>

<div class="card shadow-sm mb-3 pk-context-filter">
    <div class="card-body">
        <form id="erContextSelectorForm" method="get"
            action="<?= site_url('evaluasi-risiko') ?>">

            <?= csrf_field() ?>
            <input type="hidden" name="id_konteks" id="erCsIdKonteks">

            <div class="row">
                <!-- LEFT SIDE -->
                <div class="col-7">
                    <div class="pk-filter-row">
                        <label>Tim Kerja</label>
                        <select name="sk" class="pk-select" id="erCsTimKerja">
                            <option value="">– Pilih –</option>
                            <?php foreach ($timKerjaOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= (string)$sk === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Pengelola Risiko</label>
                        <select name="pg" class="pk-select" id="erCsPengelola">
                            <option value="">– Pilih –</option>
                            <?php foreach ($pengelolaOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= (string)$pg === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Kegiatan</label>
                        <select name="kg" class="pk-select" id="erCsKegiatan">
                            <option value="">– Pilih –</option>
                            <?php foreach ($kegiatanOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= (string)$kg === (string)$id ? 'selected' : '' ?>>
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
                        <select name="th" class="pk-select" id="erCsTahun" style="width:80px;">
                            <option value="">– Pilih –</option>
                            <?php foreach ($tahunOpt as $tahun => $_): ?>
                                <option value="<?= $tahun ?>"
                                    <?= (string)$th === (string)$tahun ? 'selected' : '' ?>>
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
                            onclick="window.location.href='<?= site_url('evaluasi-risiko') ?>'">
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