<div class="card border-0 shadow-sm" id="prTableCard">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table rtp-table align-middle mb-0">

                <thead>
                    <tr class="rtp-thead-main">
                        <th rowspan="2" class="rtp-th text-center">#</th>
                        <th rowspan="2" class="rtp-th text-center">Kode<br>Proses</th>
                        <th rowspan="2" class="rtp-th">Risiko</th>
                        <th rowspan="2" class="rtp-th">RTP</th>

                        <th colspan="2" class="rtp-th text-center">Target</th>
                        <th colspan="3" class="rtp-th text-center">Realisasi</th>
                    </tr>

                    <tr class="rtp-thead-sub">
                        <th class="rtp-th text-center">Output</th>
                        <th class="rtp-th text-center">Waktu</th>

                        <th class="rtp-th text-center">Output</th>
                        <th class="rtp-th text-center">Waktu</th>
                        <th class="rtp-th text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($grouped)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="ti ti-inbox fs-3 d-block mb-2 opacity-25"></i>
                                Belum ada data. 
                            </td>
                        </tr>
                    <?php else: ?>

                        <?php
                        // =============================
                        // GROUP BY RISIKO
                        // =============================
                        $grouped = [];

                        foreach ($data as $row) {
                            $id = $row['id_identifikasi'];

                            if (!isset($grouped[$id])) {
                                $grouped[$id] = [
                                    'risiko' => $row,
                                    'rtp_list' => []
                                ];
                            }

                            $grouped[$id]['rtp_list'][] = $row;
                        }

                        $no = 1;
                        ?>

                        <?php $rtpList = $item['pemantauan_list']:

                            $rtpList   = $item['rtp_list'];
                            $rowspan   = count($rtpList);
                        ?>

                            <?php foreach ($rtpList as $i => $rtp):

                                $isFirst = ($i === 0);

                                // TARGET WAKTU
                                $bulan = $tahun = null;
                                if (!empty($rtp['target_waktu'])) {
                                    $ts = strtotime($rtp['target_waktu']);
                                    $bulan = date('M', $ts);
                                    $tahun = date('Y', $ts);
                                }

                                // REALISASI WAKTU
                                $rBulan = $rTahun = null;
                                if (!empty($rtp['realisasi_waktu'])) {
                                    $ts2 = strtotime($rtp['realisasi_waktu']);
                                    $rBulan = date('M', $ts2);
                                    $rTahun = date('Y', $ts2);
                                }

                                // STATUS BADGE
                                $status = $rtp['status'] ?? 'Belum Dilaksanakan';

                                $statusClass = match ($status) {
                                    'Selesai' => 'success',
                                    'Dalam Proses' => 'primary',
                                    'Terlambat' => 'danger',
                                    default => 'secondary'
                                };
                            ?>

                                <tr class="rtp-row" data-rtp="<?= esc($rtp['id_rtp']) ?>">
                                    <?php if ($isFirst): ?>
                                        <!-- NO -->
                                        <td rowspan="<?= $rowspan ?>" class="text-center">
                                            <?= $no++ ?>
                                        </td>

                                        <!-- KODE -->
                                        <td rowspan="<?= $rowspan ?>" class="text-center">
                                            <span class="badge bg-primary-subtle text-primary">
                                                <?= esc($rtp['kode_proses']) ?>
                                            </span>
                                        </td>

                                        <!-- RISIKO -->
                                        <td rowspan="<?= $rowspan ?>">
                                            <div class="fw-semibold">
                                                <?= esc($rtp['pernyataan_risiko']) ?>
                                            </div>
                                            <div class="text-muted small">
                                                → <?= esc($rtp['uraian_proses']) ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>

                                    <!-- RTP -->
                                    <td>
                                        <?= esc($rtp['uraian_rtp']) ?>
                                    </td>

                                    <!-- TARGET OUTPUT -->
                                    <td>
                                        <?= esc($rtp['target_output'] ?? '—') ?>
                                    </td>

                                    <!-- TARGET WAKTU -->
                                    <td class="text-center">
                                        <?php if ($bulan && $tahun): ?>
                                            <div><?= $bulan ?></div>
                                            <div class="small text-muted"><?= $tahun ?></div>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- REALISASI OUTPUT -->
                                    <td class="<?= !empty($rtp['realisasi_output']) ? 'text-danger fw-semibold' : '' ?>">
                                        <?= esc($rtp['realisasi_output'] ?? '—') ?>
                                    </td>

                                    <!-- REALISASI WAKTU -->
                                    <td class="text-center <?= !empty($rtp['realisasi_waktu']) ? 'text-danger fw-semibold' : '' ?>">
                                        <?php if ($rBulan && $rTahun): ?>
                                            <div><?= $rBulan ?></div>
                                            <div class="small text-muted"><?= $rTahun ?></div>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">
                                        <span class="badge bg-<?= $statusClass ?>-subtle text-<?= $statusClass ?> border border-<?= $statusClass ?>">
                                            <?= esc($status) ?>
                                        </span>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

    <?php if (!empty($data)): ?>
        <div class="pr-table-bottom">

            <!-- LEFT: per page + info -->
            <div class="pr-table-info">

                <form method="get" class="pr-perpage-form" id="prPerPageForm">
                    <input type="hidden" name="filter" value="<?= esc($filter ?? '') ?>">

                    <select name="perPage" class="pr-perpage"
                        onchange="document.getElementById('prPerPageForm').submit()">

                        <?php foreach ([5, 10, 25, 50] as $size): ?>
                            <option value="<?= $size ?>"
                                <?= ($perPage ?? 10) == $size ? 'selected' : '' ?>>
                                <?= $size ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </form>

                <div class="pr-info-text">
                    Menampilkan <?= $from ?? 1 ?>–<?= $to ?? count($data) ?> dari <?= $total ?> data
                </div>
            </div>

            <!-- RIGHT: pagination -->
            <?php if (isset($pager)): ?>
                <div class="pr-pagination">
                    <ul class="pagination mb-0">

                        <!-- PREV -->
                        <li class="page-item <?= $pager['currentPage'] <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="prGoToPage(<?= $pager['currentPage'] - 1 ?>); return false;">
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
                                <a class="page-link" href="#"
                                    onclick="prGoToPage(<?= $i ?>); return false;">
                                    <?= $i ?>
                                </a>
                            </li>

                        <?php $prev = $i;
                        endforeach; ?>

                        <!-- NEXT -->
                        <li class="page-item <?= $cur >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="prGoToPage(<?= $cur + 1 ?>); return false;">
                                &raquo;
                            </a>
                        </li>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>
</div>

<script>
    function prGoToPage(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('perPage', <?= $perPage ?? 10 ?>);
        url.searchParams.set('filter', '<?= esc($filter ?? '') ?>');

        const wrapper = document.getElementById('prTableCard');
        const scrollY = window.scrollY;

        fetch(url.toString())
            .then(r => r.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newCard = doc.getElementById('prTableCard');

                if (newCard && wrapper) {
                    wrapper.outerHTML = newCard.outerHTML;
                    window.history.pushState({}, '', url.toString());

                    window.scrollTo({
                        top: scrollY
                    });
                }
            });
    }
</script>