<?php

$map = [];
$selectedId = $_GET['id_konteks'] ?? null;

foreach ($konteksList as $k) {

    if (
        !isset(
            $k['nama_satuan_kerja'],
            $k['tahun'],
            $k['kegiatan'],
            $k['uraian_sasaran'],
            $k['id_konteks']
        )
    ) continue;

    $sk = $k['nama_satuan_kerja'];
    $th = $k['tahun'];
    $kg = $k['kegiatan'];
    $ss = $k['uraian_sasaran'];

    $map[$sk][$th][$kg][$ss] = $k['id_konteks'];
}

?>

<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form method="get" action="<?= site_url('analisis-risiko') ?>">
            <input type="hidden" name="id_konteks" id="id_konteks_selected" value="<?= esc($selectedId) ?>">

            <div class="row g-3 align-items-end">

                <!-- SATUAN KERJA -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Satuan Kerja</label>
                    <select class="form-select" id="skSelect">
                        <option value="">— Pilih —</option>
                        <?php foreach (array_keys($map) as $sk): ?>
                            <option value="<?= esc($sk) ?>">
                                <?= esc($sk) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="col-md-2">
                    <label class="form-label small text-muted">Tahun</label>
                    <select class="form-select" id="thSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- KEGIATAN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Kegiatan</label>
                    <select class="form-select" id="kgSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- SASARAN -->
                <div class="col-md-3">
                    <label class="form-label small text-muted">Sasaran Strategis</label>
                    <select class="form-select" id="ssSelect">
                        <option value="">— Pilih —</option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm px-3">
                        Pilih
                    </button>

                    <a href="<?= site_url('analisis-risiko') ?>"
                        class="btn btn-outline-secondary btn-sm px-3">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const contextMap = <?= json_encode($map) ?>;

    const skSelect = document.getElementById('skSelect');
    const thSelect = document.getElementById('thSelect');
    const kgSelect = document.getElementById('kgSelect');
    const ssSelect = document.getElementById('ssSelect');
    const hiddenId = document.getElementById('id_konteks_selected');

    function resetSelect(select) {
        select.innerHTML = '<option value="">— Pilih —</option>';
    }

    function autoSelectFromId(id) {

        if (!id) return;

        for (const sk in contextMap) {
            for (const th in contextMap[sk]) {
                for (const kg in contextMap[sk][th]) {
                    for (const ss in contextMap[sk][th][kg]) {

                        if (contextMap[sk][th][kg][ss] == id) {

                            skSelect.value = sk;
                            skSelect.dispatchEvent(new Event('change'));

                            setTimeout(() => {
                                thSelect.value = th;
                                thSelect.dispatchEvent(new Event('change'));
                            }, 50);

                            setTimeout(() => {
                                kgSelect.value = kg;
                                kgSelect.dispatchEvent(new Event('change'));
                            }, 100);

                            setTimeout(() => {
                                ssSelect.value = ss;
                            }, 150);

                            return;
                        }
                    }
                }
            }
        }
    }

    skSelect.addEventListener('change', function() {

        resetSelect(thSelect);
        resetSelect(kgSelect);
        resetSelect(ssSelect);
        hiddenId.value = '';

        if (!this.value || !contextMap[this.value]) return;

        Object.keys(contextMap[this.value]).forEach(th => {
            thSelect.innerHTML += `<option value="${th}">${th}</option>`;
        });
    });

    thSelect.addEventListener('change', function() {

        resetSelect(kgSelect);
        resetSelect(ssSelect);
        hiddenId.value = '';

        const sk = skSelect.value;
        if (!sk || !this.value) return;

        Object.keys(contextMap[sk][this.value]).forEach(kg => {
            kgSelect.innerHTML += `<option value="${kg}">${kg}</option>`;
        });
    });

    kgSelect.addEventListener('change', function() {

        resetSelect(ssSelect);
        hiddenId.value = '';

        const sk = skSelect.value;
        const th = thSelect.value;

        if (!sk || !th || !this.value) return;

        Object.keys(contextMap[sk][th][this.value]).forEach(ss => {
            ssSelect.innerHTML += `<option value="${ss}">${ss}</option>`;
        });
    });

    ssSelect.addEventListener('change', function() {

        const sk = skSelect.value;
        const th = thSelect.value;
        const kg = kgSelect.value;
        const ss = this.value;

        if (!sk || !th || !kg || !ss) {
            hiddenId.value = '';
            return;
        }

        hiddenId.value = contextMap[sk][th][kg][ss];
    });

    /*
    |--------------------------------------------------------------------------
    | AUTO RESTORE SELECTED VALUE
    |--------------------------------------------------------------------------
    */
    document.addEventListener('DOMContentLoaded', function() {
        autoSelectFromId(hiddenId.value);
    });
</script>