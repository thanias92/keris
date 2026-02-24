<!-- ================= OFFCANVAS ANALISIS ================= -->
<div class="offcanvas offcanvas-end shadow-lg"
    tabindex="-1"
    id="offcanvasAnalisis"
    style="width: 600px; max-width: 95vw;">

    <div class="offcanvas-header border-bottom bg-light">
        <div>
            <h5 class="mb-0 fw-semibold">Detail & Evaluasi Risiko</h5>
            <small class="text-muted">Analisis Risiko</small>
        </div>
    </div>

    <div class="offcanvas-body">

        <form id="formAnalisis">
            <?php if (!empty($activeKonteks)): ?>
                <div class="card border-0 shadow-sm mb-3 bg-light">
                    <div class="card-body py-2 small">
                        <div><strong>Satuan Kerja:</strong> <?= esc($activeKonteks['nama_satuan_kerja']) ?></div>
                        <div><strong>Tahun:</strong> <?= esc($activeKonteks['tahun']) ?></div>
                        <div><strong>Kegiatan:</strong> <?= esc($activeKonteks['kegiatan']) ?></div>
                        <div><strong>Sasaran:</strong> <?= esc($activeKonteks['uraian_sasaran']) ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <input type="hidden" name="id_identifikasi" id="id_identifikasi">
            <input type="hidden" name="id_penilaian" id="id_penilaian">

            <div class="mb-3">
                <label class="form-label">Kode Risiko</label>
                <input type="text" id="form_kode" class="form-control" readonly>
            </div>

            <!-- INFO PROSES -->
            <div class="card border-0 shadow-sm mb-4 bg-light">
                <div class="card-body py-3">

                    <div class="mb-2">
                        <div class="text-muted small">Proses Bisnis</div>
                        <div class="fw-semibold" id="infoProses">-</div>
                    </div>

                    <div>
                        <div class="text-muted small">Sasaran Kinerja</div>
                        <div class="fw-semibold" id="infoSasaran">-</div>
                    </div>

                </div>
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
                            Level <?= $k['level'] ?> (<?= esc($k['nama_level']) ?>)
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
                            Level <?= $d['level'] ?> (<?= esc($d['nama_level']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>

            <!-- PREVIEW -->
            <div id="previewSection" class="d-none">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <div class="text-muted small">Nilai Risiko</div>
                            <div class="fs-3 fw-bold" id="previewNilaiText">0</div>
                        </div>

                        <span id="previewLevel" class="badge fs-6 px-3 py-2"></span>

                    </div>
                </div>

                <div class="mb-2">
                    <strong>Level Risiko:</strong>
                    <span id="previewSeleraText" class="badge bg-secondary"></span>
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

                <button type="button" id="btnEdit" class="btn btn-warning d-none">
                    Edit
                </button>

                <div class="ms-auto">
                    <button type="submit" id="btnSave" class="btn btn-primary d-none"></button>

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
    let analisisMode = 'create';

    const kemungkinanSelect = document.querySelector('[name="id_kemungkinan"]');
    const dampakSelect = document.querySelector('[name="id_dampak"]');

    function setViewMode() {
        kemungkinanSelect.disabled = true;
        dampakSelect.disabled = true;
        document.querySelector('[name="catatan_analis"]').disabled = true;

        btnEdit.classList.remove('d-none');
        btnSave.classList.add('d-none');
    }

    function setEditMode(isCreate = false) {
        kemungkinanSelect.disabled = false;
        dampakSelect.disabled = false;
        document.querySelector('[name="catatan_analis"]').disabled = false;

        btnEdit.classList.add('d-none');
        btnSave.classList.remove('d-none');
        btnSave.innerText = isCreate ? 'Simpan Analisis' : 'Simpan Perubahan';
    }

    function resetForm() {
        formAnalisis.reset();
        previewSection.classList.add('d-none');
    }

    function openAnalisisForm(idIdentifikasi, idPenilaian = null, kode = '', risiko = '', proses = '', sasaran = '') {

        const offcanvas = bootstrap.Offcanvas.getOrCreateInstance('#offcanvasAnalisis');
        offcanvas.show();

        resetForm();

        id_identifikasi.value = idIdentifikasi;
        form_kode.value = kode;
        form_risiko.value = risiko;
        infoProses.innerText = proses || '-';
        infoSasaran.innerText = sasaran || '-';

        if (idPenilaian) {

            fetch(`<?= site_url('analisis-risiko/detail') ?>/${idPenilaian}`)
                .then(res => res.json())
                .then(data => {

                    id_penilaian.value = data.id_penilaian;
                    kemungkinanSelect.value = data.id_kemungkinan;
                    dampakSelect.value = data.id_dampak;
                    document.querySelector('[name="catatan_analis"]').value = data.catatan_analis ?? '';

                    loadPreview();
                    setViewMode();
                });

        } else {

            id_penilaian.value = '';
            setEditMode(true);
        }
    }

    function loadPreview() {

        previewSection.classList.add('d-none');

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

                previewSection.classList.remove('d-none');

                previewNilaiText.innerText = res.nilai_risiko;
                previewNilaiText.style.color = res.warna;

                previewLevel.innerText = res.nama_selera;
                previewLevel.style.backgroundColor = res.warna;
                previewLevel.style.color = '#fff';

                previewSeleraText.innerText = res.nama_selera;
                previewTindakan.innerText = res.tindakan;
            });
    }

    kemungkinanSelect.addEventListener('change', loadPreview);
    dampakSelect.addEventListener('change', loadPreview);

    formAnalisis.addEventListener('submit', function(e) {

        e.preventDefault();

        const isEdit = id_penilaian.value !== '';

        const url = isEdit ?
            `<?= site_url('analisis-risiko/update') ?>/${id_penilaian.value}` :
            `<?= site_url('analisis-risiko/store') ?>`;

        Swal.fire({
            title: isEdit ? 'Simpan Perubahan?' : 'Simpan Analisis?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) return;

            fetch(url, {
                    method: 'POST',
                    body: new FormData(formAnalisis)
                })
                .then(res => res.json())
                .then(() => {

                    bootstrap.Offcanvas.getInstance(offcanvasAnalisis).hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil disimpan',
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => location.reload());
                });

        });

    });

    btnEdit.addEventListener('click', () => setEditMode(false));
</script>