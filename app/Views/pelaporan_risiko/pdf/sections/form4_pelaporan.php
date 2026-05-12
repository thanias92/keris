<div class="report-section">
    <table class="report-table">

        <thead>

            <tr>

                <th rowspan="2" width="5%">
                    Prioritas Risiko
                </th>

                <th rowspan="2" width="22%">
                    Pernyataan Risiko
                </th>

                <th rowspan="2" width="18%">
                    Rencana Tindak Penanganan (RTP)
                </th>

                <th colspan="2" width="20%">
                    Target
                </th>

                <th colspan="2" width="20%">
                    Realisasi
                </th>

                <th rowspan="2" width="15%">
                    Penanggung Jawab
                </th>

            </tr>

            <tr>

                <th width="10%">
                    Output
                </th>

                <th width="10%">
                    Waktu
                </th>

                <th width="10%">
                    Output
                </th>

                <th width="10%">
                    Waktu
                </th>

            </tr>

            <tr class="number-row">

                <td>(1)</td>
                <td>(2)</td>
                <td>(3)</td>
                <td>(4)</td>
                <td>(5)</td>
                <td>(6)</td>
                <td>(7)</td>
                <td>(8)</td>

            </tr>

        </thead>

        <tbody>

            <?php
            $grouped = [];

            foreach ($data as $row) {
                $grouped[$row['pernyataan_risiko']][] = $row;
            }

            $no = 1;
            ?>

            <?php foreach ($grouped as $risiko => $items): ?>

                <?php $first = true; ?>

                <?php foreach ($items as $item): ?>

                    <tr>

                        <?php if ($first): ?>

                            <td rowspan="<?= count($items) ?>" class="text-center">
                                <?= $no++ ?>
                            </td>

                            <td rowspan="<?= count($items) ?>">
                                <?= esc($risiko) ?>
                            </td>

                        <?php endif; ?>

                        <td>
                            <?= esc($item['uraian_rtp'] ?? '-') ?>
                        </td>

                        <td>
                            <?= esc($item['target_output'] ?? '-') ?>
                        </td>

                        <td class="text-center">
                            <?= esc($item['target_waktu'] ?? '-') ?>
                        </td>

                        <td>
                            <?= esc($item['realisasi_output'] ?? '-') ?>
                        </td>

                        <td class="text-center">
                            <?= esc($item['realisasi_waktu'] ?? '-') ?>
                        </td>

                        <?php if ($first): ?>

                            <td rowspan="<?= count($items) ?>" class="text-center">
                                Ketua Tim
                            </td>

                        <?php endif; ?>

                    </tr>

                    <?php $first = false; ?>

                <?php endforeach; ?>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>