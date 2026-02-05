<?php

/**
 * $data berisi isi tabel matriks_risiko
 * Kolom:
 * - level_kemungkinan (1–5)
 * - level_dampak (1–5)
 * - nilai_risiko
 * - warna
 */

// susun data jadi grid [kemungkinan][dampak]
$matrix = [];
foreach ($data as $row) {
    $matrix[$row['level_kemungkinan']][$row['level_dampak']] = $row;
}

// label dampak
$labelDampak = [
    1 => 'Tidak Signifikan',
    2 => 'Minor',
    3 => 'Moderat',
    4 => 'Signifikan',
    5 => 'Sangat Signifikan',
];

// label kemungkinan
$labelKemungkinan = [
    5 => 'Hampir Pasti Terjadi',
    4 => 'Sering Terjadi',
    3 => 'Kadang Terjadi',
    2 => 'Jarang Terjadi',
    1 => 'Hampir Tidak Terjadi',
];
?>

<div class="row">

    <div class="col-12 mb-1">
        <h5 class="mb-3">Matriks Analisis Risiko</h5>
        <div class="alert alert-info border-0">
            Digunakan untuk menentukan <b>nilai dan tingkat risiko</b> berdasarkan
            kombinasi <b>kemungkinan</b> dan <b>dampak</b>.
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle risk-matrix">
                <!-- HEADER DAMPAK -->
                <thead class="table-light">
                    <tr>
                        <th rowspan="2" style="width:220px">Kemungkinan</th>
                        <th colspan="5">Dampak</th>
                    </tr>
                    <tr>
                        <?php foreach ($labelDampak as $label): ?>
                            <th><?= $label ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($labelKemungkinan as $levelK => $namaK): ?>
                        <tr>
                            <th class="text-start bg-light">
                                <?= $namaK ?><br>
                                <small class="text-muted">(Level <?= $levelK ?>)</small>
                            </th>

                            <?php for ($d = 1; $d <= 5; $d++):
                                $cell = $matrix[$levelK][$d] ?? null;
                            ?>
                                <td>
                                    <div class="risk-cell fw-bold <?= warna_risiko_class($cell['warna'] ?? null) ?>">
                                        <?= $cell['nilai_risiko'] ?? '-' ?>
                                    </div>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- LEGEND -->
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2">Keterangan Warna Risiko</h6>
                <ul class="mb-0">
                    <li><span class="badge bg-blue-200 text-blue-900">Biru</span> Risiko Sangat Rendah</li>
                    <li><span class="badge bg-green-200 text-green-900">Hijau</span> Risiko Rendah</li>
                    <li><span class="badge bg-yellow-200 text-yellow-900">Kuning</span> Risiko Sedang</li>
                    <li><span class="badge bg-orange-200 text-orange-900">Oranye</span> Risiko Tinggi</li>
                    <li><span class="badge bg-red-200 text-red-900">Merah</span> Risiko Sangat Tinggi</li>
                </ul>
            </div>
        </div>
    </div>

</div>