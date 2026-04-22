<?php
$konteksMap = [];
$timKerjaOpt = [];
$tahunOpt = [];
$sasaranOpt = [];
$pengelolaOpt = [];
$kegiatanOpt = [];

foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];

    $konteksMap[$id] = [
        'id_tim'               => $k['id_tim'] ?? '',
        'pengelola_risiko_id'  => $k['pengelola_risiko_id'] ?? '',
        'id_kegiatan'          => $k['id_kegiatan'] ?? '',
        'id_sasaran_strategis' => $k['id_sasaran_strategis'] ?? '',
        'tahun'                => $k['tahun'],
    ];

    if (!empty($k['id_tim']))
        $timKerjaOpt[$k['id_tim']] = $k['nama_tim'];

    if (!empty($k['tahun']))
        $tahunOpt[$k['tahun']] = true;

    if (!empty($k['id_sasaran_strategis']))
        $sasaranOpt[$k['id_sasaran_strategis']] = $k['uraian_sasaran'];

    if (!empty($k['pengelola_risiko_id']))
        $pengelolaOpt[$k['pengelola_risiko_id']] = $k['nama_pengelola'];

    if (!empty($k['id_kegiatan']))
        $kegiatanOpt[$k['id_kegiatan']] = $k['nama_kegiatan'];
}

asort($timKerjaOpt);
asort($pengelolaOpt);
asort($kegiatanOpt);
asort($sasaranOpt);
ksort($tahunOpt);

$isFilterMode = ($activeTab ?? 'konteks') === 'konteks';

if ($isFilterMode) {
    $sel = [
        'id_tim'               => $_GET['sk'] ?? '',
        'pengelola_risiko_id'  => $_GET['pg'] ?? '',
        'id_kegiatan'          => $_GET['kg'] ?? '',
        'id_sasaran_strategis' => $_GET['ss'] ?? '',
        'tahun'                => $_GET['th'] ?? '',
    ];
} else {
    $sel = $activeKonteks ?? [];
}
?>

<div class="card shadow-sm mb-4 pk-context-filter">
    <div class="card-body">
        <form id="contextSelectorForm"
            method="<?= $isFilterMode ? 'get' : 'post' ?>"
            action="<?= $isFilterMode ? site_url('penetapan-konteks/konteks') : site_url('penetapan-konteks/konteks/set-active') ?>">

            <?php if (!$isFilterMode): ?>
                <?= csrf_field() ?>
                <input type="hidden" name="redirect" value="<?= current_url() ?>">
                <input type="hidden" name="id_konteks" id="csIdKonteks">
            <?php endif; ?>

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-7">

                    <div class="pk-filter-row">
                        <label>Tim Kerja</label>
                        <select class="pk-select" id="csTimKerja" name="sk">
                            <option value="">– Pilih –</option>
                            <?php foreach ($timKerjaOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['id_tim']) && (string)$sel['id_tim'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Pengelola Risiko</label>
                        <select class="pk-select" id="csPengelola" name="pg">
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
                        <select class="pk-select" id="csKegiatan" name="kg">
                            <option value="">– Pilih –</option>
                            <?php foreach ($kegiatanOpt as $id => $nama): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['id_kegiatan']) && (string)$sel['id_kegiatan'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($nama) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="pk-filter-row">
                        <label>Sasaran Strategis</label>
                        <select class="pk-select" id="csSasaran" name="ss">
                            <option value="">– Pilih –</option>
                            <?php foreach ($sasaranOpt as $id => $uraian): ?>
                                <option value="<?= $id ?>"
                                    <?= isset($sel['id_sasaran_strategis']) && (string)$sel['id_sasaran_strategis'] === (string)$id ? 'selected' : '' ?>>
                                    <?= esc($uraian) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-4 pk-right-side">

                    <div class="pk-filter-row">
                        <label>Tahun</label>
                        <select class="pk-select" id="csTahun" name="th" style="width: 80px;">
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
                        <button type="submit" class="btn btn-primary btn-icon" title="Terapkan">
                            <i class="ti ti-search"></i>
                        </button>
                        <button type="button" id="csBtnReset"
                            class="btn btn-light btn-icon" title="Reset">
                            <i class="ti ti-refresh"></i>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<?php if (!$isFilterMode): ?>
    <script>
        window.CS_DATA = {
            konteksMap: <?= json_encode($konteksMap) ?>,
            resetUrl: "<?= site_url('penetapan-konteks/konteks/reset-active') ?>",
            csrfToken: "<?= csrf_hash() ?>",
            currentUrl: "<?= current_url() ?>",
        };
    </script>
<?php endif; ?>