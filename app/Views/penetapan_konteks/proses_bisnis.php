<?php if ($activeKonteks): ?>
    <!-- ================= KONTEKS AKTIF (BAGIAN B) ================= -->
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body py-3">
            <div class="row small text-muted">
                <div class="col-md-3 mb-2">
                    <strong>Satuan Kerja</strong><br>
                    <?= esc($activeKonteks['nama_satuan_kerja']) ?>
                </div>
                <div class="col-md-3 mb-2">
                    <strong>Pengelola Risiko</strong><br>
                    <?= esc($activeKonteks['pengelola_risiko']) ?>
                </div>
                <div class="col-md-3 mb-2">
                    <strong>Tahun</strong><br>
                    <?= esc($activeKonteks['tahun']) ?>
                </div>
                <div class="col-md-3 mb-2">
                    <strong>Sasaran Strategis</strong><br>
                    <?= esc($activeKonteks['uraian_sasaran']) ?>
                </div>
                <div class="col-12 mt-2">
                    <strong>Kegiatan</strong><br>
                    <?= esc($activeKonteks['kegiatan']) ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="ti ti-alert-circle"></i>
        Silakan tetapkan <strong>Konteks</strong> terlebih dahulu.
    </div>
<?php endif; ?>

<!-- ================= INFO PAGINATION ================= -->
<div class="d-flex justify-content-between mb-2">
    <small class="text-muted">
        Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('proses') ?> data
    </small>
    <?= $pager->links('default', 'bootstrap_pagination') ?>
</div>

<!-- ================= TABEL PROSES BISNIS ================= -->
<div class="table-responsive" style="max-height:420px; overflow-y:auto;">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="15%">Kode</th>
                <th>Uraian Proses</th>
                <th width="15%">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr class="proses-row cursor-pointer"
                    data-id="<?= $row['id_proses'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['kode_proses']) ?></td>
                    <td><?= esc($row['uraian_proses']) ?></td>
                    <td>
                        <span class="badge <?= $row['jenis_proses'] === 'Teknis' ? 'bg-primary' : 'bg-secondary' ?>">
                            <?= esc($row['jenis_proses']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ================= OFFCANVAS FORM ================= -->
<?= $this->include('penetapan_konteks/proses_bisnis_form') ?>

<script>
    /* ======================================================
   GLOBAL STATE
====================================================== */
    let formMode = 'create';
    let originalData = {};
    let isDirty = false;

    /* ======================================================
       HELPER
    ====================================================== */
    function setOriginalData(data) {
        originalData = JSON.stringify(data);
        isDirty = false;
    }

    function checkDirty() {
        const current = JSON.stringify({
            jenis: document.querySelector('input[name="jenis_proses"]:checked')?.value,
            kode: document.getElementById('kode_proses')?.value,
            uraian: document.querySelector('input[name="uraian_proses"]')?.value
        });
        isDirty = current !== originalData;
        return isDirty;
    }

    /* ======================================================
       MODE HANDLER
    ====================================================== */
    function resetProsesBisnisForm() {
        formMode = 'create';

        document.getElementById('offcanvasTitle').innerText = 'Tambah Proses Bisnis';
        document.getElementById('formProsesBisnis').action =
            "<?= site_url('penetapan-konteks/proses-bisnis/store') ?>";

        document.querySelectorAll('#formProsesBisnis input')
            .forEach(el => el.disabled = false);

        document.getElementById('id_proses').value = '';
        document.getElementById('kode_proses').value = '';
        document.querySelector('[name="uraian_proses"]').value = '';
        document.querySelectorAll('[name="jenis_proses"]').forEach(r => r.checked = false);

        document.getElementById('btnEditProses')?.classList.add('d-none');
        document.getElementById('btnDeleteProses')?.classList.add('d-none');
        document.getElementById('btnSimpanProses').classList.remove('d-none');
    }

    function setReadOnlyMode() {
        document.querySelectorAll('#formProsesBisnis input')
            .forEach(el => el.disabled = true);

        document.getElementById('btnSimpanProses').classList.add('d-none');
        document.getElementById('btnEditProses')?.classList.remove('d-none');
        document.getElementById('btnDeleteProses')?.classList.remove('d-none');
    }

    function setEditMode() {
        document.querySelectorAll('#formProsesBisnis input')
            .forEach(el => el.disabled = false);

        document.getElementById('btnSimpanProses').classList.remove('d-none');
        document.getElementById('btnEditProses')?.classList.add('d-none');
        document.getElementById('btnDeleteProses')?.classList.add('d-none');
    }

    /* ======================================================
       OFFCANVAS INSTANCE (SATU-SATUNYA)
    ====================================================== */
    let offcanvasPB = null;

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bootstrap !== 'undefined') {
            const offcanvasEl = document.getElementById('offcanvasProsesBisnis');
            offcanvasPB = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);
        } else {
            console.error("Bootstrap JS tidak ter-load.");
        }
    });

    /* ======================================================
       ROW CLICK → DETAIL
    ====================================================== */
    document.addEventListener('click', function(e) {
        const row = e.target.closest('.proses-row');
        if (!row) return;

        const id = row.dataset.id;

        document.querySelectorAll('.proses-row')
            .forEach(r => r.classList.remove('table-active'));
        row.classList.add('table-active');

        fetch("<?= site_url('penetapan-konteks/proses-bisnis/detail') ?>/" + id)
            .then(res => res.json())
            .then(data => {
                formMode = 'edit';

                document.getElementById('offcanvasTitle').innerText = 'Detail Proses Bisnis';

                document.getElementById('id_proses').value = data.id_proses;
                document.getElementById('kode_proses').value = data.kode_proses;
                document.querySelector('[name="uraian_proses"]').value = data.uraian_proses;

                document.querySelector(
                    `input[name="jenis_proses"][value="${data.jenis_proses === 'Teknis' ? 'S' : 'K'}"]`
                ).checked = true;

                document.getElementById('formProsesBisnis').action =
                    "<?= site_url('penetapan-konteks/proses-bisnis/update') ?>/" + data.id_proses;

                setReadOnlyMode();

                if (offcanvasPB) {
                    offcanvasPB.show();
                }
            });
    });
    /* ======================================================
        EDIT BUTTON
    ====================================================== */
    document.getElementById('btnEditProses')?.addEventListener('click', function() {

        formMode = 'edit';

        document.getElementById('offcanvasTitle').innerText = 'Ubah Proses Bisnis';

        setEditMode();

        setOriginalData({
            jenis: document.querySelector('input[name="jenis_proses"]:checked')?.value,
            kode: document.getElementById('kode_proses')?.value,
            uraian: document.querySelector('input[name="uraian_proses"]')?.value
        });

    });
</script>