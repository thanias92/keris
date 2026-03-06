<div class="offcanvas offcanvas-end pk-offcanvas"
    tabindex="-1"
    id="offcanvasKonteks">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0" id="pkOffcanvasTitle">
                Tambah Konteks
            </h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
    </div>

    <div class="offcanvas-body">

        <form id="pkFormKonteks">

            <input type="hidden" name="mode" id="pkMode" value="create">
            <input type="hidden" name="id_konteks" id="pkId">

            <!-- ===================================== -->
            <!-- STRUKTUR ORGANISASI -->
            <!-- ===================================== -->
            <div class="pk-section">
                <div class="pk-section-title">
                    Struktur Organisasi
                </div>

                <div class="d-flex gap-3">
                    <label class="form-check border rounded px-3 py-3 flex-fill struktur-card">
                        <input class="form-check-input me-2"
                            type="radio"
                            name="level_struktur"
                            value="provinsi"
                            checked>
                        <div>
                            <strong>BPS Provinsi Riau</strong>
                            <div class="text-muted small">
                                Tingkat provinsi
                            </div>
                        </div>
                    </label>

                    <label class="form-check border rounded px-3 py-3 flex-fill struktur-card">
                        <input class="form-check-input me-2"
                            type="radio"
                            name="level_struktur"
                            value="kabkota">
                        <div>
                            <strong>BPS Kab/Kota</strong>
                            <div class="text-muted small">
                                Tingkat kabupaten/kota
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div id="pkKabKotaWrapper" style="display:none;margin-top:10px">
                <div class="pk-field-row">
                    <div class="pk-field-label">
                        Kab/Kota
                    </div>

                    <div class="pk-combobox" id="pkKabKotaBox">

                        <input type="hidden"
                            name="id_wilayah"
                            id="pkKabKotaValue">

                        <input
                            type="text"
                            class="pk-combobox-input"
                            id="pkKabKotaInput"
                            placeholder="Pilih Kab/Kota"
                            autocomplete="off">

                        <div class="pk-combobox-dropdown">

                            <div class="pk-combobox-options">

                                <?php foreach ($listWilayah as $w): ?>

                                    <div class="pk-option"
                                        data-value="<?= $w['id'] ?>">

                                        <?= esc($w['nama_wilayah']) ?>

                                    </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- ===================================== -->
            <!-- STRUKTUR RISIKO -->
            <!-- ===================================== -->

            <div class="pk-grid-2 pk-section">

                <!-- PEMILIK RISIKO -->

                <div class="pk-structure-panel">

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

                <!-- PENGELOLA RISIKO -->

                <div class="pk-structure-panel">

                    <div class="pk-structure-title">
                        Pengelola Risiko
                    </div>

                    <div class="pk-combobox" id="pkPengelolaBox">

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
                    </div>
                </div>
            </div>

            <!-- ===================================== -->
            <!-- KONTEKS -->
            <!-- ===================================== -->

            <div class="pk-grid-2 pk-section">

                <!-- SATUAN KERJA -->

                <div class="pk-field-row">

                    <div class="pk-field-label">
                        Satuan Kerja
                    </div>

                    <div class="pk-field-input">

                        <div class="pk-combobox"
                            id="pkSatuanKerjaBox">

                            <input type="hidden"
                                name="id_satuan_kerja"
                                id="pkSatuanKerjaValue">

                            <input
                                type="text"
                                class="pk-combobox-input"
                                id="pkSatuanKerjaInput"
                                placeholder="Pilih Satuan Kerja"
                                autocomplete="off">

                            <div class="pk-combobox-dropdown">

                                <div class="pk-combobox-options">

                                    <?php foreach ($listSatuanKerja as $sk): ?>

                                        <div class="pk-option"
                                            data-value="<?= $sk['id_satuan_kerja'] ?>">

                                            <?= esc($sk['nama_satuan_kerja']) ?>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- KEGIATAN -->

                <div class="pk-field-row">

                    <div class="pk-field-label">
                        Kegiatan
                    </div>

                    <div class="pk-field-input">

                        <div class="pk-combobox"
                            id="pkKegiatanBox">

                            <input type="hidden"
                                name="id_kegiatan"
                                id="pkKegiatanValue">

                            <input
                                type="text"
                                class="pk-combobox-input"
                                id="pkKegiatanInput"
                                placeholder="Pilih Kegiatan"
                                autocomplete="off">

                            <div class="pk-combobox-dropdown">

                                <div class="pk-combobox-options"
                                    id="pkKegiatanOptions">

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <!-- ===================================== -->
            <!-- SASARAN + TAHUN -->
            <!-- ===================================== -->

            <div class="pk-grid-2 pk-section">

                <div class="pk-field-row">

                    <div class="pk-field-label">
                        Sasaran Strategis
                    </div>

                    <div class="pk-field-input">

                        <select
                            name="id_sasaran_strategis"
                            id="pkSasaran"
                            class="form-select pk-select-search">

                            <option value="">
                                -- Pilih Sasaran Strategis --
                            </option>

                            <?php foreach ($listSasaran as $ss): ?>

                                <option value="<?= $ss['id_sasaran_strategis'] ?>">
                                    <?= esc($ss['uraian_sasaran']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>
                </div>

                <div class="pk-field-row">

                    <div class="pk-field-label">
                        Tahun
                    </div>

                    <div class="pk-field-input">

                        <input type="hidden"
                            name="tahun"
                            id="pkTahun">

                        <div class="pk-year-picker">

                            <?php for ($i = 2000; $i <= 2030; $i++): ?>

                                <div class="pk-year-item"
                                    data-year="<?= $i ?>">

                                    <?= $i ?>

                                </div>

                            <?php endfor; ?>

                        </div>

                    </div>
                </div>

            </div>

        </form>

    </div>

</div>