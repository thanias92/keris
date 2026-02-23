<div id="analisisTableWrapper">
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <small class="text-muted">
                    Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('identifikasi') ?> data
                </small>

                <?= $pager->links('identifikasi', 'bootstrap_pagination') ?>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">#</th>
                            <th style="width:80px">Kode</th>
                            <th style="width:200px">Proses</th>
                            <th class="col-risiko">Risiko</th>
                            <th style="width:160px">Kategori</th>
                            <th style="width:220px">Area Dampak</th>
                            <th style="width:120px">Sumber</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($data)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    Belum ada data.
                                </td>
                            </tr>
                        <?php else: ?>

                            <?php $no = 1;
                            foreach ($data as $row): ?>

                                <tr class="cursor-pointer risiko-row"
                                    data-id="<?= $row['id_identifikasi'] ?>">

                                    <td><?= $no++ ?></td>
                                    <td><?= esc($row['kode_proses']) ?></td>

                                    <td class="text-truncate" style="max-width:200px">
                                        <?= esc($row['uraian_proses']) ?>
                                    </td>

                                    <td class="col-risiko">
                                        <div class="risiko-text"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="<?= esc($row['pernyataan_risiko']) ?>">
                                            <?= esc($row['pernyataan_risiko']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['nama_kategori'])): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary">
                                                <?= esc($row['nama_kategori']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($row['area_dampak_list'])): ?>
                                            <?php foreach (explode(', ', $row['area_dampak_list']) as $area): ?>
                                                <span class="badge bg-success-subtle text-success border border-success me-1">
                                                    <?= esc($area) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($row['sumber_risiko'] === 'Internal'): ?>
                                            <span class="badge bg-info-subtle text-info border border-info">
                                                Internal
                                            </span>
                                        <?php elseif ($row['sumber_risiko'] === 'Eksternal'): ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning">
                                                Eksternal
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
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.risiko-row').forEach(row => {

            row.addEventListener('click', function() {

                const id = this.dataset.id;

                loadDetail(id); // PANGGIL FUNCTION YANG SUDAH ADA DI FORM
            });
        });
    });
</script>