<div class="pk-table-wrapper">

    <!-- ========================= -->
    <!-- TABLE SCROLL WRAPPER -->
    <!-- ========================= -->
    <div class="pk-table-scroll">

        <table class="table table-hover align-middle pk-konteks-table">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th width="90">Tahun</th>
                    <th>Satuan Kerja</th>
                    <th>Pengelola Risiko</th>
                    <th>Sasaran Strategis</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($data)): ?>
                    <?php $no = $from ?? 1; ?>

                    <?php foreach ($data as $row): ?>
                        <tr class="table-row-click"
                            data-row='<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
                            onclick="pkOpenViewMode(this)">

                            <td><?= $no++ ?></td>
                            <td><?= esc($row['tahun']) ?></td>
                            <td><?= esc($row['nama_satuan_kerja'] ?? '-') ?></td>
                            <td><?= esc($row['nama_pengelola'] ?? '-') ?></td>
                            <td class="pk-truncate">
                                <?= esc($row['uraian_sasaran'] ?? '-') ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada data konteks.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

    </div>


    <!-- ========================= -->
    <!-- BOTTOM SECTION -->
    <!-- ========================= -->
    <?php if (!empty($total) && $total > 0): ?>

        <div class="pk-table-bottom">

            <!-- LEFT SIDE -->
            <div class="pk-table-info">

                <?php if (isset($filters)): ?>
                    <form method="get" class="pk-perpage-form d-flex align-items-center gap-2">

                        <?php foreach ($filters as $key => $value): ?>
                            <input type="hidden" name="<?= $key ?>" value="<?= esc($value) ?>">
                        <?php endforeach; ?>

                        <select name="perPage"
                            class="pk-perpage"
                            onchange="this.form.submit()">

                            <?php foreach ([5, 10, 25, 50] as $size): ?>
                                <option value="<?= $size ?>"
                                    <?= ($perPage ?? 5) == $size ? 'selected' : '' ?>>
                                    <?= $size ?>
                                </option>
                            <?php endforeach; ?>

                        </select>

                    </form>
                <?php endif; ?>

                <div class="pk-info-text">
                    Menampilkan <?= $from ?? 0 ?>–<?= $to ?? 0 ?> dari <?= $total ?? 0 ?> data
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <?php if (isset($pager)): ?>
                <div class="pk-pagination">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>