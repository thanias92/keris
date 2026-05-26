<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Kode</th>
                <th>Uraian Proses</th>
                <th width="15%">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada proses bisnis dipilih untuk konteks ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1;
                foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <span class="badge <?= $row['jenis_proses'] === 'Teknis' ? 'bg-primary' : 'bg-warning text-dark' ?>">
                                <?= esc($row['kode_proses']) ?>
                            </span>
                        </td>
                        <td><?= esc($row['uraian_proses']) ?></td>
                        <td><?= esc($row['jenis_proses']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (!empty($data)): ?>
    <div class="d-flex justify-content-between align-items-center mt-2 small text-muted">
        <span>Menampilkan <?= count($data) ?> dari <?= count($data) ?> proses bisnis</span>
    </div>
<?php endif; ?>