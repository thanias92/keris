<?php

$konteksMap = [];
$satuanKerjaOpt = [];
$tahunOpt = [];
$sasaranOpt = [];

foreach ($konteksList as $k) {

    $id = $k['id_konteks'];

    $konteksMap[$id] = [
        'nama_satuan_kerja' => $k['nama_satuan_kerja'],
        'tahun'             => $k['tahun'],
        'uraian_sasaran'    => $k['uraian_sasaran'],
    ];

    $satuanKerjaOpt[$k['nama_satuan_kerja']] = true;
    $tahunOpt[$k['tahun']] = true;
    $sasaranOpt[$k['uraian_sasaran']] = true;
}

ksort($satuanKerjaOpt);
ksort($tahunOpt);
ksort($sasaranOpt);
?>

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">

        <form method="get"
            action="<?= site_url('identifikasi-risiko') ?>"
            id="formContextSelector">

            <input type="hidden" name="id_konteks" id="id_konteks_selected">

            <div class="row g-3 align-items-end">

                <!-- SATUAN KERJA -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Satuan Kerja</label>
                    <select class="form-select" id="filterSatuanKerja">
                        <option value="">— Semua —</option>
                        <?php foreach ($satuanKerjaOpt as $nama => $_): ?>
                            <option value="<?= esc($nama) ?>"
                                <?= isset($selectedContext) &&
                                    $selectedContext['nama_satuan_kerja'] === $nama
                                    ? 'selected' : '' ?>>
                                <?= esc($nama) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tahun</label>
                    <select class="form-select" id="filterTahun">
                        <option value="">— Semua —</option>
                        <?php foreach ($tahunOpt as $tahun => $_): ?>
                            <option value="<?= esc($tahun) ?>"
                                <?= isset($selectedContext) &&
                                    (string)$selectedContext['tahun'] === (string)$tahun
                                    ? 'selected' : '' ?>>
                                <?= esc($tahun) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- SASARAN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Sasaran Strategis</label>
                    <select class="form-select" id="filterSasaran">
                        <option value="">— Semua —</option>
                        <?php foreach ($sasaranOpt as $uraian => $_): ?>
                            <option value="<?= esc($uraian) ?>"
                                <?= isset($selectedContext) &&
                                    $selectedContext['uraian_sasaran'] === $uraian
                                    ? 'selected' : '' ?>>
                                <?= esc($uraian) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Pilih
                    </button>

                    <button type="button"
                        class="btn btn-outline-secondary w-100"
                        id="btnResetContext">
                        Reset
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    (function() {

        const konteksMap = <?= json_encode($konteksMap) ?>;

        const skEl = document.getElementById('filterSatuanKerja');
        const thEl = document.getElementById('filterTahun');
        const ssEl = document.getElementById('filterSasaran');
        const idEl = document.getElementById('id_konteks_selected');
        const formEl = document.getElementById('formContextSelector');
        const resetBtn = document.getElementById('btnResetContext');

        function resolveKonteksId() {

            const sk = skEl.value;
            const th = thEl.value;
            const ss = ssEl.value;

            idEl.value = '';

            if (!sk || !th || !ss) return;

            for (const [id, k] of Object.entries(konteksMap)) {
                if (
                    k.nama_satuan_kerja === sk &&
                    String(k.tahun) === String(th) &&
                    k.uraian_sasaran === ss
                ) {
                    idEl.value = id;
                    break;
                }
            }
        }

        skEl.addEventListener('change', resolveKonteksId);
        thEl.addEventListener('change', resolveKonteksId);
        ssEl.addEventListener('change', resolveKonteksId);

        resetBtn.addEventListener('click', function() {
            window.location.href = "<?= site_url('identifikasi-risiko') ?>";
        });

    })();
</script>