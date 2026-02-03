<div class="row">

    <!-- KRITERIA KEMUNGKINAN -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    Kriteria Kemungkinan
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="15%">Level</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kemungkinan as $row): ?>
                                <tr>
                                    <td class="text-center fw-semibold">
                                        <?= esc($row['level']) ?>
                                    </td>
                                    <td>
                                        <?= esc($row['deskripsi']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($kemungkinan)): ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        Tidak ada data
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- KRITERIA DAMPAK -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0 fw-semibold">
                    Kriteria Dampak
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="15%">Level</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dampak as $row): ?>
                                <tr>
                                    <td class="text-center fw-semibold">
                                        <?= esc($row['level']) ?>
                                    </td>
                                    <td>
                                        <?= esc($row['deskripsi']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($dampak)): ?>
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        Tidak ada data
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>