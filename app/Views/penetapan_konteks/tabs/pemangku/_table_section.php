<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Pemangku Kepentingan</h5>

            <small class="text-muted">
                Daftar pemangku kepentingan pada konteks aktif
            </small>
        </div>
    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Pemangku Kepentingan</th>
                    <th width="20%">Kategori</th>
                </tr>
            </thead>

            <tbody>

                <?php if (empty($data)): ?>

                    <tr>
                        <td colspan="3" class="text-center text-muted py-5">
                            Belum ada pemangku kepentingan.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data as $row): ?>

                        <tr>

                            <td>
                                <?= $no++ ?>
                            </td>

                            <td>
                                <?= esc($row['nama_pemangku']) ?>
                            </td>

                            <td>
                                <?= esc($row['kategori'] ?? '-') ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>