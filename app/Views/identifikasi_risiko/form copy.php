<?php
$isCreate = $mode === 'create';
$isView   = $mode === 'view';
$isEdit   = $mode === 'edit';
$disabled = $isView ? 'disabled' : '';
?>

<div class="card">
    <div class="card-body">
        <form method="post"
            action="<?= $isCreate
                        ? base_url('identifikasi-risiko/store')
                        : base_url('identifikasi-risiko/update/' . $risiko['id_identifikasi']) ?>">

            <!-- KODE RISIKO -->
            <div class="mb-3">
                <label>Kode Risiko</label>
                <input type="text"
                    class="form-control"
                    value="<?= esc($isCreate ? $kodeRisiko : $risiko['kode_risiko']) ?>"
                    readonly>
            </div>

            <!-- KONTEKS -->
            <div class="mb-3">
                <label>Konteks Risiko</label>
                <select name="id_konteks" class="form-select" <?= $disabled ?>>
                    <?php foreach ($konteksList ?? [] as $k): ?>
                        <option value="<?= $k['id_konteks'] ?>"
                            <?= (!$isCreate && $k['id_konteks'] == $risiko['id_konteks']) ? 'selected' : '' ?>>
                            <?= esc($k['nama_kegiatan']) ?> (<?= esc($k['tahun']) ?>)
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- URAIAN -->
            <div class="mb-3">
                <label>Uraian Proses</label>
                <input type="text"
                    name="uraian_kegiatan"
                    class="form-control"
                    value="<?= esc($risiko['uraian_kegiatan'] ?? '') ?>"
                    <?= $disabled ?>>
            </div>

            <!-- PERNYATAAN -->
            <div class="mb-3">
                <label>Pernyataan Risiko</label>
                <textarea name="pernyataan_risiko"
                    class="form-control"
                    <?= $disabled ?>><?= esc($risiko['pernyataan_risiko'] ?? '') ?></textarea>
            </div>

            <!-- PENYEBAB -->
            <div class="mb-3">
                <label>Penyebab Risiko</label>
                <textarea name="penyebab_risiko"
                    class="form-control"
                    <?= $disabled ?>><?= esc($risiko['penyebab_risiko'] ?? '') ?></textarea>
            </div>

            <!-- KATEGORI -->
            <div class="mb-3">
                <label>Kategori Risiko</label>
                <select name="kategori_risiko" class="form-select" <?= $disabled ?>>
                    <?php foreach (['Operasional', 'Teknis', 'Strategis'] as $kat): ?>
                        <option value="<?= $kat ?>"
                            <?= (!$isCreate && $kat == $risiko['kategori_risiko']) ? 'selected' : '' ?>>
                            <?= $kat ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SUMBER -->
            <div class="mb-3">
                <label>Sumber Risiko</label>
                <select name="sumber_risiko" class="form-select" <?= $disabled ?>>
                    <?php foreach (['Internal', 'Eksternal'] as $s): ?>
                        <option value="<?= $s ?>"
                            <?= (!$isCreate && $s == $risiko['sumber_risiko']) ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- FOOTER BUTTON -->
            <div class="d-flex justify-content-between mt-4">
                <div class="d-flex justify-content-end mt-4">
                    <?php if ($isView): ?>
                        <a href="<?= base_url('identifikasi-risiko/edit/' . $risiko['id_identifikasi']) ?>"
                            class="btn btn-warning">Edit</a>
                    <?php else: ?>
                        <button class="btn btn-primary">
                            <?= $isCreate ? 'Simpan' : 'Update' ?>
                        </button>
                    <?php endif ?>

                    <a href="<?= base_url('identifikasi-risiko') ?>"
                        class="btn btn-secondary ms-2">Kembali</a>
                </div>
            </div>
        </form>
        <?php if (!$isCreate): ?>
            <form action="<?= base_url('identifikasi-risiko/delete/' . $risiko['id_identifikasi']) ?>"
                method="post"
                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                class="mt-3">
                <button class="btn btn-outline-danger">
                    Hapus
                </button>
            </form>
        <?php endif ?>

    </div>
</div>