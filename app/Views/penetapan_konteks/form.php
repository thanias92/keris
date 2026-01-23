<?php
$isCreate = $mode === 'create';
$isView   = $mode === 'view';
$isEdit   = $mode === 'edit';
$disabled = $isView ? 'disabled' : '';
?>

<form method="post"
    action="<?= $isCreate
                ? base_url('penetapan-konteks/store')
                : base_url('penetapan-konteks/update/' . $konteks['id_konteks']) ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-n2">
                <div class="card-body pt-3">

                    <!-- KODE KONTEKS -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Kode Konteks</label>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control bg-light"
                                value="<?= esc($isCreate ? $kodeKonteks : $konteks['kode_konteks']) ?>"
                                readonly>
                        </div>
                    </div>

                    <!-- NAMA KEGIATAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="nama_kegiatan"
                                class="form-control"
                                placeholder="Nama Kegiatan"
                                value="<?= esc($konteks['nama_kegiatan'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- UNIT KERJA -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="unit_kerja"
                                class="form-control"
                                placeholder="Unit Kerja"
                                value="<?= esc($konteks['unit_kerja'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- TAHUN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tahun</label>
                        <div class="col-sm-9">
                            <select name="tahun"
                                class="form-select"
                                <?= $disabled ?> required>
                                <?php
                                $currentYear = date('Y');
                                for ($y = $currentYear + 1; $y >= $currentYear - 10; $y--):
                                ?>
                                    <option value="<?= $y ?>"
                                        <?= (!$isCreate && ($konteks['tahun'] ?? '') == $y) ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                <?php endfor ?>
                            </select>
                        </div>
                    </div>

                    <!-- PENANGGUNG JAWAB -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Penanggung Jawab</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="penanggung_jawab"
                                class="form-control"
                                placeholder="Penanggung Jawab"
                                value="<?= esc($konteks['penanggung_jawab'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- TUJUAN KEGIATAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tujuan Kegiatan</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="tujuan_kegiatan"
                                class="form-control"
                                placeholder="Tujuan Kegiatan"
                                value="<?= esc($konteks['tujuan_kegiatan'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- SASARAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Sasaran</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="sasaran"
                                class="form-control"
                                placeholder="Sasaran"
                                value="<?= esc($konteks['sasaran'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- INDIKATOR KEBERHASILAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Indikator Keberhasilan</label>
                        <div class="col-sm-9">
                            <input type="text"
                                name="indikator_keberhasilan"
                                class="form-control"
                                placeholder="Indikator Keberhasilan"
                                value="<?= esc($konteks['indikator_keberhasilan'] ?? '') ?>"
                                <?= $disabled ?> required>
                        </div>
                    </div>

                    <!-- SECTION: RUANG LINGKUP & ASUMSI -->
                    <div class="row mt-4 mb-2">
                        <div class="col-sm-12">
                            <h5 class="mb-2 fw-semibold text-dark">
                                Ruang Lingkup & Asumsi
                            </h5>
                            <hr class="mt-1 mb-3">
                        </div>
                    </div>

                    <!-- RUANG LINGKUP -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Ruang Lingkup</label>
                        <div class="col-sm-9">
                            <textarea name="ruang_lingkup"
                                class="form-control"
                                placeholder="Ruang Lingkup"
                                <?= $disabled ?> required><?= esc($konteks['ruang_lingkup'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- ASUMSI -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Asumsi</label>
                        <div class="col-sm-9">
                            <textarea name="asumsi"
                                class="form-control"
                                placeholder="Asumsi"
                                <?= $disabled ?> required><?= esc($konteks['asumsi'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- KETERBATASAN -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Keterbatasan</label>
                        <div class="col-sm-9">
                            <textarea name="keterbatasan"
                                class="form-control"
                                placeholder="Keterbatasan"
                                <?= $disabled ?> required><?= esc($konteks['keterbatasan'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- FAKTOR INTERNAL -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Faktor Internal</label>
                        <div class="col-sm-9">
                            <textarea name="faktor_internal"
                                class="form-control"
                                placeholder="Faktor Internal"
                                <?= $disabled ?> required><?= esc($konteks['faktor_internal'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- FAKTOR EKSTERNAL -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Faktor Eksternal</label>
                        <div class="col-sm-9">
                            <textarea name="faktor_eksternal"
                                class="form-control"
                                placeholder="Faktor Eksternal"
                                <?= $disabled ?> required><?= esc($konteks['faktor_eksternal'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="row mt-4">
                        <div class="col-sm-3">
                            <?php if (!$isCreate): ?>
                                <button type="button"
                                    class="btn btn-outline-danger"
                                    onclick="confirmDelete('<?= base_url('penetapan-konteks/delete/' . $konteks['id_konteks']) ?>')">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            <?php endif ?>
                        </div>

                        <div class="col-sm-9 text-end">
                            <?php if ($isView): ?>
                                <a href="<?= base_url('penetapan-konteks/edit/' . $konteks['id_konteks']) ?>"
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

                            <a href="<?= base_url('penetapan-konteks') ?>"
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
        action="<?= base_url('penetapan-konteks/delete/' . $konteks['id_konteks']) ?>"
        method="post">
    </form>
<?php endif ?>