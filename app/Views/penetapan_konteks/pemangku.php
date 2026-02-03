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
                <th width="35%">Nama Instansi</th>
                <th>Hubungan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr class="cursor-pointer pemangku-row"
                    data-id="<?= $row['id_pemangku'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_instansi']) ?></td>
                    <td><?= esc($row['hubungan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('penetapan_konteks/pemangku_kepentingan_form') ?>

<script>
    /* =====================================================
     * STATE GLOBAL (MENIRU PROSES BISNIS)
     * =================================================== */
    let pemangkuFormMode = 'create';
    let originalData = {};
    let isDirty = false;

    function setOriginalData(data) {
        originalData = JSON.stringify(data);
        isDirty = false;
    }

    function checkDirty() {
        const currentData = JSON.stringify({
            nama: nama_instansi.value,
            hubungan: hubungan.value
        });
        isDirty = currentData !== originalData;
        return isDirty;
    }

    /* =====================================================
     * MODE HANDLER
     * =================================================== */
    function resetPemangkuKepentinganForm() {

        pemangkuFormMode = 'create';

        offcanvasTitlePemangku.innerText = 'Tambah Pemangku Kepentingan';
        formPemangkuKepentingan.action =
            "<?= site_url('penetapan-konteks/pemangku/store') ?>";

        id_pemangku.value = '';
        nama_instansi.value = '';
        hubungan.value = '';

        btnDeletePemangku.classList.add('d-none');
        btnEditPemangku.classList.add('d-none');
        btnSimpanPemangku.classList.remove('d-none');

        document.querySelectorAll(
            '#formPemangkuKepentingan input'
        ).forEach(el => el.disabled = false);

        setOriginalData({
            nama: '',
            hubungan: ''
        });
    }

    function setReadOnlyMode() {
        document.querySelectorAll(
            '#formPemangkuKepentingan input'
        ).forEach(el => el.disabled = true);

        btnEditPemangku.classList.remove('d-none');
        btnDeletePemangku.classList.remove('d-none');
        btnSimpanPemangku.classList.add('d-none');
    }

    function setEditMode() {
        document.querySelectorAll(
            '#formPemangkuKepentingan input'
        ).forEach(el => el.disabled = false);

        btnEditPemangku.classList.add('d-none');
        btnSimpanPemangku.classList.remove('d-none');
    }

    /* =====================================================
     * KLIK BARIS → DETAIL
     * =================================================== */
    document.querySelectorAll('.pemangku-row').forEach(row => {
        row.addEventListener('click', function() {

            const id = this.dataset.id;

            document.querySelectorAll('.pemangku-row')
                .forEach(r => r.classList.remove('table-active'));
            this.classList.add('table-active');

            fetch(
                    "<?= site_url('penetapan-konteks/pemangku/detail') ?>/" + id
                )
                .then(res => res.json())
                .then(data => {

                    pemangkuFormMode = 'edit';

                    offcanvasTitlePemangku.innerText = 'Detail Pemangku Kepentingan';

                    id_pemangku.value = data.id_pemangku;
                    nama_instansi.value = data.nama_instansi;
                    hubungan.value = data.hubungan;

                    formPemangkuKepentingan.action =
                        "<?= site_url('penetapan-konteks/pemangku/update') ?>/" + id;

                    setReadOnlyMode();
                    setOriginalData({
                        nama: data.nama_instansi,
                        hubungan: data.hubungan
                    });

                    new bootstrap.Offcanvas(
                        document.getElementById('offcanvasPemangkuKepentingan')
                    ).show();
                });
        });
    });

    /* =====================================================
     * BUTTON EVENTS
     * =================================================== */

    // EDIT
    btnEditPemangku.addEventListener('click', function() {
        offcanvasTitlePemangku.innerText = 'Edit Pemangku Kepentingan';
        setEditMode();
    });

    // SIMPAN
    btnSimpanPemangku.addEventListener('click', function() {

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

        const form = document.getElementById('formPemangkuKepentingan');
        const isEdit = document.getElementById('id_pemangku').value !== '';

        if (isEdit) {
            confirmUpdatePemangkuKepentingan(form);
        } else {
            confirmSavePemangkuKepentingan(form);
        }
    });

    // DELETE
    btnDeletePemangku.addEventListener('click', function() {

        const id = id_pemangku.value;

        Swal.fire({
            title: 'Hapus Pemangku Kepentingan?',
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
                const form = document.getElementById('formDeletePemangku');
                form.action =
                    "<?= site_url('penetapan-konteks/pemangku/delete') ?>/" + id;
                form.submit();
            }
        });
    });
</script>
<script src="<?= base_url('assets/js/pemangku-kepentingan.alert.js') ?>"></script>