<div class="pk-section">

    <div class="pk-section-title">
        Sasaran Strategis
    </div>

    <div class="pk-context-panel">

        <div class="pk-field-vertical">

            <div class="pk-field-label">
                Sasaran Strategis
            </div>

            <div class="pk-combobox" id="pkSasaranBox">

                <input type="hidden"
                    name="id_sasaran_strategis"
                    id="pkSasaranValue">

                <input type="text"
                    class="pk-combobox-input"
                    id="pkSasaranInput"
                    placeholder="Pilih Sasaran Strategis"
                    autocomplete="off">

                <div class="pk-combobox-dropdown">
                    <div class="pk-combobox-options">

                        <?php foreach ($listSasaran as $ss): ?>

                            <div class="pk-option"
                                data-value="<?= $ss['id_sasaran_strategis'] ?>">

                                <?= esc($ss['uraian_sasaran']) ?>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="pk-section">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div class="pk-section-title mb-0">
            Proses Bisnis & Sasaran Kinerja
        </div>

        <button type="button"
            class="btn btn-primary btn-sm"
            id="pbBtnCreate">
            <i class="ti ti-plus"></i>Proses
        </button>

    </div>

    <div class="pk-context-panel" id="pkProsesBisnisTableWrapper">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Kode</th>
                        <th width="12%">Jenis</th>
                        <th width="22%">Proses Bisnis</th>
                        <th width="20%">Deskripsi Proses</th>
                        <th>Sasaran Kinerja</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($sasaranOrganisasi)): ?>

                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-5">

                                Belum ada proses bisnis dipilih.

                            </td>
                        </tr>

                    <?php else: ?>

                        <?php $no = 1; ?>

                        <?php foreach ($sasaranOrganisasi as $row): ?>

                            <tr class="pk-table-row"
                                data-pb-edit="<?= $row['id_konteks_proses'] ?>"
                                style="cursor:pointer;">

                                <td><?= $no++ ?></td>

                                <td>
                                    <span class="badge bg-primary">
                                        <?= esc($row['kode_proses']) ?>
                                    </span>
                                </td>

                                <td>
                                    <?= esc($row['jenis_proses']) ?>
                                </td>

                                <td>
                                    <?= esc($row['uraian_proses']) ?>
                                </td>

                                <td>
                                    <?= esc($row['deskripsi_proses'] ?? '-') ?>
                                </td>

                                <td>
                                    <?= esc($row['uraian_sasaran'] ?? '-') ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= view('penetapan_konteks/tabs/proses_bisnis/_offcanvas_form') ?>

<div class="pk-section">

    <div class="pk-section-title">
        Pemangku Kepentingan
    </div>

    <div class="pk-context-panel">

        <div class="pk-field-vertical">

            <div class="pk-combobox" id="pkPemangkuBox">

                <input type="text"
                    class="pk-combobox-input"
                    id="pkPemangkuInput"
                    placeholder="Pilih Pemangku Kepentingan"
                    autocomplete="off">

                <div class="pk-combobox-dropdown">

                    <div class="pk-combobox-options">

                        <?php
                        $groupPemangku = [];
                        foreach ($listPemangku as $p) {
                            $groupPemangku[$p['hubungan']][] = $p;
                        }
                        ?>

                        <?php foreach ($groupPemangku as $hubungan => $items): ?>

                            <div class="pk-option-group">
                                <?= esc($hubungan) ?>
                            </div>

                            <?php foreach ($items as $p): ?>

                                <div class="pk-option pk-option-entity"
                                    data-value="<?= $p['id_pemangku'] ?>">

                                    <div class="pk-option-title">
                                        <?= esc($p['nama_instansi']) ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

            <div id="pkPemangkuTags"
                class="pk-pemangku-list mt-3">
            </div>

        </div>

    </div>

</div>

<div class="pk-section">

    <div class="pk-section-title">
        Peraturan Terkait
    </div>

    <div class="pk-context-panel">

        <div class="pk-field-vertical">

            <div class="pk-combobox" id="pkPeraturanBox">

                <input type="text"
                    class="pk-combobox-input"
                    id="pkPeraturanInput"
                    placeholder="Tambahkan Peraturan"
                    autocomplete="off">

                <div class="pk-combobox-dropdown">

                    <div class="pk-combobox-options">

                        <?php foreach ($listPeraturan as $p): ?>

                            <?php if ($p['is_default'] !== 't'): ?>

                                <div class="pk-option"
                                    data-value="<?= $p['id_peraturan'] ?>">

                                    <?= esc($p['nama_peraturan']) ?>

                                </div>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

            <div id="pkPeraturanTags"
                class="pk-law-list mt-3">

                <?php $loopIndex = 0; ?>

                <?php foreach ($listPeraturan as $p): ?>

                    <?php if ($p['is_default'] === 't'): ?>

                        <?php $loopIndex++ ?>

                        <div class="pk-law-item pk-law-default"
                            data-id="<?= $p['id_peraturan'] ?>">

                            <div class="pk-law-number">
                                <?= $loopIndex ?>.
                            </div>

                            <div class="pk-law-title">
                                <?= esc($p['nama_peraturan']) ?>
                            </div>

                            <input type="hidden"
                                name="peraturan[]"
                                value="<?= $p['id_peraturan'] ?>">

                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

</div>

<div class="pk-section">

    <div class="pk-section-title">
        Pengelola Risiko
    </div>

    <div class="row g-3 mt-1">

        <div class="col-lg-6">

            <div class="pk-structure-panel h-100">

                <div class="pk-structure-title">
                    Pemilik Risiko
                </div>

                <input type="hidden"
                    name="pemilik_risiko_id"
                    id="pkPemilikId">

                <div class="pk-info-row">
                    <span class="pk-info-label">Nama</span>
                    <span id="pkPemilikNama" class="pk-info-value">-</span>
                </div>

                <div class="pk-info-row">
                    <span class="pk-info-label">NIP</span>
                    <span id="pkPemilikNip" class="pk-info-value">-</span>
                </div>

                <div class="pk-info-row">
                    <span class="pk-info-label">Jabatan</span>
                    <span id="pkPemilikJabatan" class="pk-info-value">-</span>
                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="pk-structure-panel h-100">

                <div class="pk-structure-title">
                    Pengelola Risiko
                </div>

                <input type="hidden"
                    name="pengelola_risiko_id"
                    id="pkPengelolaValue">

                <div class="pk-info-row">
                    <span class="pk-info-label">Nama</span>
                    <span id="pkPengelolaNama" class="pk-info-value">-</span>
                </div>

                <div class="pk-info-row">
                    <span class="pk-info-label">NIP</span>
                    <span id="pkPengelolaNip" class="pk-info-value">-</span>
                </div>

                <div class="pk-info-row">
                    <span class="pk-info-label">Jabatan</span>
                    <span id="pkPengelolaJabatan" class="pk-info-value">-</span>
                </div>

                <small id="pkPengelolaWarning"
                    class="text-warning mt-1"
                    style="display:none;">
                </small>

            </div>

        </div>

    </div>

</div>

<div class="d-flex justify-content-end gap-2 py-4">

    <button type="button" class="btn btn-light">
        Reset
    </button>

    <button type="submit" class="btn btn-primary">
        Simpan
    </button>

</div>