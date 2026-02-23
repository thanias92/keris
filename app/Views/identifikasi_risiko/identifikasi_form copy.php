<?php if (!isset($listProses)) return; ?>

<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasRisiko"
    style="width:520px">

    <!-- ================= HEADER ================= -->
    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 class="mb-0 fw-semibold">
                Tambah Identifikasi Risiko
            </h5>
            <small class="text-muted">Manajemen Risiko</small>
        </div>
        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"></button>
    </div>

    <!-- ================= BODY ================= -->
    <div class="offcanvas-body">

        <!-- ===== INFO KONTEKS ===== -->
        <div class="card bg-light border-0 mb-3">
            <div class="card-body py-2">
                <div class="row small text-muted">
                    <div class="col-6">
                        <strong>Satuan Kerja</strong><br>
                        <?= esc($activeKonteks['nama_satuan_kerja'] ?? '-') ?>
                    </div>
                    <div class="col-6">
                        <strong>Tahun</strong><br>
                        <?= esc($activeKonteks['tahun'] ?? '-') ?>
                    </div>
                    <div class="col-6 mt-2">
                        <strong>Kegiatan</strong><br>
                        <?= esc($activeKonteks['kegiatan'] ?? '-') ?>
                    </div>
                    <div class="col-6 mt-2">
                        <strong>Sasaran Strategis</strong><br>
                        <?= esc($activeKonteks['uraian_sasaran'] ?? '-') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= FORM ================= -->
        <form id="formIdentifikasiRisiko"
            method="post"
            action="<?= site_url('identifikasi-risiko/store') ?>">

            <input type="hidden" name="id_identifikasi" id="id_identifikasi">

            <?= csrf_field() ?>

            <input type="hidden"
                name="id_konteks"
                value="<?= esc($activeKonteks['id_konteks'] ?? '') ?>">

            <!-- PROSES BISNIS -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Proses Bisnis</label>
                <select class="form-select"
                    name="id_proses"
                    required>
                    <option value="">-- Pilih Proses --</option>
                    <?php foreach ($listProses as $p): ?>
                        <option value="<?= $p['id_proses'] ?>">
                            <?= esc($p['kode_proses']) ?> -
                            <?= esc($p['uraian_proses']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- KODE RISIKO -->
            <div class="mb-3">
                <label class="form-label">Kode Risiko</label>
                <input type="text"
                    name="kode_risiko"
                    class="form-control bg-light"
                    readonly
                    required>

            </div>

            <!-- PERNYATAAN RISIKO -->
            <div class="mb-3">
                <label class="form-label">Pernyataan Risiko</label>
                <input type="text"
                    name="pernyataan_risiko"
                    class="form-control"
                    maxlength="100"
                    placeholder="Daftar sampel tidak representatif dengan kondisi lapangan"
                    required>
            </div>

            <!-- PENYEBAB -->
            <div class="mb-3">
                <label class="form-label">Penyebab Risiko</label>
                <textarea class="form-control"
                    name="penyebab_risiko"
                    rows="2"
                    placeholder="Informasi muatan tidak tersedia dan tidak update"
                    required></textarea>
            </div>

            <!-- DAMPAK -->
            <div class="mb-3">
                <label class="form-label">Dampak Risiko</label>
                <textarea class="form-control"
                    name="dampak_risiko"
                    rows="2"
                    placeholder="Beberapa indikator dapat  memiliki RSE tinggi"
                    required></textarea>
            </div>

            <!-- KATEGORI RISIKO -->
            <div class="row align-items-center mb-4">
                <div class="col-4">
                    <label class="form-label fw-semibold mb-0">
                        Kategori Risiko
                    </label>
                </div>

                <div class="col-8">
                    <select class="form-select shadow-sm"
                        name="id_kategori_risiko"
                        required>
                        <option value="">--Pilih Kategori--</option>

                        <?php foreach ($kategoriList as $k): ?>
                            <option value="<?= $k['id_kategori_risiko'] ?>">
                                <?= esc($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- AREA DAMPAK -->
            <div class="mb-4 mt-3">
                <label class="form-label fw-semibold">Area Dampak</label>

                <div class="border rounded p-2">
                    <?php foreach ($areaDampakList as $ad): ?>
                        <div class="form-check">
                            <input class="form-check-input"
                                type="checkbox"
                                name="area_dampak[]"
                                value="<?= $ad['id_area_dampak'] ?>"
                                id="ad<?= $ad['id_area_dampak'] ?>">
                            <label class="form-check-label"
                                for="ad<?= $ad['id_area_dampak'] ?>">
                                <?= esc($ad['nama_area_dampak']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- SUMBER RISIKO -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Sumber Risiko</label>

                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="sumber_risiko"
                            value="Internal"
                            required>
                        <label class="form-check-label">
                            Internal
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="sumber_risiko"
                            value="Eksternal">
                        <label class="form-check-label">
                            Eksternal
                        </label>
                    </div>
                </div>
            </div>

            <!-- ================= ACTION ================= -->
            <div class="d-flex align-items-center gap-2 pt-3 border-top">

                <div class="me-auto"></div>

                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">Tutup</button>
                <button type="button" id="btnSimpanRisiko" class="btn btn-primary px-4">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    let irFormMode = 'create';

    function resetIdentifikasiForm() {

        irFormMode = 'create';

        document.getElementById('formIdentifikasiRisiko').action =
            "<?= site_url('identifikasi-risiko/store') ?>";

        fetch("<?= site_url('identifikasi-risiko/generate-kode') ?>")
            .then(r => r.json())
            .then(d => {
                document.querySelector('[name="kode_risiko"]').value = d.kode;
            });
    }

    document.getElementById('offcanvasRisiko')
        .addEventListener('show.bs.offcanvas', function() {
            resetIdentifikasiForm();
        });

    document.getElementById('btnSimpanRisiko')
        .addEventListener('click', function() {

            const form = document.getElementById('formIdentifikasiRisiko');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (irFormMode === 'edit') {
                confirmUpdateIdentifikasiRisiko(form);
            } else {
                confirmIdentifikasiRisiko(form);
            }
        });
</script>