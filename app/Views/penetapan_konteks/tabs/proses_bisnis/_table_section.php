<?php
$role = session('role');
$canManage = in_array($role, ['admin', 'operator']);
?>

<div class="pk-context-panel">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>
                    <th width="5%">#</th>
                    <th width="10%">Kode</th>
                    <th width="12%">Jenis</th>
                    <th width="22%">Proses Bisnis</th>
                    <th width="20%">Deskripsi Proses</th>
                    <th>Sasaran Kinerja</th>
                </tr>

            </thead>

            <tbody>

                <?php if (empty($data)): ?>

                    <tr>
                        <td colspan="6"
                            class="text-center text-muted py-5">

                            Belum ada proses bisnis dipilih.

                        </td>
                    </tr>

                <?php else: ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data as $row): ?>

                        <tr class="pk-table-row"
                            data-pb-edit="<?= $row['id_konteks_proses'] ?>"
                            style="cursor:pointer;">

                            <td><?= $no++ ?></td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= esc($row['kode_proses']) ?>
                                </span>
                            </td>

                            <td>
                                <?= esc($row['jenis_proses']) ?>
                            </td>

                            <td>
                                <?= esc($row['uraian_proses']) ?>
                            </td>

                            <td>
                                <?= esc($row['deskripsi_proses'] ?? '-') ?>
                            </td>

                            <td>
                                <?= esc($row['uraian_sasaran'] ?? '-') ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>