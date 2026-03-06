<div class="d-flex justify-content-between mb-2">
    <small class="text-muted">
        Menampilkan <?= count($data) ?> dari <?= $pager->getTotal() ?> data
    </small>
    <?= $pager->links() ?>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th>Kode</th>
                <th>Proses</th>
                <th>Sasaran Kinerja</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['kode_sasaran']) ?></td>
                    <td><?= esc($row['kode_proses'] ?? '-') ?></td>
                    <td><?= esc($row['uraian_sasaran']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= view('penetapan_konteks/tabs/sasaran_kinerja/_offcanvas_form') ?>