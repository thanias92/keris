<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasKonteks"
    style="width: 460px">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 class="mb-0 fw-semibold">Tambah Konteks</h5>
            <small class="text-muted">Penetapan Konteks</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form method="post" action="<?= site_url('penetapan-konteks/konteks/store') ?>">

            <!-- SATUAN KERJA -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Satuan Kerja</label>
                <select name="id_satuan_kerja" class="form-select" required>
                    <option value="">-- Pilih Satuan Kerja --</option>
                    <?php foreach ($filterOptions['satuan_kerja'] as $sk): ?>
                        <option value="<?= $sk['id_satuan_kerja'] ?>">
                            <?= esc($sk['nama_satuan_kerja']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- PENGELOLA RISIKO -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pengelola Risiko</label>
                <input type="text"
                    name="pengelola_risiko"
                    class="form-control"
                    placeholder="Nama pengelola risiko"
                    required>
                <small class="text-muted">
                    *sementara diisi manual, akan terhubung user login nanti
                </small>
            </div>

            <!-- KEGIATAN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Kegiatan</label>
                <input type="text"
                    name="kegiatan"
                    class="form-control"
                    placeholder="Contoh: Penyusunan Statistik Tahunan">
            </div>

            <!-- TAHUN -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select" required>
                    <option value="">— Pilih Tahun —</option>
                    <?php
                    $yearNow = date('Y');
                    for ($y = $yearNow - 1; $y <= $yearNow + 3; $y++):
                    ?>
                        <option value="<?= $y ?>"><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- SASARAN STRATEGIS -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Sasaran Strategis</label>
                <select name="id_sasaran_strategis" class="form-select" required>
                    <option value="">— Pilih Sasaran Strategis —</option>
                    <?php foreach ($filterOptions['sasaran_strategis'] as $ss): ?>
                        <option value="<?= $ss['id_sasaran_strategis'] ?>">
                            <?= esc($ss['kode_sasaran']) ?> — <?= esc($ss['uraian_sasaran']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    Simpan Konteks
                </button>
            </div>

        </form>
    </div>
</div>