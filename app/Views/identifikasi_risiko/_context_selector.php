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
        <form id="irContextSelectorForm" method="post"
            action="<?= site_url('identifikasi-risiko/set-active') ?>">

            <?= csrf_field() ?>
            <input type="hidden" name="id_konteks" id="irCsIdKonteks">

            <div class="row">
                <!-- LEFT SIDE -->
                <div class="col-7">
                    <div class="pk-filter-row">
                        <label>Tim Kerja</label>
                        <select class="pk-select" id="irCsTimKerja">
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
                        <select class="pk-select" id="irCsPengelola">
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
                        <select class="pk-select" id="irCsKegiatan">
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
                        <select class="pk-select" id="irCsTahun" style="width:80px;">
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
                        <!-- Tombol Apply -->
                        <button type="submit" class="btn btn-primary btn-icon"
                            id="irCsBtnApply" title="Terapkan" disabled>
                            <i class="ti ti-search"></i>
                        </button>
                        <!-- Tombol Reset — selalu ada, JS yang hide/show -->
                        <button type="button" class="btn btn-light btn-icon"
                            id="irCsBtnReset" title="Reset Konteks">
                            <i class="ti ti-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Form reset di luar form selector -->
<form id="irResetForm" method="post"
    action="<?= site_url('identifikasi-risiko/reset-active') ?>"
    style="display:none;">
    <?= csrf_field() ?>
</form>

<script>
    window.IR_CS_DATA = {
        konteksMap: <?= json_encode($konteksMap) ?>,
        hasActive: <?= $activeKonteks ? 'true' : 'false' ?>,
    };
</script>