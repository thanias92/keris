<div class="rtp-table-wrapper" id="prTableCard">
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

                <?php if (!$activeKonteks): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="ti ti-map-pin fs-3 d-block mb-2 opacity-25"></i>
                            Pilih konteks terlebih dahulu untuk melihat data pemantauan risiko.
                        </td>
                    </tr>

                <?php elseif (empty($data)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="ti ti-inbox fs-3 d-block mb-2 opacity-25"></i>
                            Belum ada data RTP untuk dipantau.
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

                    <?php foreach ($grouped as $item):

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
                                'Dalam Proses' => 'warning',
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