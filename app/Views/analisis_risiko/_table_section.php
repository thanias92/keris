<div class="card border-0 shadow-sm" id="arTableCard">
    <div class="card-body">

        <div class="ar-table-scroll">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th style="width:60px" class="text-center">Kode<br>Proses</th>
                        <th>Risiko</th>
                        <th class="text-center" style="width:80px">
                            P<br><small class="fw-normal text-muted" style="font-size:11px">Probability</small>
                        </th>
                        <th class="text-center" style="width:80px">
                            D<br><small class="fw-normal text-muted" style="font-size:11px">Dampak</small>
                        </th>
                        <th class="text-center" style="width:110px">Skor Risiko</th>
                        <th class="text-center" style="width:130px">Efektivitas</th>
                        <th style="width:150px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="ti ti-inbox fs-3 d-block mb-2 opacity-25"></i>
                                Belum ada data.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = $from ?? 1;
                        foreach ($data as $row):
                            $prefix    = strtoupper(substr($row['kode_proses'] ?? '', 0, 1));
                            $kodeBadge = match ($prefix) {
                                'S'     => 'primary',
                                'K'     => 'warning',
                                default => 'secondary',
                            };
                        ?>
                            <tr class="ar-row"
                                data-identifikasi="<?= esc($row['id_identifikasi']) ?>"
                                data-penilaian="<?= esc($row['id_penilaian'] ?? '') ?>">

                                <td><?= $no++ ?></td>

                                <!-- KODE PROSES -->
                                <td class="text-center">
                                    <span class="badge bg-<?= $kodeBadge ?>-subtle text-<?= $kodeBadge ?> border border-<?= $kodeBadge ?>">
                                        <?= esc($row['kode_proses'] ?? '-') ?>
                                    </span>
                                </td>

                                <!-- RISIKO -->
                                <td class="ar-risiko-cell">
                                    <div class="fw-semibold text-truncate ar-risiko-text"
                                        style="font-size:0.875rem"
                                        title="<?= esc($row['pernyataan_risiko']) ?>">
                                        <?= esc($row['pernyataan_risiko']) ?>
                                    </div>
                                    <?php if (!empty($row['uraian_proses'])): ?>
                                        <div class="text-muted text-truncate ar-risiko-text"
                                            style="font-size:0.78rem"
                                            title="<?= esc($row['uraian_proses']) ?>">
                                            <i class="ti ti-arrow-right me-1"></i><?= esc($row['uraian_proses']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- PROBABILITY -->
                                <td class="text-center">
                                    <?php if (!empty($row['id_penilaian'])): ?>
                                        <span class="text-secondary" style="font-size:0.85rem">
                                            <?= esc($row['level_kemungkinan'] ?? '—') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- DAMPAK -->
                                <td class="text-center">
                                    <?php if (!empty($row['id_penilaian'])): ?>
                                        <span class="text-secondary" style="font-size:0.85rem">
                                            <?= esc($row['level_dampak'] ?? '—') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- SKOR RISIKO -->
                                <td class="text-center">
                                    <?php if (!empty($row['id_penilaian']) && !empty($row['nilai_risiko'])): ?>
                                        <?php $warnaCell = hex_warna_selera_risiko($row['warna_risiko'] ?? null); ?>
                                        <span class="badge fw-bold px-2 py-1"
                                            style="background-color:<?= $warnaCell ?>;color:#fff;font-size:0.9rem">
                                            <?= esc($row['nilai_risiko']) ?>
                                        </span>
                                        <div class="fw-semibold mt-1"
                                            style="font-size:0.72rem;color:<?= $warnaCell ?>">
                                            <?= esc($row['nama_selera'] ?? '') ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- EFEKTIVITAS -->
                                <td class="text-center">
                                    <?php if (!empty($row['efektivitas'])): ?>
                                        <?php
                                        $efBadge = match ($row['efektivitas']) {
                                            'Efektif'        => 'success',
                                            'Kurang Efektif' => 'warning',
                                            'Tidak Efektif'  => 'danger',
                                            default          => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $efBadge ?>-subtle text-<?= $efBadge ?> border border-<?= $efBadge ?>">
                                            <?= esc($row['efektivitas']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS -->
                                <td>
                                    <?php if (!empty($row['id_penilaian'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <i class="ti ti-check me-1"></i>Sudah Dianalisis
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info">
                                            <i class="ti ti-clock me-1"></i>Belum Dianalisis
                                        </span>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- BOTTOM: per-page + info + pagination -->
    <?php if (!empty($data)): ?>
        <div class="ar-table-bottom">

            <div class="ar-table-info">
                <form method="get" class="ar-perpage-form" id="arPerPageForm">
                    <input type="hidden" name="filter" value="<?= esc($filter ?? '') ?>">
                    <select name="perPage" class="ar-perpage"
                        onchange="document.getElementById('arPerPageForm').submit()">
                        <?php foreach ([5, 10, 25, 50] as $size): ?>
                            <option value="<?= $size ?>"
                                <?= ($perPage ?? 5) == $size ? 'selected' : '' ?>>
                                <?= $size ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="ar-info-text">
                    Menampilkan <?= $from ?? 1 ?>–<?= $to ?? count($data) ?> dari <?= $total ?> data
                </div>
            </div>

            <?php if (isset($pager) && $pager['totalPages'] > 1): ?>
                <div class="ar-pagination">
                    <ul class="pagination mb-0">

                        <li class="page-item <?= $pager['currentPage'] <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="arGoToPage(<?= $pager['currentPage'] - 1 ?>); return false;">
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
                                    onclick="arGoToPage(<?= $i ?>); return false;">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php $prev = $i;
                        endforeach; ?>

                        <li class="page-item <?= $cur >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="arGoToPage(<?= $cur + 1 ?>); return false;">
                                &raquo;
                            </a>
                        </li>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div><!-- /.card -->

<script>
    function arGoToPage(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('perPage', <?= $perPage ?? 5 ?>);
        url.searchParams.set('filter', '<?= esc($filter ?? '') ?>');

        const wrapper = document.getElementById('arTableCard');
        const scrollY = window.scrollY;

        fetch(url.toString())
            .then(r => r.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newCard = doc.getElementById('arTableCard');
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