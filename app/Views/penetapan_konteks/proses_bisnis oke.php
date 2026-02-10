<?= $this->include('penetapan_konteks/_konteks_filter') ?>

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
                <th width="15%">Kode</th>
                <th>Uraian Proses</th>
                <th width="15%">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr class="cursor-pointer proses-row"
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
<?= $this->include('penetapan_konteks/proses_bisnis_form') ?>

<script>
    /* === STATE GLOBAL & HELPER === */
    let originalData = {};
    let isDirty = false;
    let formMode = 'create';

    function setOriginalData(data) {
        originalData = JSON.stringify(data);
        isDirty = false;
    }

    function checkDirty() {
        const currentData = JSON.stringify({
            jenis: document.querySelector('input[name="jenis_proses"]:checked')?.value,
            kode: document.getElementById('kode_proses').value,
            uraian: document.querySelector('input[name="uraian_proses"]').value
        });

        isDirty = currentData !== originalData;
        return isDirty;
    }

    /* === MODE HANDLER(RESET / READONLY / EDIT) === */
    function resetProsesBisnisForm() {
        formMode = 'create';
        document.querySelector('#offcanvasTitle').innerText = 'Tambah Proses Bisnis';
        document.querySelector('#formProsesBisnis').action =
            "<?= site_url('penetapan-konteks/proses-bisnis/store') ?>";

        document.querySelector('#id_proses').value = '';
        document.querySelector('#kode_proses').value = '';
        document.querySelector('input[name="uraian_proses"]').value = '';

        document.querySelectorAll('input[name="jenis_proses"]').forEach(r => r.checked = false);
        setEditMode();

        document.getElementById('btnDeleteProses').classList.add('d-none');
        document.getElementById('btnEditProses').classList.add('d-none');
        document.getElementById('btnSimpanProses').classList.remove('d-none');
    }

    function setReadOnlyMode() {
        document.querySelectorAll(
            '#formProsesBisnis input'
        ).forEach(el => el.disabled = true);

        document.getElementById('btnEditProses').classList.remove('d-none');
        document.getElementById('btnDeleteProses').classList.remove('d-none');
        document.getElementById('btnSimpanProses').classList.add('d-none');
    }

    function setEditMode() {
        document.querySelectorAll(
            '#formProsesBisnis input'
        ).forEach(el => {
            el.disabled = false;
        });

        document.querySelector('#btnEditProses').classList.add('d-none');
        document.querySelector('#btnSimpanProses').classList.remove('d-none');
    }

    /* === TABLE ROW CLICK → LOAD DETAIL === */
    document.querySelectorAll('.proses-row').forEach(row => {
        row.addEventListener('click', function() {
            const id = this.dataset.id;

            // reset semua
            document.querySelectorAll('.proses-row')
                .forEach(r => r.classList.remove('table-active'));

            // highlight yang diklik
            this.classList.add('table-active');

            fetch(
                    "<?= site_url('penetapan-konteks/proses-bisnis/detail') ?>/" + id
                )
                .then(res => res.json())
                .then(data => {
                    formMode = 'edit';
                    // ubah title jadi mode detail/edit
                    document.querySelector('#offcanvasTitle').innerText = 'Detail Proses Bisnis';

                    // isi form
                    document.querySelector('#id_proses').value = data.id_proses;
                    document.querySelector('#kode_proses').value = data.kode_proses;
                    document.querySelector('input[name="uraian_proses"]').value = data.uraian_proses;

                    document.querySelector(
                        `input[name="jenis_proses"][value="${data.jenis_proses === 'Teknis' ? 'S' : 'K'}"]`
                    ).checked = true;

                    // ubah action form → update
                    document.querySelector('#formProsesBisnis').action =
                        "<?= site_url('penetapan-konteks/proses-bisnis/update') ?>/" + data.id_proses;

                    setReadOnlyMode();

                    // show offcanvas
                    new bootstrap.Offcanvas(
                        document.getElementById('offcanvasProsesBisnis')
                    ).show();
                });
        });
    });

    /* === BUTTON EVENTS === */
    // Edit
    document.getElementById('btnEditProses')
        .addEventListener('click', function() {
            document.querySelector('#offcanvasTitle').innerText = 'Edit Proses Bisnis';
            setEditMode();
            setOriginalData({
                jenis: document.querySelector('input[name="jenis_proses"]:checked')?.value,
                kode: document.getElementById('kode_proses').value,
                uraian: document.querySelector('input[name="uraian_proses"]').value
            });
        });

    // Delete
    document.getElementById('btnDeleteProses')
        .addEventListener('click', function() {

            const id = document.getElementById('id_proses').value;

            Swal.fire({
                title: 'Hapus Proses Bisnis?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                customClass: {
                    popup: 'swal-mantis'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('formDeleteProses');
                    form.action = "<?= site_url('penetapan-konteks/proses-bisnis/delete') ?>/" + id;
                    form.submit();
                }
            });
        });

    /* === INIT DEFAULT STATE === */
    setOriginalData({
        jenis: null,
        kode: '',
        uraian: ''
    });
</script>