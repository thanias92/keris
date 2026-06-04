<div class="report-section">
    <table class="report-table">

        <thead>

            <tr>
                <th colspan="7">Identifikasi Risiko</th>
                <th colspan="4">Analisis Risiko</th>
                <th colspan="2">Evaluasi Risiko</th>
            </tr>

            <tr>
                <th colspan="2">Proses Bisnis</th>
                <th rowspan="2">Pernyataan Risiko</th>
                <th rowspan="2">Penyebab Risiko / Dampak Risiko</th>
                <th rowspan="2">Kategori Risiko</th>
                <th rowspan="2">Sumber Risiko</th>
                <th rowspan="2">Risiko Aktual</th>
                <th colspan="2">Pengendalian Yang Telah Dilaksanakan</th>
                <th rowspan="2">Efek Pengendalian</th>
                <th rowspan="2">Respon Risiko</th>
                <th rowspan="2">Prioritas</th>
            </tr>

            <tr>
                <th>Kode</th>
                <th>Uraian Proses</th>
                <th>Uraian</th>
                <th>Efektivitas</th>
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
                <td>(9)</td>
                <td>(10)</td>
                <td>(11)</td>
                <td>(12)</td>
            </tr>

        </thead>

        <tbody>

            <?php foreach ($data as $row): ?>

                <tr>

                    <td class="text-center">
                        <?= esc($row['kode_proses'] ?? '-') ?>
                    </td>

                    <td>
                        <?= esc($row['uraian_proses'] ?? '-') ?>
                    </td>

                    <td>
                        <?= esc($row['pernyataan_risiko'] ?? '-') ?>
                    </td>

                    <td>
                        <strong>Penyebab:</strong><br>
                        <?= nl2br(esc($row['penyebab_risiko'] ?? '-')) ?>
                        <br><br>
                        <strong>Dampak:</strong><br>
                        <?= nl2br(esc($row['dampak_risiko'] ?? '-')) ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['nama_kategori'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['sumber_risiko'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        P: <?= esc($row['kemungkinan'] ?? '-') ?><br>
                        D: <?= esc($row['dampak'] ?? '-') ?><br>
                        SR: <?= esc($row['nilai_risiko'] ?? '-') ?>
                    </td>

                    <td>
                        <?= nl2br(esc($row['uraian_pengendalian'] ?? '-')) ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['efektivitas'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['efektivitas'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['opsi_tindakan'] ?? '-') ?>
                    </td>

                    <td class="text-center">
                        <?= esc($row['prioritas'] ?? '-') ?>
                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>
</div>