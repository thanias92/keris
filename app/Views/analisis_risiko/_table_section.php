<div id="analisisTableWrapper">
    <div class="card border-0 shadow-sm analisis-wrapper">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle analisis-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th style="width:90px">Kode</th>
                            <th class="col-risiko">Risiko</th>

                            <th class="text-center">
                                P<br>
                                <small class="text-muted">Probability</small>
                            </th>

                            <th class="text-center">
                                D<br>
                                <small class="text-muted">Dampak</small>
                            </th>

                            <th style="width:120px" class="text-center">
                                Risiko Aktual
                            </th>

                            <th style="width:140px">Selera</th>
                            <th style="width:220px">Tindakan</th>
                            <th style="width:140px">Efektivitas</th>
                            <th style="width:160px">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    Belum ada data analisis.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php $no = 1;
                            foreach ($data as $row): ?>
                                <?php
                                $sudahAnalisis = !empty($row['id_penilaian']);
                                $levelSelera = $row['nama_selera'] ?? '';

                                $rowClass = '';

                                if ($levelSelera === 'Tinggi') {
                                    $rowClass = 'row-risiko-tinggi';
                                } elseif ($levelSelera === 'Ekstrem') {
                                    $rowClass = 'row-risiko-ekstrem';
                                }
                                ?>

                                <tr class="analisis-row <?= $rowClass ?>"
                                    data-identifikasi="<?= esc($row['id_identifikasi']) ?>"
                                    data-penilaian="<?= esc($row['id_penilaian'] ?? '') ?>"
                                    data-kode="<?= esc($row['kode_risiko']) ?>"
                                    data-risiko="<?= esc($row['pernyataan_risiko']) ?>">

                                    <td><?= $no++ ?></td>

                                    <td><?= esc($row['kode_risiko'] ?? '-') ?></td>

                                    <td class="col-risiko">
                                        <div class="risiko-text"
                                            data-bs-toggle="tooltip"
                                            title="<?= esc($row['pernyataan_risiko']) ?>">
                                            <?= esc($row['pernyataan_risiko']) ?>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <?= esc($row['level_kemungkinan'] ?? '-') ?>
                                    </td>

                                    <td class="text-center">
                                        <?= esc($row['level_dampak'] ?? '-') ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if (!empty($row['nilai_risiko'])): ?>
                                            <span class="badge bg-dark">
                                                <?= esc($row['nilai_risiko']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['nama_selera'])): ?>
                                            <span class="badge bg-secondary">
                                                <?= esc($row['nama_selera']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($row['tindakan'] ?? '-') ?></td>

                                    <td>
                                        <?php if (!empty($row['efektivitas'])): ?>
                                            <span class="badge bg-info">
                                                <?= esc($row['efektivitas']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($sudahAnalisis): ?>
                                            <span class="badge bg-success status-badge">
                                                Sudah Dianalisis
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark status-badge">
                                                Belum Dianalisis
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.analisis-row').forEach(row => {
        row.addEventListener('click', function() {
            const idIdentifikasi = this.dataset.identifikasi;
            const idPenilaian = this.dataset.penilaian;
            const kode = this.dataset.kode;
            const risiko = this.dataset.risiko;

            openAnalisisForm(idIdentifikasi, idPenilaian, kode, risiko);
        });
    });
</script>