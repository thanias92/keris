<?php

/**
 * $data berisi isi tabel selera_risiko
 * Kolom:
 * - level
 * - nilai_min
 * - nilai_max
 * - nama_level
 * - deskripsi
 * - tindakan
 * - warna
 */
?>

<div class="row">

    <!-- INFO -->
    <div class="col-12 mb-2">
        <h5 class="mb-3">Matriks Analisis Risiko</h5>
        <div class="alert alert-info border-0 py-2">
            Menunjukkan batas tingkat risiko yang <b>dapat diterima</b> dan
            <b>tindakan manajemen risiko</b> yang harus dilakukan.
        </div>
    </div>

    <!-- TABLE -->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">

                <thead class="table-light">
                    <tr>
                        <th width="5%">Level</th>
                        <th width="15%">Nilai Risiko</th>
                        <th width="18%">Selera Risiko</th>
                        <th width="30%">Tindakan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <!-- LEVEL -->
                            <td class="fw-bold">
                                <?= $row['level'] ?>
                            </td>

                            <!-- RENTANG NILAI -->
                            <td>
                                <?= $row['nilai_min'] ?> – <?= $row['nilai_max'] ?>
                            </td>

                            <!-- NAMA + WARNA -->
                            <td>
                                <span class="badge px-3 py-2 <?= warna_selera_risiko_class($row['warna']) ?>">
                                    <?= esc($row['nama_level']) ?>
                                </span>
                            </td>

                            <!-- TINDAKAN -->
                            <td class="text-start">
                                <?= esc($row['tindakan']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>