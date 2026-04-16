<div class="card border-0 shadow-sm" id="brTableCard">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Pernyataan Risiko</th>
                    </tr>
                </thead>

                <tbody id="brTableBody">
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">Belum ada data</td>
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

    </div>

    <div class="ar-table-bottom">

        <div class="ar-table-info">
            <select id="brPerPage" class="ar-perpage">
                <?php foreach ([5, 10, 25, 50] as $opt): ?>
                    <option value="<?= $opt ?>" <?= $perPage == $opt ? 'selected' : '' ?>><?= $opt ?></option>
                <?php endforeach; ?>
            </select>

            <div class="ar-info-text" id="brInfo">
                <?php
                $currentPage = $pager->getCurrentPage('bank_risiko') ?? 1;
                $total = $pager->getTotal('bank_risiko');
                $from = $total > 0 ? (($currentPage - 1) * $perPage + 1) : 0;
                $to = min($currentPage * $perPage, $total);
                ?>
                Menampilkan <?= $from ?>-<?= $to ?> dari <?= $total ?> data
            </div>
        </div>

        <div class="ar-pagination">
            <ul class="pagination mb-0">
                <?= $pager->links('bank_risiko') ?>
            </ul>
        </div>

    </div>

</div>