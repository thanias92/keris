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
                <th>Nama Peraturan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr class="cursor-pointer peraturan-row"
                    data-id="<?= $row['id_peraturan'] ?>">
                    <td><?= $no++ ?></td>
                    <td>
                        <?= esc($row['nama_peraturan']) ?>
                        <?php if ($row['is_default'] === true || $row['is_default'] === 1 || $row['is_default'] === 't'): ?>
                            <span class="badge bg-secondary ms-2">Default</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('penetapan_konteks/peraturan_form') ?>

<script>
    /* === STATE GLOBAL === */
    let formMode = 'create';
    let originalData = {};
    let isDirty = false;

    function setOriginalData(data) {
        originalData = JSON.stringify(data);
        isDirty = false;
    }

    function checkDirty() {
        const currentData = JSON.stringify({
            nama: nama_peraturan.value
        });
        isDirty = currentData !== originalData;
        return isDirty;
    }

    /* === MODE HANDLER === */
    function resetPeraturanForm() {

        formMode = 'create';

        offcanvasTitlePeraturan.innerText = 'Tambah Peraturan Terkait';
        formPeraturan.action =
            "<?= site_url('penetapan-konteks/peraturan/store') ?>";

        id_peraturan.value = '';
        nama_peraturan.value = '';

        btnEditPeraturan.classList.add('d-none');
        btnDeletePeraturan.classList.add('d-none');
        btnSimpanPeraturan.classList.remove('d-none');

        document.querySelectorAll(
            '#formPeraturan input'
        ).forEach(el => el.disabled = false);

        setOriginalData({
            nama: ''
        });
    }

    function setReadOnlyMode(isDefault) {
        document.querySelectorAll(
            '#formPeraturan input'
        ).forEach(el => el.disabled = true);

        btnSimpanPeraturan.classList.add('d-none');

        if (isDefault) {
            btnEditPeraturan.classList.add('d-none');
            btnDeletePeraturan.classList.add('d-none');
        } else {
            btnEditPeraturan.classList.remove('d-none');
            btnDeletePeraturan.classList.remove('d-none');
        }
    }

    function setEditMode() {
        document.querySelectorAll(
            '#formPeraturan input'
        ).forEach(el => el.disabled = false);

        btnEditPeraturan.classList.add('d-none');
        btnSimpanPeraturan.classList.remove('d-none');
    }

    /* === KLIK BARIS → DETAIL === */
    document.querySelectorAll('.peraturan-row').forEach(row => {
        row.addEventListener('click', function() {

            const id = this.dataset.id;

            document.querySelectorAll('.peraturan-row')
                .forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');

            fetch(
                    "<?= site_url('penetapan-konteks/peraturan/detail') ?>/" + id
                )
                .then(res => res.json())
                .then(data => {

                    formMode = 'edit';

                    offcanvasTitlePeraturan.innerText = 'Detail Peraturan Terkait';

                    id_peraturan.value = data.id_peraturan;
                    nama_peraturan.value = data.nama_peraturan;

                    formPeraturan.action =
                        "<?= site_url('penetapan-konteks/peraturan/update') ?>/" + id;

                    const isDefault = data.is_default === true || data.is_default === 1 || data.is_default === 't';
                    setReadOnlyMode(isDefault);

                    setOriginalData({
                        nama: data.nama_peraturan
                    });

                    new bootstrap.Offcanvas(
                        document.getElementById('offcanvasPeraturan')
                    ).show();
                });
        });
    });

    /* === BUTTON EVENTS === */
    // EDIT
    btnEditPeraturan.addEventListener('click', function() {
        offcanvasTitlePeraturan.innerText = 'Edit Peraturan Terkait';
        setEditMode();
    });

    // SIMPAN
    btnSimpanPeraturan.addEventListener('click', function() {

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

        const isEdit = id_peraturan.value !== '';

        if (isEdit) {
            confirmUpdatePeraturan(formPeraturan);
        } else {
            confirmSavePeraturan(formPeraturan);
        }
    });

    // DELETE
    btnDeletePeraturan.addEventListener('click', function() {

        const id = id_peraturan.value;

        Swal.fire({
            title: 'Hapus Peraturan Terkait?',
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
                const form = document.getElementById('formDeletePeraturan');
                form.action =
                    "<?= site_url('penetapan-konteks/peraturan/delete') ?>/" + id;
                form.submit();
            }
        });
    });
</script>

<script src="<?= base_url('assets/js/peraturan.alert.js') ?>"></script>