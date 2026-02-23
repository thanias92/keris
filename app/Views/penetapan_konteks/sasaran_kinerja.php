<div class="d-flex justify-content-between mb-2">
    <small class="text-muted">
        Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('sasaran') ?> data
    </small>

    <?= $pager->links('default', 'bootstrap_pagination') ?>
</div>

<?php if ($activeKonteks): ?>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="row small text-muted">
                <div class="col-md-3 col-6 mb-2">
                    <strong>Satuan Kerja</strong><br>
                    <?= esc($activeKonteks['nama_satuan_kerja']) ?>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <strong>Tahun</strong><br>
                    <?= esc($activeKonteks['tahun']) ?>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <strong>Kegiatan</strong><br>
                    <?= esc($activeKonteks['kegiatan']) ?>
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <strong>Sasaran Strategis</strong><br>
                    <?= esc($activeKonteks['uraian_sasaran']) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
    <?php if (empty($data)): ?>
        <div class="alert alert-warning d-flex align-items-center">
            <i class="ti ti-info-circle me-2"></i>
            <div>
                Belum ada Sasaran Kinerja untuk Konteks ini.
                Silakan tambahkan terlebih dahulu.
            </div>
        </div>
    <?php endif; ?>

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode Proses</th>
                <th width="30%">Proses Bisnis</th>
                <th>Sasaran Kinerja</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr class="cursor-pointer sasaran-row"
                    data-id="<?= $row['id_sasaran'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['kode_proses']) ?></td>
                    <td><?= esc($row['uraian_proses']) ?></td>
                    <td><?= esc($row['uraian_sasaran']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('penetapan_konteks/sasaran_kinerja_form') ?>

<script>
    console.log("Script Sasaran Loaded");

    document.addEventListener('DOMContentLoaded', function() {

        /* ======================================================
           GLOBAL STATE (NAMESPACE SASARAN)
        ====================================================== */
        let skFormMode = 'create';
        let skOriginalData = {};
        let skIsDirty = false;

        const offcanvasSkEl = document.getElementById('offcanvasSasaranKinerja');
        let offcanvasSK;

        if (typeof bootstrap !== 'undefined') {
            offcanvasSK = new bootstrap.Offcanvas(offcanvasSkEl);
        }

        const formSK = document.getElementById('formSasaranKinerja');
        const titleSK = document.getElementById('offcanvasTitleSasaran');
        const btnEditSK = document.getElementById('btnEditSasaran');
        const btnDeleteSK = document.getElementById('btnDeleteSasaran');
        const btnSaveSK = document.getElementById('btnSimpanSasaran');

        /* ======================================================
           HELPER
        ====================================================== */
        function skSetOriginal(data) {
            skOriginalData = JSON.stringify(data);
            skIsDirty = false;
        }

        function skCheckDirty() {
            const current = JSON.stringify({
                proses: document.getElementById('id_proses').value,
                sasaran: document.getElementById('uraian_sasaran').value
            });
            skIsDirty = current !== skOriginalData;
            return skIsDirty;
        }

        /* ======================================================
           RESET FORM
        ====================================================== */
        function resetSasaranKinerjaForm() {

            skFormMode = 'create';

            titleSK.innerText = 'Tambah Sasaran Kinerja';
            formSK.action = "<?= site_url('penetapan-konteks/sasaran-kinerja/store') ?>";

            document.getElementById('id_sasaran').value = '';
            document.getElementById('id_proses').value = '';
            document.getElementById('uraian_sasaran').value = '';
            document.getElementById('kode_sasaran').value = '';

            document.querySelectorAll('#formSasaranKinerja select, #formSasaranKinerja textarea')
                .forEach(el => el.disabled = false);

            btnEditSK.classList.add('d-none');
            btnDeleteSK.classList.add('d-none');
            btnSaveSK.classList.remove('d-none');

            fetch("<?= site_url('penetapan-konteks/sasaran-kinerja/generate-kode') ?>")
                .then(r => r.json())
                .then(d => {
                    document.getElementById('kode_sasaran').value = d.kode;
                });

            skSetOriginal({
                proses: '',
                sasaran: ''
            });
        }

        /* ======================================================
           OPEN BUTTON
        ====================================================== */
        document.getElementById('btnOpenSasaran')?.addEventListener('click', function() {
            resetSasaranKinerjaForm();
        });

        /* ======================================================
            ROW CLICK → DETAIL
        ====================================================== */
        document.addEventListener('click', function(e) {

            const row = e.target.closest('.sasaran-row');
            if (!row) return;

            const id = row.dataset.id;

            console.log("Row clicked", id);

            fetch("<?= site_url('penetapan-konteks/sasaran-kinerja/detail') ?>/" + id)
                .then(res => res.json())
                .then(data => {

                    skFormMode = 'edit';

                    titleSK.innerText = 'Detail Sasaran Kinerja';

                    document.getElementById('id_sasaran').value = data.id_sasaran;
                    document.getElementById('id_proses').value = data.id_proses;
                    document.getElementById('uraian_sasaran').value = data.uraian_sasaran;
                    document.getElementById('kode_sasaran').value = data.kode_sasaran;

                    formSK.action =
                        "<?= site_url('penetapan-konteks/sasaran-kinerja/update') ?>/" + data.id_sasaran;

                    document.querySelectorAll('#formSasaranKinerja select, #formSasaranKinerja textarea')
                        .forEach(el => el.disabled = true);

                    btnEditSK.classList.remove('d-none');
                    btnDeleteSK.classList.remove('d-none');
                    btnSaveSK.classList.add('d-none');

                    if (offcanvasSK) {
                        offcanvasSK.show();
                    }

                });

        });

        /* ======================================================
           SAVE BUTTON
        ====================================================== */
        btnSaveSK.addEventListener('click', function() {

            if (!formSK.checkValidity()) {
                formSK.reportValidity();
                return;
            }

            if (!skCheckDirty()) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak ada perubahan',
                    text: 'Tidak ada data yang diubah.',
                    customClass: {
                        popup: 'swal-mantis'
                    }
                });
                return;
            }

            if (skFormMode === 'edit') {
                confirmUpdateSasaranKinerja(formSK);
            } else {
                confirmSaveSasaranKinerja(formSK);
            }
        });

        /* ======================================================
            EDIT BUTTON
        ====================================================== */
        btnEditSK.addEventListener('click', function() {

            skFormMode = 'edit';

            titleSK.innerText = 'Ubah Sasaran Kinerja';

            document.querySelectorAll('#formSasaranKinerja select, #formSasaranKinerja textarea')
                .forEach(el => el.disabled = false);

            btnEditSK.classList.add('d-none');
            btnSaveSK.classList.remove('d-none');
        });
    });
</script>
<script src="<?= base_url('assets/js/sasaran-kinerja.alert.js') ?>"></script>