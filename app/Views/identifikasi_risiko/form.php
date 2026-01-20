<?php
$isCreate = $mode === 'create';
$isView   = $mode === 'view';
$isEdit   = $mode === 'edit';
$disabled = $isView ? 'disabled' : '';
?>

<form method="post"
    action="<?= $isCreate
                ? base_url('identifikasi-risiko/store')
                : base_url('identifikasi-risiko/update/' . $risiko['id_identifikasi']) ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-n2">
                <div class="card-body pt-3">

                    <!-- KODE RISIKO -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Risiko</label>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control bg-light"
                                value="<?= esc($isCreate ? $kodeRisiko : $risiko['kode_risiko']) ?>"
                                readonly>
                        </div>
                    </div>

                    <!-- KONTEKS -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Konteks Risiko</label>
                        <div class="col-sm-9">
                            <select name="id_konteks" class="form-select" <?= $disabled ?> required>
                                <option value="">-- Pilih Konteks Risiko --</option>
                                <?php foreach ($konteksList ?? [] as $k): ?>
                                    <option value="<?= $k['id_konteks'] ?>"
                                        <?= (!$isCreate && $k['id_konteks'] == $risiko['id_konteks']) ? 'selected' : '' ?>>
                                        <?= esc($k['nama_kegiatan']) ?> (<?= esc($k['tahun']) ?>)
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <!-- URAIAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Uraian Proses</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="uraian_kegiatan"
                                class="form-control"
                                value="<?= esc($risiko['uraian_kegiatan'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- PERNYATAAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pernyataan Risiko</label>
                        <div class="col-sm-9">
                            <textarea name="pernyataan_risiko"
                                class="form-control"
                                <?= $disabled ?> required><?= esc($risiko['pernyataan_risiko'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- PENYEBAB -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Penyebab Risiko</label>
                        <div class="col-sm-9">
                            <textarea name="penyebab_risiko"
                                class="form-control"
                                <?= $disabled ?> required><?= esc($risiko['penyebab_risiko'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- DAMPAK -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Dampak Risiko</label>
                        <div class="col-sm-9">
                            <textarea name="dampak_risiko"
                                class="form-control"
                                <?= $disabled ?> required><?= esc($risiko['dampak_risiko'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- KATEGORI -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kategori Risiko</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <?php foreach (['Operasional', 'Teknis', 'Strategis', 'Reputasi'] as $kat): ?>
                                <div class="form-check form-check-inline me-4">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="kategori_risiko"
                                        value="<?= $kat ?>"
                                        <?= (!$isCreate && $kat == ($risiko['kategori_risiko'] ?? '')) ? 'checked' : '' ?>
                                        <?= $disabled ?> required>
                                    <label class="form-check-label"><?= $kat ?></label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <!-- SUMBER -->
                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label">Sumber Risiko</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <?php foreach (['Internal', 'Eksternal'] as $s): ?>
                                <div class="form-check form-check-inline me-4">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="sumber_risiko"
                                        value="<?= $s ?>"
                                        <?= (!$isCreate && $s == ($risiko['sumber_risiko'] ?? '')) ? 'checked' : '' ?>
                                        <?= $disabled ?> required>
                                    <label class="form-check-label"><?= $s ?></label>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="row mt-4">
                        <div class="col-sm-3">
                            <?php if (!$isCreate): ?>
                                <button type="button"
                                    class="btn btn-outline-danger"
                                    onclick="confirmDelete('<?= base_url('identifikasi-risiko/delete/' . $risiko['id_identifikasi']) ?>')">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            <?php endif ?>
                        </div>

                        <div class="col-sm-9 text-end">
                            <?php if ($isView): ?>
                                <a href="<?= base_url('identifikasi-risiko/edit/' . $risiko['id_identifikasi']) ?>"
                                    class="btn btn-warning">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>
                            <?php else: ?>
                                <button type="button"
                                    class="btn btn-primary"
                                    onclick="confirmSubmit(this)">
                                    <i class="ti ti-device-floppy"></i>
                                    <?= $isCreate ? 'Simpan' : 'Ubah' ?>
                                </button>

                            <?php endif ?>

                            <a href="<?= base_url('identifikasi-risiko') ?>"
                                class="btn btn-outline-secondary ms-2">
                                <i class="ti ti-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php if (!$isCreate): ?>
    <form id="form-delete"
        action="<?= base_url('identifikasi-risiko/delete/' . $risiko['id_identifikasi']) ?>"
        method="post">
    </form>
<?php endif ?>