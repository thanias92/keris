<div class="row">

    <!-- PENJELASAN -->
    <div class="col-12 mb-2">
        <div class="alert alert-info border-0 py-2">
            <strong>Selera Risiko</strong><br>
            Menunjukkan batas tingkat risiko yang dapat diterima oleh organisasi
            sebagai dasar pengambilan keputusan penanganan risiko.
        </div>
    </div>

    <!-- TABEL -->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center risk-matrix">

                <thead class="table-light">
                    <tr>
                        <th style="width:70px">Level</th>
                        <th style="width:180px">Tingkat Risiko</th>
                        <th style="width:180px">Rentang Nilai</th>
                        <th style="width:200px">Keputusan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr class="<?= warna_risiko_class($row['warna']) ?>">
                            <td class="fw-bold"><?= $row['level_risiko'] ?></td>
                            <td class="fw-bold"><?= $row['nama_risiko'] ?></td>
                            <td><?= $row['nilai_min'] ?> – <?= $row['nilai_max'] ?></td>
                            <td class="fw-semibold"><?= $row['keputusan'] ?></td>
                            <td class="text-start">
                                <?= $row['keterangan'] ?? '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
