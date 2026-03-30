<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th>Nama Instansi</th>
                <th width="25%">Hubungan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr class="empty-row">
                    <td colspan="3" class="text-center text-muted py-4">
                        Belum ada pemangku kepentingan.
                    </td>
                </tr>
            <?php else: ?>
                <?php $no = $from;
                foreach ($data as $row): ?>
                    <tr class="pm-row" style="cursor:pointer;"
                        data-id="<?= $row['id_pemangku'] ?>">
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['nama_instansi']) ?></td>
                        <td><?= esc($row['hubungan']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-2 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        <select class="form-select form-select-sm" style="width:70px;"
            onchange="window.location.href='?perPage='+this.value">
            <?php foreach ([5, 10, 25, 50] as $opt): ?>
                <option value="<?= $opt ?>" <?= $perPage == $opt ? 'selected' : '' ?>>
                    <?= $opt ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">
            Menampilkan <?= $from ?>–<?= $to ?> dari <?= $total ?> data
        </small>
    </div>
    <div>
        <?= $pager->links() ?>
    </div>
</div>