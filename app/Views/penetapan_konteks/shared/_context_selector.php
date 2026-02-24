<?php

$map = [];

foreach ($listKonteks ?? [] as $k) {

    if (!isset(
        $k['nama_satuan_kerja'],
        $k['pengelola_risiko'],
        $k['tahun'],
        $k['kegiatan'],
        $k['uraian_sasaran'],
        $k['id_konteks']
    )) continue;

    $sk = $k['nama_satuan_kerja'];
    $pr = $k['pengelola_risiko'];
    $th = $k['tahun'];
    $kg = $k['kegiatan'];
    $ss = $k['uraian_sasaran'];

    $map[$sk][$pr][$th][$kg][$ss] = $k['id_konteks'];
}
?>

<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">

        <form method="post"
            action="<?= site_url('penetapan-konteks/konteks/set-active') ?>">

            <?= csrf_field() ?>

            <input type="hidden"
                name="id_konteks"
                id="id_konteks_selected">

            <div class="row g-4">

                <!-- SATUAN KERJA -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">
                        Satuan Kerja
                    </label>
                    <select class="form-select" id="skSelect">
                        <option value="">— Pilih —</option>
                        <?php foreach (array_keys($map) as $sk): ?>
                            <option value="<?= esc($sk) ?>"><?= esc($sk) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- PENGELOLA RISIKO -->
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted">
                        Pengelola Risiko
                    </label>
                    <select class="form-select" id="prSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted">
                        Tahun
                    </label>
                    <select class="form-select" id="thSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- KEGIATAN -->
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted">
                        Kegiatan
                    </label>
                    <select class="form-select" id="kgSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- SASARAN -->
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted">
                        Sasaran Strategis
                    </label>
                    <select class="form-select" id="ssSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit"
                        class="btn btn-primary w-100">
                        Aktifkan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    const contextMap = <?= json_encode($map) ?>;

    const skSelect = document.getElementById('skSelect');
    const prSelect = document.getElementById('prSelect');
    const thSelect = document.getElementById('thSelect');
    const kgSelect = document.getElementById('kgSelect');
    const ssSelect = document.getElementById('ssSelect');
    const hiddenId = document.getElementById('id_konteks_selected');

    function resetSelect(select) {
        select.innerHTML = '<option value="">— Pilih —</option>';
    }

    /* SK CHANGE */
    skSelect.addEventListener('change', function() {

        resetSelect(prSelect);
        resetSelect(thSelect);
        resetSelect(kgSelect);
        resetSelect(ssSelect);
        hiddenId.value = '';

        if (!this.value) return;

        Object.keys(contextMap[this.value]).forEach(pr => {
            prSelect.innerHTML += `<option value="${pr}">${pr}</option>`;
        });
    });

    /* PENGELOLA CHANGE */
    prSelect.addEventListener('change', function() {

        resetSelect(thSelect);
        resetSelect(kgSelect);
        resetSelect(ssSelect);
        hiddenId.value = '';

        const sk = skSelect.value;
        if (!sk || !this.value) return;

        Object.keys(contextMap[sk][this.value]).forEach(th => {
            thSelect.innerHTML += `<option value="${th}">${th}</option>`;
        });
    });

    /* TAHUN CHANGE */
    thSelect.addEventListener('change', function() {

        resetSelect(kgSelect);
        resetSelect(ssSelect);
        hiddenId.value = '';

        const sk = skSelect.value;
        const pr = prSelect.value;

        if (!sk || !pr || !this.value) return;

        Object.keys(contextMap[sk][pr][this.value]).forEach(kg => {
            kgSelect.innerHTML += `<option value="${kg}">${kg}</option>`;
        });
    });

    /* KEGIATAN CHANGE */
    kgSelect.addEventListener('change', function() {

        resetSelect(ssSelect);
        hiddenId.value = '';

        const sk = skSelect.value;
        const pr = prSelect.value;
        const th = thSelect.value;

        if (!sk || !pr || !th || !this.value) return;

        Object.keys(contextMap[sk][pr][th][this.value]).forEach(ss => {
            ssSelect.innerHTML += `<option value="${ss}">${ss}</option>`;
        });
    });

    /* SASARAN CHANGE */
    ssSelect.addEventListener('change', function() {

        const sk = skSelect.value;
        const pr = prSelect.value;
        const th = thSelect.value;
        const kg = kgSelect.value;
        const ss = this.value;

        if (!sk || !pr || !th || !kg || !ss) {
            hiddenId.value = '';
            return;
        }

        hiddenId.value = contextMap[sk][pr][th][kg][ss];
    });
</script>