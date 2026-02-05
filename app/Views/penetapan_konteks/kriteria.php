<div class="row">

    <!-- =======================
         KRITERIA KEMUNGKINAN
    ======================== -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">Kriteria Kemungkinan</h5>

                <div class="alert alert-info border-0">
                    Digunakan untuk menilai peluang terjadinya risiko berdasarkan
                    <strong>persentase</strong> atau <strong>frekuensi kejadian</strong>.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" width="8%">Level</th>
                                <th rowspan="2" width="25%">Nama Level</th>
                                <th colspan="2" class="text-center">
                                    Kriteria Kemungkinan
                                </th>
                            </tr>
                            <tr>
                                <th width="20%">Persentase</th>
                                <th>Jumlah Frekuensi Kemungkinan Terjadi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kemungkinan as $row): ?>
                                <tr>
                                    <td class="text-center fw-semibold">
                                        <?= $row['level'] ?>
                                    </td>
                                    <td><?= esc($row['nama_level']) ?></td>
                                    <td><?= formatPersentaseKemungkinan($row) ?></td>
                                    <td><?= esc($row['deskripsi_frekuensi']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 p-3 bg-light rounded">
                    <strong>Catatan:</strong>
                    <ol class="mb-0">
                        <li>
                            Persentase digunakan apabila terdapat populasi yang jelas atas kegiatan tersebut.
                        </li>
                        <li>
                            Jumlah digunakan apabila populasi tidak dapat ditemukan.
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <!-- =======================
         KRITERIA DAMPAK
    ======================== -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">Kriteria Dampak</h5>

                <div class="alert alert-info border-0">
                    Digunakan untuk menilai besarnya dampak risiko terhadap
                    pencapaian tujuan organisasi.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">Level</th>
                                <th width="30%">Nama Level</th>
                                <th>Deskripsi Dampak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dampak as $row): ?>
                                <tr>
                                    <td class="text-center fw-semibold">
                                        <?= $row['level'] ?>
                                    </td>
                                    <td><?= esc($row['nama_level']) ?></td>
                                    <td><?= esc($row['deskripsi']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>