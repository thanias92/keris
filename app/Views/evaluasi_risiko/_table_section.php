<div class="card border-0 shadow-sm" id="erTableCard">
    <div class="card-body">

        <div class="ar-table-scroll">
            <table class="table table-hover align-middle mb-0" id="erTable">

                <thead class="table-light">
                    <tr>
                        <th style="width:40px">#</th>
                        <th style="width:60px" class="text-center">Kode<br>Proses</th>
                        <th>Risiko</th>
                        <th class="text-center" style="width:100px">Skor<br>Risiko</th>
                        <th style="width:120px">Efektivitas</th>
                        <th style="width:150px">Respon Risiko</th>
                        <th style="width:100px">Prioritas</th>
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
                        /* -------------------------------------------------------
                        * PRE-PASS: hitung prioritas otomatis
                        * Berdasarkan skor risiko tertinggi
                        * Jika skor sama → pakai urutan data
                        * ------------------------------------------------------- */
                        $prioritasMap = [];
                        $temp = [];

                        foreach ($data as $r) {
                            if (($r['opsi_tindakan'] ?? '') === 'Mengurangi') {
                                $temp[] = $r;
                            }
                        }

                        /* sort berdasarkan skor risiko DESC */
                        usort($temp, function ($a, $b) {
                            return ($b['nilai_risiko'] ?? 0) <=> ($a['nilai_risiko'] ?? 0);
                        });

                        /* assign prioritas */
                        $prioritasCounter = 1;
                        foreach ($temp as $r) {
                            $prioritasMap[$r['id_identifikasi']] = $prioritasCounter++;
                        }

                        $no = $from ?? 1;
                        foreach ($data as $row):
                            $sudah     = !empty($row['id_evaluasi']);
                            $warna     = $row['warna_risiko'] ?? null;
                            $prefix    = strtoupper(substr($row['kode_proses'] ?? '', 0, 1));
                            $kodeBadge = match ($prefix) {
                                'S'     => 'primary',
                                'K'     => 'warning',
                                default => 'secondary',
                            };
                            $noPrioritas = $prioritasMap[$row['id_identifikasi']] ?? null;
                        ?>

                            <tr class="er-row"
                                data-identifikasi="<?= esc($row['id_identifikasi']) ?>"
                                data-penilaian="<?= esc($row['id_penilaian'] ?? '') ?>"
                                data-evaluasi="<?= esc($row['id_evaluasi'] ?? '') ?>">

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

                                <!-- SKOR RISIKO -->
                                <td class="text-center">
                                    <?php if (!empty($row['id_penilaian']) && !empty($row['nilai_risiko'])): ?>
                                        <?php $warnaCell = hex_warna_selera_risiko($row['warna_risiko'] ?? null); ?>
                                        <span class="badge fw-bold px-2 py-1"
                                            style="background-color:<?= $warnaCell ?>;color:#fff;font-size:0.9rem">
                                            <?= esc($row['nilai_risiko']) ?>
                                        </span>
                                        <div class="fw-semibold mt-1"
                                            style="font-size:0.72rem;color:<?= esc($warnaCell) ?>">
                                            <?= esc($row['nama_selera'] ?? '') ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- EFEKTIVITAS -->
                                <td>
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

                                <!-- RESPON RISIKO -->
                                <td>
                                    <?php if (!empty($row['opsi_tindakan'])): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            <?= esc($row['opsi_tindakan']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- PRIORITAS -->
                                <td>
                                    <?php if ($noPrioritas !== null): ?>
                                        <?php
                                        $prClass = match (true) {
                                            $noPrioritas === 1 => 'er-prioritas-1',
                                            $noPrioritas === 2 => 'er-prioritas-2',
                                            $noPrioritas === 3 => 'er-prioritas-3',
                                            $noPrioritas === 4 => 'er-prioritas-4',
                                            $noPrioritas === 5 => 'er-prioritas-5',
                                            default            => 'er-prioritas-n',
                                        };
                                        ?>
                                        <span class="badge <?= $prClass ?>">
                                            <?= $noPrioritas ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS -->
                                <td>
                                    <?php if ($sudah): ?>
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <i class="ti ti-check me-1"></i>Sudah Dievaluasi
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info-subtle text-info border border-info">
                                            <i class="ti ti-clock me-1"></i>Belum Dievaluasi
                                        </span>
                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>
        </div>

    </div><!-- /.card-body -->

    <!-- BOTTOM: per-page + info + pagination -->
    <?php if (!empty($activeKonteks) && !empty($data)): ?>
        <div class="ar-table-bottom">

            <div class="ar-table-info">
                <form method="get" class="ar-perpage-form" id="erPerPageForm">
                    <input type="hidden" name="filter" value="<?= esc($filter ?? '') ?>">
                    <select name="perPage" class="ar-perpage"
                        onchange="document.getElementById('erPerPageForm').submit()">
                        <?php foreach ([5, 10, 25, 50] as $size): ?>
                            <option value="<?= $size ?>"
                                <?= ($perPage ?? 10) == $size ? 'selected' : '' ?>>
                                <?= $size ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <div class="ar-info-text">
                    Menampilkan <?= $from ?? 1 ?>–<?= $to ?? count($data) ?> dari <?= $total ?? count($data) ?> data
                </div>
            </div>

            <?php if (isset($pager) && ($pager['totalPages'] ?? 1) > 1): ?>
                <div class="ar-pagination">
                    <ul class="pagination mb-0">

                        <li class="page-item <?= $pager['currentPage'] <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="erGoToPage(<?= $pager['currentPage'] - 1 ?>); return false;">
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
                                    onclick="erGoToPage(<?= $i ?>); return false;">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php $prev = $i;
                        endforeach; ?>

                        <li class="page-item <?= $cur >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="#"
                                onclick="erGoToPage(<?= $cur + 1 ?>); return false;">
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
    function erGoToPage(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('perPage', <?= $perPage ?? 10 ?>);
        url.searchParams.set('filter', '<?= esc($filter ?? '') ?>');

        const wrapper = document.getElementById('erTableCard');
        const scrollY = window.scrollY;

        fetch(url.toString())
            .then(r => r.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newCard = doc.getElementById('erTableCard');
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