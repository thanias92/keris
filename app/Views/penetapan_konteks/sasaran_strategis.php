<div class="row">
    <div class="col-12 mb-3">
        <h5 class="mb-3">Matriks Analisis Risiko</h5>
        <div class="alert alert-info border-0">
            Digunakan sebagai acuan sasaran strategis BPS Provinsi dan akan digunakan
            pada proses manajemen risiko lainnya.
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:140px">Kode</th>
                        <th>Sasaran BPS Provinsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                Data belum tersedia
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td class="fw-semibold"><?= esc($row['kode_sasaran']) ?></td>
                                <td><?= esc($row['uraian_sasaran']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>