<div class="d-flex justify-content-between align-items-center mb-3">

    <h5 class="mb-0">Daftar Konteks</h5>

    <button class="btn btn-primary"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasKonteks">
        <i class="ti ti-plus"></i> Tambah Konteks
    </button>

</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Tahun</th>
                <th>Satuan Kerja</th>
                <th>Sasaran Strategis</th>
                <th width="120">Aksi</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= esc($row['tahun']) ?></td>
                        <td><?= esc($row['nama_satuan_kerja']) ?></td>
                        <td><?= esc($row['uraian_sasaran']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning">
                                Edit
                            </button>
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Belum ada data konteks.
                    </td>
                </tr>
            <?php endif; ?>

        </tbody>
    </table>
</div>