<div class="report-section">
    <table class="report-table">

        <thead>

            <tr>

                <th rowspan="2" width="6%">
                    Prioritas Risiko
                </th>

                <th rowspan="2" width="18%">
                    Pernyataan Risiko
                </th>

                <th rowspan="2" width="25%">
                    Rencana Tindak Penanganan (RTP)
                </th>

                <th colspan="2" width="22%">
                    Target
                </th>

                <th rowspan="2" width="12%">
                    Penanggung Jawab
                </th>

                <th rowspan="2" width="17%">
                    Risiko Residu
                </th>

            </tr>

            <tr>

                <th width="11%">
                    Output
                </th>

                <th width="11%">
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

            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;
            foreach ($data as $row):
            ?>

                <tr>

                    <td class="text-center">
                        (<?= esc($row['prioritas'] ?? '-') ?>)
                    </td>

                    <td>
                        <?= esc($row['pernyataan_risiko'] ?? '-') ?>
                    </td>

                    <td>
                        <?= nl2br(esc($row['uraian_rtp'] ?? '-')) ?>
                    </td>

                    <td>
                        <?= nl2br(esc($row['target_output'] ?? '-')) ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['target_waktu'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        Ketua Tim
                    </td>

                    <td class="text-center">
                        P: <?= esc($row['kemungkinan_residu'] ?? '-') ?><br>
                        D: <?= esc($row['dampak_residu'] ?? '-') ?><br>
                        SR: <?= esc($row['skor_residu'] ?? '-') ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>
</div>