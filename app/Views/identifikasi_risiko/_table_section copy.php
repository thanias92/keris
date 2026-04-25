<?php if (empty($data)): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5 text-muted">
            <i class="ti ti-database fs-1 mb-2 d-block opacity-25"></i>
            <p class="mb-0">
                <?= $activeKonteks
                    ? 'Belum ada identifikasi risiko untuk konteks ini.'
                    : 'Belum ada data identifikasi risiko.' ?>
            </p>
        </div>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">
                    Menampilkan <?= count($data) ?> dari <?= $pager->getTotal('identifikasi') ?> data
                </small>
                <?= $pager->links('identifikasi', 'bootstrap_pagination') ?>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th style="width:90px">Kode</th>
                            <th style="width:200px">Proses Bisnis</th>
                            <th>Pernyataan Risiko</th>
                            <th style="width:150px">Kategori</th>
                            <th style="width:220px">Area Dampak</th>
                            <th style="width:110px">Sumber</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data as $row): ?>
                            <tr class="ir-row" data-id="<?= $row['id_identifikasi'] ?>"
                                style="cursor:pointer;">

                                <td><?= $no++ ?></td>

                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary">
                                        <?= esc($row['kode_proses']) ?>
                                    </span>
                                </td>

                                <td class="text-truncate" style="max-width:200px"
                                    title="<?= esc($row['uraian_proses']) ?>">
                                    <?= esc($row['uraian_proses']) ?>
                                </td>

                                <td>
                                    <div class="text-truncate" style="max-width:280px"
                                        title="<?= esc($row['pernyataan_risiko']) ?>">
                                        <?= esc($row['pernyataan_risiko']) ?>
                                    </div>
                                    <?php if (!empty($row['penyebab_risiko'])): ?>
                                        <div class="text-muted small text-truncate" style="max-width:280px"
                                            title="Penyebab: <?= esc($row['penyebab_risiko']) ?>">
                                            <i class="ti ti-arrow-right me-1"></i><?= esc($row['penyebab_risiko']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['nama_kategori'])): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary">
                                            <?= esc($row['nama_kategori']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($row['area_dampak_list'])): ?>
                                        <?php foreach (explode(', ', $row['area_dampak_list']) as $area): ?>
                                            <span class="badge bg-success-subtle text-success border border-success me-1 mb-1">
                                                <?= esc(trim($area)) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($row['sumber_risiko'] === 'Internal'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info">Internal</span>
                                    <?php elseif ($row['sumber_risiko'] === 'Eksternal'): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning">Eksternal</span>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
<?php endif; ?>