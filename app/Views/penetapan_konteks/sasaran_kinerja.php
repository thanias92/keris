<div class="d-flex justify-content-between mb-2">
    <small class="text-muted">
        Menampilkan <?= count($data) ?> dari <?= $pager->getTotal() ?> data
    </small>

    <?= $pager->links('default', 'bootstrap_pagination') ?>
</div>

<div class="table-responsive" style="max-height: 420px; overflow-y: auto;">
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
    /* =====================================================
     * STATE GLOBAL (MENIRU PROSES BISNIS)
     * =================================================== */
    let sasaranFormMode = 'create';
    let originalData = {};
    let isDirty = false;

    function setOriginalData(data) {
        originalData = JSON.stringify(data);
        isDirty = false;
    }

    function checkDirty() {
        const currentData = JSON.stringify({
            proses: document.getElementById('id_proses').value,
            sasaran: document.getElementById('uraian_sasaran').value
        });

        isDirty = currentData !== originalData;
        return isDirty;
    }

    /* =====================================================
     * MODE HANDLER (RESET / READONLY / EDIT)
     * =================================================== */
    function resetSasaranKinerjaForm() {
        sasaranFormMode = 'create';

        offcanvasTitleSasaran.innerText = 'Tambah Sasaran Kinerja';
        formSasaranKinerja.action =
            "<?= site_url('penetapan-konteks/sasaran-kinerja/store') ?>";

        id_sasaran.value = '';
        id_proses.value = '';
        uraian_sasaran.value = '';
        kode_sasaran.value = '';

        btnDeleteSasaran.classList.add('d-none');
        btnEditSasaran.classList.add('d-none');
        btnSimpanSasaran.classList.remove('d-none');

        document.querySelectorAll(
            '#formSasaranKinerja select, #formSasaranKinerja textarea'
        ).forEach(el => el.disabled = false);

        fetch("<?= site_url('penetapan-konteks/sasaran-kinerja/generate-kode') ?>")
            .then(res => res.json())
            .then(data => {
                kode_sasaran.value = data.kode;
            });

        setOriginalData({
            proses: '',
            sasaran: ''
        });
    }

    function setReadOnlyMode() {
        document.querySelectorAll(
            '#formSasaranKinerja select, #formSasaranKinerja textarea'
        ).forEach(el => el.disabled = true);

        btnEditSasaran.classList.remove('d-none');
        btnDeleteSasaran.classList.remove('d-none');
        btnSimpanSasaran.classList.add('d-none');
    }

    function setEditMode() {
        document.querySelectorAll(
            '#formSasaranKinerja select, #formSasaranKinerja textarea'
        ).forEach(el => el.disabled = false);

        btnEditSasaran.classList.add('d-none');
        btnSimpanSasaran.classList.remove('d-none');
    }

    /* =====================================================
     * KLIK BARIS TABEL → DETAIL (READ ONLY)
     * =================================================== */
    document.querySelectorAll('.sasaran-row').forEach(row => {
        row.addEventListener('click', function() {
            const id = this.dataset.id;

            document.querySelectorAll('.sasaran-row')
                .forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');

            fetch(
                    "<?= site_url('penetapan-konteks/sasaran-kinerja/detail') ?>/" + id
                )
                .then(res => res.json())
                .then(data => {

                    sasaranFormMode = 'edit';

                    offcanvasTitleSasaran.innerText = 'Detail Sasaran Kinerja';

                    id_sasaran.value = data.id_sasaran;
                    id_proses.value = data.id_proses;
                    uraian_sasaran.value = data.uraian_sasaran;
                    kode_sasaran.value = data.kode_sasaran;

                    formSasaranKinerja.action =
                        "<?= site_url('penetapan-konteks/sasaran-kinerja/update') ?>/" + id;

                    setReadOnlyMode();
                    setOriginalData({
                        proses: data.id_proses,
                        sasaran: data.uraian_sasaran
                    });

                    new bootstrap.Offcanvas(
                        document.getElementById('offcanvasSasaranKinerja')
                    ).show();
                });
        });
    });

    /* =====================================================
     * BUTTON EVENTS (MENIRU PROSES BISNIS)
     * =================================================== */

    // EDIT
    btnEditSasaran.addEventListener('click', function() {
        offcanvasTitleSasaran.innerText = 'Edit Sasaran Kinerja';
        setEditMode();
    });

    // SIMPAN
    btnSimpanSasaran.addEventListener('click', function() {

        if (!checkDirty()) {
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

        const form = document.getElementById('formSasaranKinerja');
        const isEdit = document.getElementById('id_sasaran').value !== '';

        if (isEdit) {
            confirmUpdateSasaranKinerja(form);
        } else {
            confirmSaveSasaranKinerja(form);
        }
    });

    // DELETE
    btnDeleteSasaran.addEventListener('click', function() {
        const id = id_sasaran.value;

        Swal.fire({
            title: 'Hapus Sasaran Kinerja?',
            text: 'Data yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33',
            customClass: {
                popup: 'swal-mantis'
            }
        }).then(result => {
            if (result.isConfirmed) {
                const form = document.getElementById('formDeleteSasaran');
                form.action =
                    "<?= site_url('penetapan-konteks/sasaran-kinerja/delete') ?>/" + id;
                form.submit();
            }
        });
    });
</script>

<script src="<?= base_url('assets/js/sasaran-kinerja.alert.js') ?>"></script>