<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th>Pernyataan Risiko</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr class="empty-row">
                    <td colspan="2" class="text-center text-muted py-4">
                        Belum ada data bank risiko.
                    </td>
                </tr>
            <?php else: ?>
                <?php
                $currentPage = $pager->getCurrentPage('bank_risiko') ?? 1;
                $no = (($currentPage - 1) * $perPage) + 1;
                foreach ($data as $row): ?>
                    <tr class="br-row" style="cursor:pointer;"
                        data-id="<?= $row['id_bank_risiko'] ?>"
                        data-pernyataan="<?= esc($row['pernyataan_risiko']) ?>">
                        <td><?= $no++ ?></td>
                        <td><?= esc($row['pernyataan_risiko']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- PAGINATION & INFO -->
<div class="d-flex justify-content-between align-items-center px-3 pb-3">
    <div class="d-flex align-items-center gap-2">
        <select class="form-select form-select-sm" style="width: auto;" id="bankRisikoPerPage">
            <?php foreach ([5, 10, 25, 50] as $opt): ?>
                <option value="<?= $opt ?>" <?= $perPage == $opt ? 'selected' : '' ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">
            <?php
            $currentPage = $pager->getCurrentPage('bank_risiko') ?? 1;
            $total       = $pager->getTotal('bank_risiko');
            $from        = $total > 0 ? (($currentPage - 1) * $perPage + 1) : 0;
            $to          = min($currentPage * $perPage, $total);
            ?>
            Menampilkan <?= $from ?>–<?= $to ?> dari <?= $total ?> data
        </small>
    </div>
    <div>
        <?= $pager->links('bank_risiko') ?>
    </div>
</div>