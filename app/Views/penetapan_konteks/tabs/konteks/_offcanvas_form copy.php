<div class="offcanvas offcanvas-end pk-offcanvas" tabindex="-1" id="offcanvasKonteks">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title mb-0" id="pkOffcanvasTitle">Tambah Konteks</h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
    </div>

    <div class="offcanvas-body">
        <form id="pkFormKonteks">
            <input type="hidden" name="mode" id="pkMode" value="create">
            <input type="hidden" name="id_konteks" id="pkId">

            <!-- STRUKTUR ORGANISASI -->
            <div class="pk-section">
                <div class="pk-section-title">Struktur Organisasi</div>

                <div class="d-flex gap-3 mt-2">

                    <label class="form-check border rounded px-3 py-3 flex-fill struktur-card">
                        <input class="form-check-input me-2" type="radio" name="level_struktur" value="provinsi" checked>
                        <div>
                            <strong>BPS Provinsi Riau</strong>
                            <div class="text-muted small">Tingkat provinsi</div>
                        </div>
                    </label>

                    <label class="form-check border rounded px-3 py-3 flex-fill struktur-card">
                        <input class="form-check-input me-2" type="radio" name="level_struktur" value="kabkota">
                        <div class="w-100">
                            <strong>BPS Kab/Kota</strong>
                            <div class="text-muted small">Tingkat kabupaten/kota</div>
                            <div id="pkKabKotaWrapper" class="mt-3" style="display:none;">
                                <div class="pk-combobox" id="pkKabKotaBox">
                                    <input type="hidden" id="pkKabKotaValue" name="id_wilayah">
                                    <input type="text" class="pk-combobox-input" id="pkKabKotaInput" placeholder="Pilih Kab/Kota" autocomplete="off">
                                    <div class="pk-combobox-dropdown">
                                        <div class="pk-combobox-options">
                                            <?php foreach ($listWilayah as $w): ?>
                                                <div class="pk-option" data-value="<?= $w['id'] ?>">
                                                    <?= esc($w['nama_wilayah']) ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>

                </div>
            </div>


            <!-- STRUKTUR RISIKO -->
            <div class="pk-section">
                <div class="pk-section-title">Struktur Risiko</div>

                <div class="pk-grid-2 mt-2">

                    <div class="pk-structure-panel">
                        <div class="pk-structure-title">Pemilik Risiko</div>
                        <input type="hidden" name="pemilik_risiko_id" id="pkPemilikId">
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

                    <div class="pk-structure-panel">
                        <div class="pk-structure-title">Pengelola Risiko</div>
                        <input type="hidden" name="pengelola_risiko_id" id="pkPengelolaValue">
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
                        <!-- warning fallback tahun -->
                        <small id="pkPengelolaWarning" class="text-warning mt-1" style="display:none;"></small>
                    </div>

                </div>
            </div>

            <!-- INFORMASI KONTEKS -->
            <div class="pk-section">
                <div class="pk-section-title">Informasi Konteks</div>

                <div class="pk-context-panel">

                    <!-- TAHUN DULU ↑ -->
                    <div class="pk-field-row">
                        <div class="pk-field-label">Tahun</div>
                        <div class="pk-field-input">
                            <div class="pk-combobox" id="pkTahunBox">
                                <input type="hidden" name="tahun" id="pkTahun">
                                <input type="text" class="pk-combobox-input" id="pkTahunInput" placeholder="2026" autocomplete="off">
                                <div class="pk-combobox-dropdown">
                                    <div class="pk-combobox-options">
                                        <?php for ($i = 2020; $i <= 2035; $i++): ?>
                                            <div class="pk-option" data-value="<?= $i ?>"><?= $i ?></div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SATUAN KERJA -->
                    <div class="pk-field-row">
                        <div class="pk-field-label">Tim Kerja</div>
                        <div class="pk-field-input">
                            <div class="pk-combobox" id="pkTimBox">
                                <input type="hidden" name="id_tim" id="pkTimValue">
                                <input type="text" class="pk-combobox-input" id="pkTimInput" placeholder="Pilih Tim Kerja" autocomplete="off">
                                <div class="pk-combobox-dropdown">
                                    <div class="pk-combobox-options">
                                        <?php foreach ($listTimKerja as $sk): ?>
                                            <div class="pk-option" data-value="<?= $sk['id_tim'] ?>">
                                                <?= esc($sk['nama_tim']) ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KEGIATAN -->
                    <div class="pk-field-row">
                        <div class="pk-field-label">Kegiatan</div>
                        <div class="pk-field-input">
                            <div class="pk-combobox" id="pkKegiatanBox">
                                <input type="hidden" name="id_kegiatan" id="pkKegiatanValue">
                                <input type="text" class="pk-combobox-input" id="pkKegiatanInput" placeholder="Pilih Kegiatan" autocomplete="off">
                                <div class="pk-combobox-dropdown">
                                    <div class="pk-combobox-options" id="pkKegiatanOptions">
                                        <div class="pk-option text-muted">Pilih tim kerja terlebih dahulu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- KONTEKS STRATEGIS -->
            <div class="pk-section">
                <div class="pk-section-title">Konteks Strategis</div>
                <div class="pk-context-panel">
                    <div class="pk-field-vertical">
                        <div class="pk-field-label">Sasaran Strategis</div>
                        <div class="pk-combobox" id="pkSasaranBox">
                            <input type="hidden" name="id_sasaran_strategis" id="pkSasaranValue">
                            <input type="text" class="pk-combobox-input" id="pkSasaranInput" placeholder="Pilih Sasaran Strategis" autocomplete="off">
                            <div class="pk-combobox-dropdown">
                                <div class="pk-combobox-options">
                                    <?php foreach ($listSasaran as $ss): ?>
                                        <div class="pk-option" data-value="<?= $ss['id_sasaran_strategis'] ?>">
                                            <?= esc($ss['uraian_sasaran']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pk-field-vertical mt-3">
                        <div class="pk-field-label">Pemangku Kepentingan</div>
                        <div class="pk-combobox" id="pkPemangkuBox">
                            <input type="text" class="pk-combobox-input" id="pkPemangkuInput" placeholder="Pilih Pemangku Kepentingan" autocomplete="off">
                            <div class="pk-combobox-dropdown">
                                <div class="pk-combobox-options">
                                    <?php
                                    $groupPemangku = [];
                                    foreach ($listPemangku as $p) {
                                        $groupPemangku[$p['hubungan']][] = $p;
                                    }
                                    ?>
                                    <?php foreach ($groupPemangku as $hubungan => $items): ?>
                                        <div class="pk-option-group"><?= esc($hubungan) ?></div>
                                        <?php foreach ($items as $p): ?>
                                            <div class="pk-option pk-option-entity"
                                                data-value="<?= $p['id_pemangku'] ?>"
                                                data-role="<?= esc($p['hubungan'] ?? '') ?>">
                                                <div class="pk-option-title"><?= esc($p['nama_instansi']) ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div id="pkPemangkuTags" class="pk-pemangku-list mt-2"></div>
                    </div>

                    <div class="pk-field-vertical mt-3">
                        <div class="pk-field-label">Peraturan Terkait</div>
                        <div class="pk-combobox" id="pkPeraturanBox">
                            <input type="text" class="pk-combobox-input" id="pkPeraturanInput" placeholder="Tambahkan Peraturan" autocomplete="off">
                            <div class="pk-combobox-dropdown">
                                <div class="pk-combobox-options">
                                    <?php foreach ($listPeraturan as $p): ?>
                                        <?php if ($p['is_default'] !== 't'): ?>
                                            <div class="pk-option" data-value="<?= $p['id_peraturan'] ?>" data-default="<?= $p['is_default'] ?>">
                                                <?= esc($p['nama_peraturan']) ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div id="pkPeraturanTags" class="pk-law-list mt-2">
                            <?php $loopIndex = 0; ?>
                            <?php foreach ($listPeraturan as $p): ?>
                                <?php if ($p['is_default'] === 't'): ?>
                                    <?php $loopIndex++ ?>
                                    <div class="pk-law-item pk-law-default" data-id="<?= $p['id_peraturan'] ?>">
                                        <div class="pk-law-number"><?= $loopIndex ?>.</div>
                                        <div class="pk-law-title"><?= esc($p['nama_peraturan']) ?></div>
                                        <input type="hidden" name="peraturan[]" value="<?= $p['id_peraturan'] ?>">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- SASARAN ORGANISASI -->
                <div class="pk-section">
                    <div class="pk-section-title">Sasaran Organisasi</div>
                    <div class="pk-context-panel">
                        <div class="table-responsive">
                            <table class="table table-sm pk-table-sasaran">
                                <thead>
                                    <tr>
                                        <th width="40">#</th>
                                        <th width="120">Kode Proses</th>
                                        <th width="180">Proses Bisnis</th>
                                        <th>Sasaran Kinerja</th>
                                    </tr>
                                </thead>
                                <tbody id="pkSasaranOrganisasiBody">
                                    <tr class="pk-empty-row">
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada sasaran organisasi</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="pk-action-wrapper">
                    <div class="pk-mode" id="pkBtnCreate">
                        <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    <div class="pk-mode" id="pkBtnView" style="display:none; justify-content:space-between;">
                        <button type="button" class="btn btn-danger" id="pkBtnDelete">
                            <i class="ti ti-trash"></i>
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Batal</button>
                            <button type="button" class="btn btn-warning text-white" id="pkBtnSwitchEdit">Edit</button>
                        </div>
                    </div>
                    <div class="pk-mode" id="pkBtnEdit" style="display:none;">
                        <button type="button" class="btn btn-light" id="pkBtnCancelEdit">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
        </form>
    </div>
</div>