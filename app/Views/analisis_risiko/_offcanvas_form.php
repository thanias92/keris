<!-- ================= OFFCANVAS ANALISIS ================= -->
<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasAnalisis"
    style="width: 600px; max-width: 95vw;">

    <div class="offcanvas-header border-bottom" style="background:#f8f9fa">
        <div>
            <h5 class="mb-0 fw-semibold">Detail & Evaluasi Risiko</h5>
            <small class="text-muted">Analisis Risiko</small>
        </div>
    </div>

    <div class="offcanvas-body">
        <form id="formAnalisis">
            <input type="hidden" name="id_identifikasi" id="id_identifikasi">
            <input type="hidden" name="id_penilaian" id="id_penilaian">

            <div class="mb-3">
                <label class="form-label">Kode Risiko</label>
                <input type="text" id="form_kode" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Pernyataan Risiko</label>
                <textarea id="form_risiko" class="form-control" rows="3" readonly></textarea>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label">Kemungkinan (P)</label>
                <select name="id_kemungkinan" class="form-select" required>
                    <option value="">— Pilih —</option>
                    <?php foreach ($kemungkinanList as $k): ?>
                        <option value="<?= $k['id_kemungkinan'] ?>">
                            Level <?= $k['level'] ?>
                            (<?= esc($k['nama_level']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Dampak (D)</label>
                <select name="id_dampak" class="form-select" required>
                    <option value="">— Pilih —</option>
                    <?php foreach ($dampakList as $d): ?>
                        <option value="<?= $d['id_dampak'] ?>">
                            Level <?= $d['level'] ?>
                            (<?= esc($d['nama_level']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>

            <div id="previewSection" class="d-none">

                <div class="mb-2">
                    <strong>Nilai Risiko:</strong>
                    <span id="previewNilai" class="badge bg-dark"></span>
                </div>

                <div class="mb-2">
                    <strong>Level Risiko:</strong>
                    <span id="previewSelera" class="badge bg-secondary"></span>
                </div>

                <div class="mb-2">
                    <strong>Rekomendasi Tindakan:</strong>
                    <div id="previewTindakan" class="small text-muted"></div>
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label">Catatan Analis</label>
                <textarea name="catatan_analis" class="form-control" rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">

                <button type="button" id="btnEdit"
                    class="btn btn-warning d-none">
                    Edit
                </button>

                <div class="ms-auto">
                    <button type="submit" id="btnSave"
                        class="btn btn-primary d-none">
                        Simpan
                    </button>

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="offcanvas">
                        Tutup
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let analisisMode = 'create'; // create | view | edit

    function setViewMode() {
        analisisMode = 'view';
        document.querySelector('[name="id_kemungkinan"]').setAttribute('disabled', true);
        document.querySelector('[name="id_dampak"]').setAttribute('disabled', true);
        document.querySelector('[name="catatan_analis"]').setAttribute('disabled', true);
        document.getElementById('btnEdit').classList.remove('d-none');
        document.getElementById('btnSave').classList.add('d-none');
    }

    function setEditMode(isCreate = false) {
        analisisMode = isCreate ? 'create' : 'edit';
        document.querySelector('[name="id_kemungkinan"]').removeAttribute('disabled');
        document.querySelector('[name="id_dampak"]').removeAttribute('disabled');
        document.querySelector('[name="catatan_analis"]').removeAttribute('disabled');
        document.getElementById('btnEdit').classList.add('d-none');
        document.getElementById('btnSave').classList.remove('d-none');
        document.getElementById('btnSave').innerText =
            isCreate ? 'Simpan Analisis' : 'Simpan Perubahan';
    }

    function resetAnalisisForm() {
        document.getElementById('formAnalisis').reset();
        document.getElementById('id_identifikasi').value = '';
        document.getElementById('id_penilaian').value = '';
        document.getElementById('form_kode').value = '';
        document.getElementById('form_risiko').value = '';
        document.getElementById('previewSection').classList.add('d-none');
    }

    function openAnalisisForm(idIdentifikasi, idPenilaian = null, kode = '', risiko = '') {

        const offcanvas = new bootstrap.Offcanvas('#offcanvasAnalisis');
        offcanvas.show();

        document.getElementById('id_identifikasi').value = idIdentifikasi;
        document.getElementById('form_kode').value = kode;
        document.getElementById('form_risiko').value = risiko;

        if (idPenilaian) {
            fetch(`<?= site_url('analisis-risiko/detail') ?>/${idPenilaian}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('id_penilaian').value = data.id_penilaian;
                    document.querySelector('[name="id_kemungkinan"]').value = data.id_kemungkinan;
                    document.querySelector('[name="id_dampak"]').value = data.id_dampak;
                    document.querySelector('[name="catatan_analis"]').value = data.catatan_analis ?? '';

                    loadPreview();
                    setViewMode();
                });
        } else {
            resetAnalisisForm();
            document.getElementById('id_penilaian').value = '';
            setEditMode(true);
        }
    }

    const kemungkinanSelect = document.querySelector('[name="id_kemungkinan"]');
    const dampakSelect = document.querySelector('[name="id_dampak"]');

    function loadPreview() {

        const idKemungkinan = kemungkinanSelect.value;
        const idDampak = dampakSelect.value;

        if (!idKemungkinan || !idDampak) return;

        fetch("<?= site_url('analisis-risiko/preview') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id_kemungkinan=${idKemungkinan}&id_dampak=${idDampak}`
            })
            .then(res => res.json())
            .then(res => {

                if (res.status !== 'success') return;

                document.getElementById('previewSection').classList.remove('d-none');

                document.getElementById('previewNilai').innerText = res.nilai_risiko;
                document.getElementById('previewNilai').style.backgroundColor = res.warna;

                document.getElementById('previewSelera').innerText = res.nama_selera;
                document.getElementById('previewTindakan').innerText = res.tindakan;

            });
    }

    kemungkinanSelect.addEventListener('change', loadPreview);
    dampakSelect.addEventListener('change', loadPreview);

    document.getElementById('formAnalisis').addEventListener('submit', function(e) {

        e.preventDefault();

        const idPenilaian = document.getElementById('id_penilaian').value;

        const url = idPenilaian ?
            `<?= site_url('analisis-risiko/update') ?>/${idPenilaian}` :
            `<?= site_url('analisis-risiko/store') ?>`;

        fetch(url, {
                method: 'POST',
                body: new FormData(this)
            })
            .then(res => res.json())
            .then(res => {
                location.reload();
            });

    });

    document.getElementById('btnEdit').addEventListener('click', function() {
        setEditMode(false);
    });
</script>