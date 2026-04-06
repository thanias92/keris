<div class="card border-0 shadow-sm" id="plTableCard">
    <div class="card-body">

        <div class="ar-table-scroll">
            <table class="table table-hover align-middle mb-0" id="plTable">

                <thead class="table-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Risiko</th>
                        <th>RTP</th>
                        <th style="width:160px">Target Output</th>
                        <th style="width:120px" class="text-center">Target Waktu</th>
                        <th style="width:160px">Realisasi Output</th>
                        <th style="width:120px" class="text-center">Realisasi Waktu</th>
                        <th style="width:130px" class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="ti ti-inbox fs-3 d-block mb-2 opacity-25"></i>
                                Tidak ada data pelaporan risiko.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php
                        $no = $from ?? 1;
                        foreach ($data as $row):
                            $status = $row['status'] ?? 'Belum Dilaksanakan';
                            $badge  = match ($status) {
                                'Selesai'      => 'success',
                                'Dalam Proses' => 'warning',
                                'Terlambat'    => 'danger',
                                default        => 'secondary',
                            };
                        ?>

                            <tr class="pl-row"
                                data-id="<?= esc($row['id_rtp']) ?>"
                                style="cursor:pointer">

                                <!-- NO -->
                                <td><?= $no++ ?></td>

                                <!-- RISIKO -->
                                <td class="ar-risiko-cell">
                                    <div class="fw-semibold text-truncate ar-risiko-text"
                                        style="font-size:0.875rem"
                                        title="<?= esc($row['pernyataan_risiko']) ?>">
                                        <?= esc($row['pernyataan_risiko']) ?>
                                    </div>
                                    <?php if (!empty($row['nama_satuan_kerja'])): ?>
                                        <div class="text-muted text-truncate ar-risiko-text"
                                            style="font-size:0.78rem"
                                            title="<?= esc($row['nama_satuan_kerja']) ?>">
                                            <i class="ti ti-building me-1"></i><?= esc($row['nama_satuan_kerja']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- RTP -->
                                <td class="ar-risiko-cell">
                                    <div class="text-truncate ar-risiko-text"
                                        style="font-size:0.85rem"
                                        title="<?= esc($row['uraian_rtp']) ?>">
                                        <?= esc($row['uraian_rtp']) ?>
                                    </div>
                                </td>

                                <!-- TARGET OUTPUT -->
                                <td>
                                    <div class="text-truncate small"
                                        title="<?= esc($row['target_output']) ?>">
                                        <?= esc($row['target_output'] ?? '-') ?>
                                    </div>
                                </td>

                                <!-- TARGET WAKTU -->
                                <td class="text-center">
                                    <?php if (!empty($row['target_waktu'])): ?>
                                        <?php
                                        $ts = strtotime($row['target_waktu']);
                                        ?>
                                        <div class="fw-semibold"><?= date('M', $ts) ?></div>
                                        <div class="text-muted small"><?= date('Y', $ts) ?></div>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- REALISASI OUTPUT -->
                                <td>
                                    <div class="text-truncate small"
                                        title="<?= esc($row['realisasi_output'] ?? '') ?>">
                                        <?= esc($row['realisasi_output'] ?? '-') ?>
                                    </div>
                                </td>

                                <!-- REALISASI WAKTU -->
                                <td class="text-center">
                                    <?php if (!empty($row['realisasi_waktu'])): ?>
                                        <?php
                                        $ts = strtotime($row['realisasi_waktu']);
                                        ?>
                                        <div class="fw-semibold"><?= date('M', $ts) ?></div>
                                        <div class="text-muted small"><?= date('Y', $ts) ?></div>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS -->
                                <td class="text-center">
                                    <span class="badge bg-<?= $badge ?>-subtle text-<?= $badge ?> border border-<?= $badge ?>">
                                        <?= esc($status) ?>
                                    </span>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div><!-- /.card-body -->

    <!-- BOTTOM: per-page + info + pagination -->
    <?php if (!empty($data)): ?>
        <div class="ar-table-bottom">

            <!-- PER PAGE + INFO -->
            <div class="ar-table-info">
                <form method="get" class="ar-perpage-form" id="plPerPageForm">
                    <select name="perPage" class="ar-perpage"
                        onchange="document.getElementById('plPerPageForm').submit()">
                        <?php foreach ([5, 10, 25, 50] as $size): ?>
                            <option value="<?= $size ?>"
                                <?= ($perPage ?? 10) == $size ? 'selected' : '' ?>>
                                <?= $size ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="ar-info-text">
                    Menampilkan <?= $from ?? 1 ?>–<?= $to ?? count($data) ?>
                    dari <?= $total ?? count($data) ?> data
                </div>
            </div>

            <!-- PAGINATION -->
            <?php if (isset($pager) && ($pager['totalPages'] ?? 1) > 1): ?>
                <div class="ar-pagination">
                    <ul class="pagination mb-0">

                        <li class="page-item <?= $pager['currentPage'] <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $pager['currentPage'] - 1 ?>&perPage=<?= $perPage ?>">
                                &laquo;
                            </a>
                        </li>

                        <?php
                        $cur         = $pager['currentPage'];
                        $total_pages = $pager['totalPages'];
                        $shown       = [];
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i === 1 || $i === $total_pages || abs($i - $cur) <= 2) {
                                $shown[] = $i;
                            }
                        }
                        $prev = null;
                        foreach ($shown as $i):
                            if ($prev !== null && $i - $prev > 1): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">…</span>
                                </li>
                            <?php endif; ?>
                            <li class="page-item <?= $i === $cur ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $i ?>&perPage=<?= $perPage ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php $prev = $i;
                        endforeach; ?>

                        <li class="page-item <?= $cur >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $cur + 1 ?>&perPage=<?= $perPage ?>">
                                &raquo;
                            </a>
                        </li>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>