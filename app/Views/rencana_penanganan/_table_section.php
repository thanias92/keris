<div class="rtp-table-wrapper" id="rtpTableCard">
    <div class="table-responsive">
        <table class="table rtp-table align-middle mb-0">

            <thead>
                <tr class="rtp-thead-main">
                    <th rowspan="2" class="rtp-th rtp-th-no text-center">#</th>
                    <th rowspan="2" class="rtp-th rtp-th-kode text-center">Kode<br>Proses</th>
                    <th rowspan="2" class="rtp-th rtp-th-risiko">Risiko</th>
                    <th rowspan="2" class="rtp-th rtp-th-rtp">Rencana Tindak Penanganan (RTP)</th>
                    <th colspan="2" class="rtp-th text-center rtp-th-target-group">Target</th>
                    <th rowspan="2" class="rtp-th rtp-th-pj">Penanggung<br>Jawab</th>
                    <th colspan="3" class="rtp-th text-center rtp-th-residu-group">Risiko Residu</th>
                </tr>
                <tr class="rtp-thead-sub">
                    <th class="rtp-th rtp-th-output text-center">Output</th>
                    <th class="rtp-th rtp-th-waktu text-center">Waktu</th>
                    <th class="rtp-th rtp-th-pdr text-center">P</th>
                    <th class="rtp-th rtp-th-pdr text-center">D</th>
                    <th class="rtp-th rtp-th-sr text-center">SR</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($grouped)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="ti ti-inbox fs-3 d-block mb-2 opacity-25"></i>
                            Belum ada data.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($grouped as $item):

                        $rtpList    = $item['rtp_list'] ?? [];
                        $jumlahRtp  = count($rtpList);
                        $noPrioritas = $item['no_prioritas'] ?? null;

                        /* === RISIKO RESIDU — ambil dari rtp_list[0] (BALIK KE LOGIKA BENAR) === */
                        $levelP   = null;
                        $levelD   = null;
                        $skorSR   = null;
                        $namaSelera = null;
                        $warnaSR  = null;

                        if ($jumlahRtp > 0) {
                            $rtp0       = $rtpList[0];
                            $levelP     = $rtp0['level_kemungkinan_residu'] ?? null;
                            $levelD     = $rtp0['level_dampak_residu']      ?? null;
                            $skorSR     = $rtp0['nilai_sr_residu']          ?? null;
                            $namaSelera = $rtp0['nama_selera_residu']        ?? null;
                            $warnaSR    = !empty($rtp0['warna_selera_residu'])
                                ? hex_warna_selera_risiko($rtp0['warna_selera_residu'])
                                : '#6c757d';
                        }

                        /* === BADGE PRIORITAS === */
                        $prClass = match (true) {
                            $noPrioritas === 1 => 'rtp-prioritas-1',
                            $noPrioritas === 2 => 'rtp-prioritas-2',
                            $noPrioritas === 3 => 'rtp-prioritas-3',
                            $noPrioritas === 4 => 'rtp-prioritas-4',
                            $noPrioritas === 5 => 'rtp-prioritas-5',
                            default            => 'rtp-prioritas-n',
                        };

                        $rowspanCount = max($jumlahRtp, 1);
                    ?>

                        <?php if ($jumlahRtp === 0): ?>
                            <!-- ===== BARIS KOSONG (belum ada RTP) ===== -->
                            <tr class="rtp-row-empty"
                                data-rtp=""
                                data-id-evaluasi="<?= esc($item['id_evaluasi']) ?>"
                                title="Klik untuk tambah RTP"
                                style="cursor:pointer">

                                <td class="rtp-td text-center rtp-td-no">
                                    <span class="badge <?= $prClass ?>">
                                        <?= $noPrioritas ?>
                                    </span>
                                </td>

                                <td class="rtp-td text-center rtp-td-kode">
                                    <span class="badge bg-primary-subtle text-primary fw-semibold">
                                        <?= esc($item['kode_proses']) ?>
                                    </span>
                                    <div class="rtp-level-badge mt-1">
                                        <?php if (!empty($item['nama_selera'])): ?>
                                            <?php $warnaAktual = hex_warna_selera_risiko($item['warna_selera'] ?? null); ?>
                                            <span class="badge"
                                                style="background-color:<?= $warnaAktual ?>;color:#fff;font-size:0.68rem">
                                                <?= esc($item['nama_selera']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="rtp-td rtp-td-risiko">
                                    <div class="rtp-truncate fw-semibold">
                                        <?= esc($item['pernyataan_risiko']) ?>
                                    </div>
                                    <div class="rtp-meta text-muted">
                                        → <?= esc($item['uraian_proses']) ?>
                                    </div>
                                </td>

                                <td class="rtp-td text-center text-muted" colspan="3">
                                    <span class="text-muted">—</span>
                                </td>

                                <td class="rtp-td rtp-td-pj text-muted small">
                                    Ketua <?= esc($item['nama_tim'] ?? '-') ?>
                                </td>

                                <td class="rtp-td text-center text-muted">—</td>
                                <td class="rtp-td text-center text-muted">—</td>
                                <td class="rtp-td text-center text-muted">—</td>

                            </tr>

                        <?php else: ?>

                            <?php foreach ($rtpList as $i => $rtp):
                                $isFirst = ($i === 0);

                                /* Format tanggal Waktu */
                                $targetWaktu = $rtp['target_waktu'] ?? null;
                                $bulan = $tahun = null;
                                if ($targetWaktu) {
                                    $ts    = strtotime($targetWaktu);
                                    $bulan = date('M', $ts);   // Jan, Feb, dst
                                    $tahun = date('Y', $ts);
                                }
                            ?>
                                <tr class="rtp-row rtp-row-filled"
                                    data-rtp="<?= esc($rtp['id_rtp']) ?>"
                                    data-id-evaluasi="<?= esc($item['id_evaluasi']) ?>"
                                    title="Klik untuk lihat/edit RTP ini">

                                    <?php if ($isFirst): ?>
                                        <td class="rtp-td text-center rtp-td-no"
                                            rowspan="<?= $rowspanCount ?>">
                                            <span class="badge <?= $prClass ?>">
                                                <?= $noPrioritas ?>
                                            </span>
                                        </td>

                                        <td class="rtp-td text-center rtp-td-kode rtp-td-group"
                                            rowspan="<?= $rowspanCount ?>">
                                            <span class="badge bg-primary-subtle text-primary fw-semibold">
                                                <?= esc($item['kode_proses']) ?>
                                            </span>
                                            <div class="rtp-level-badge mt-1">
                                                <?php if (!empty($item['nama_selera'])): ?>
                                                    <?php $warnaAktual = hex_warna_selera_risiko($item['warna_selera'] ?? null); ?>
                                                    <span class="badge"
                                                        style="background-color:<?= $warnaAktual ?>;color:#fff;font-size:0.68rem">
                                                        <?= esc($item['nama_selera']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="rtp-td rtp-td-risiko rtp-td-group"
                                            rowspan="<?= $rowspanCount ?>">
                                            <div class="rtp-truncate fw-semibold">
                                                <?= esc($item['pernyataan_risiko']) ?>
                                            </div>
                                            <div class="rtp-meta text-muted">
                                                → <?= esc($item['uraian_proses']) ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>

                                    <!-- RTP -->
                                    <td class="rtp-td rtp-td-rtp">
                                        <div class="rtp-truncate">
                                            <?= esc($rtp['uraian_rtp'] ?? '—') ?>
                                        </div>
                                    </td>

                                    <!-- Target Output -->
                                    <td class="rtp-td rtp-td-output">
                                        <div class="rtp-truncate small text-dark">
                                            <?= esc($rtp['target_output'] ?? '—') ?>
                                        </div>
                                    </td>

                                    <!-- Target Waktu -->
                                    <td class="rtp-td rtp-td-waktu text-center">
                                        <?php if ($bulan && $tahun): ?>
                                            <div class="rtp-waktu-bulan text-dark">
                                                <?= $bulan ?>
                                            </div>

                                            <div class="rtp-waktu-tahun text-dark">
                                                <?= $tahun ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <?php if ($isFirst): ?>
                                        <!-- Penanggung Jawab — rowspan -->
                                        <td class="rtp-td rtp-td-pj rtp-td-group small"
                                            rowspan="<?= $rowspanCount ?>">
                                            Ketua <?= esc($item['nama_tim'] ?? '-') ?>
                                        </td>

                                        <!-- P, D, SR — rowspan karena 1 risiko = 1 nilai residu -->
                                        <td class="rtp-td text-center rtp-td-group"
                                            rowspan="<?= $rowspanCount ?>">
                                            <?= $levelP !== null ? esc($levelP) : '<span class="text-muted">—</span>' ?>
                                        </td>

                                        <td class="rtp-td text-center rtp-td-group"
                                            rowspan="<?= $rowspanCount ?>">
                                            <?= $levelD !== null ? esc($levelD) : '<span class="text-muted">—</span>' ?>
                                        </td>

                                        <td class="rtp-td text-center rtp-td-group"
                                            rowspan="<?= $rowspanCount ?>">
                                            <?php if ($skorSR !== null): ?>
                                                <span class="badge fw-bold px-2 py-1"
                                                    style="background-color:<?= esc($warnaSR) ?>;color:#fff;font-size:0.85rem">
                                                    <?= esc($skorSR) ?>
                                                </span>
                                                <?php if ($namaSelera): ?>
                                                    <div class="fw-semibold mt-1"
                                                        style="font-size:0.7rem;color:<?= esc($warnaSR) ?>">
                                                        <?= esc($namaSelera) ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <!-- PAGINATION -->
    <?php if (!empty($total) && $total > 0): ?>
        <div class="rtp-table-footer">
            <div class="rtp-pagination-info">
                Menampilkan <?= $from ?>–<?= $to ?> dari <?= $total ?> risiko
            </div>

            <?php if (!empty($pager) && $pager['totalPages'] > 1): ?>
                <div class="d-flex align-items-center gap-2">
                    <select class="form-select form-select-sm rtp-perpage"
                        onchange="rtpGoToPage(1, this.value)">
                        <?php foreach ([10, 25, 50] as $n): ?>
                            <option value="<?= $n ?>"
                                <?= $perPage == $n ? 'selected' : '' ?>>
                                <?= $n ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= $pager['currentPage'] <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="javascript:void(0)"
                                    onclick="rtpGoToPage(<?= $pager['currentPage'] - 1 ?>)">
                                    ‹
                                </a>
                            </li>

                            <?php for ($p = 1; $p <= $pager['totalPages']; $p++): ?>
                                <li class="page-item <?= $p === $pager['currentPage'] ? 'active' : '' ?>">
                                    <a class="page-link"
                                        href="javascript:void(0)"
                                        onclick="rtpGoToPage(<?= $p ?>)">
                                        <?= $p ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $pager['currentPage'] >= $pager['totalPages'] ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="javascript:void(0)"
                                    onclick="rtpGoToPage(<?= $pager['currentPage'] + 1 ?>)">
                                    ›
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function rtpGoToPage(page, perPage = <?= $perPage ?? 5 ?>) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('perPage', perPage);
        url.searchParams.set('filter', '<?= esc($filter ?? '') ?>');

        const wrapper = document.getElementById('rtpTableCard');
        const scrollY = window.scrollY;

        fetch(url.toString())
            .then(r => r.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newCard = doc.getElementById('rtpTableCard');
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