<?php

/**
 * BAGIAN A — CONTEXT SELECTOR
 * - Satuan Kerja
 * - Tahun
 * - Sasaran Strategis
 * - Terapkan → set session id_konteks_aktif
 */

// siapkan mapping konteks untuk JS
$konteksMap = [];
$satuanKerjaOpt = [];
$tahunOpt = [];
$sasaranOpt = [];

foreach ($listKonteks as $k) {
    $id = $k['id_konteks'];

    $konteksMap[$id] = [
        'id_satuan_kerja' => $k['id_satuan_kerja'] ?? null,
        'nama_satuan_kerja' => $k['nama_satuan_kerja'],
        'tahun' => $k['tahun'],
        'uraian_sasaran' => $k['uraian_sasaran'],
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
        <form method="post"
            action="<?= site_url('penetapan-konteks/set-active-konteks') ?>"
            id="formContextSelector">

            <?= csrf_field() ?>
            <input type="hidden" name="redirect" value="<?= current_url() ?>">
            <input type="hidden" name="id_konteks" id="id_konteks_selected">

            <div class="row g-3 align-items-end">

                <!-- SATUAN KERJA -->
                <div class="col-md-4">
                    <label class="form-label small text-muted">Satuan Kerja</label>
                    <select class="form-select" id="filterSatuanKerja" required>
                        <option value="">— Pilih —</option>
                        <?php foreach ($satuanKerjaOpt as $nama => $_): ?>
                            <option value="<?= esc($nama) ?>">
                                <?= esc($nama) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Tahun</label>
                    <select class="form-select" id="filterTahun" required>
                        <option value="">— Pilih —</option>
                        <?php foreach ($tahunOpt as $tahun => $_): ?>
                            <option value="<?= esc($tahun) ?>">
                                <?= esc($tahun) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- SASARAN STRATEGIS -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Sasaran Strategis</label>
                    <select class="form-select" id="filterSasaran" required>
                        <option value="">— Pilih —</option>
                        <?php foreach ($sasaranOpt as $uraian => $_): ?>
                            <option value="<?= esc($uraian) ?>">
                                <?= esc($uraian) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TERAPKAN -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        Pilih
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

        document.getElementById('formContextSelector')
            .addEventListener('submit', function(e) {
                if (!idEl.value) {
                    e.preventDefault();
                    alert('Konteks tidak ditemukan. Periksa pilihan Anda.');
                }
            });
    })();
</script>