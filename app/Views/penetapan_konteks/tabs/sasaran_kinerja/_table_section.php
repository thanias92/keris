<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="10%">Kode</th>
                <th width="30%">Proses Bisnis</th>
                <th>Uraian Sasaran Kinerja</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr class="empty-row">
                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada sasaran kinerja untuk konteks ini.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = 1;
                foreach ($data as $row): ?>
                    <tr class="sk-row" style="cursor:pointer;"
                        data-id="<?= $row['id_sasaran'] ?>">
                        <td><?= $no++ ?></td>
                        <td>
                            <span class="badge <?= $row['jenis_proses'] === 'Teknis' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' ?>">
                                <?= esc($row['kode_proses']) ?>
                            </span>
                        </td>
                        <td><?= esc($row['uraian_proses_bisnis']) ?></td>
                        <td><?= esc($row['uraian_sasaran']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (!empty($data)): ?>
    <small class="text-muted">Menampilkan <?= count($data) ?> sasaran kinerja</small>
<?php endif; ?>