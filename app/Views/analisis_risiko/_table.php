<?php helper('text'); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th style="width:80px">Kode</th>
                            <th>Pernyataan Risiko</th>
                            <th class="text-center">P</th>
                            <th class="text-center">D</th>
                            <th class="text-center">Risiko</th>
                            <th class="text-center">Pengendalian</th>
                            <th class="text-center">Efektivitas</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $no = 1; ?>
                        <?php foreach ($risiko as $r): ?>
                            <?php
                            $nilai = (int) ($r['nilai_risiko'] ?? 0);

                            $rowClass = '';
                            if ($nilai >= 20) $rowClass = 'table-danger';
                            elseif ($nilai >= 15) $rowClass = 'table-warning';
                            elseif ($nilai >= 6)  $rowClass = 'table-success';
                            ?>

                            <tr class="<?= $rowClass ?>" data-id="<?= $r['id_identifikasi'] ?>">
                                <!-- NO -->
                                <td><?= $no++ ?></td>

                                <!-- KODE (CLICKABLE → MODAL) -->
                                <td class="fw-bold text-primary text-center">
                                    <a href="javascript:void(0)"
                                        class="open-analisis"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAnalisisRisiko"
                                        data-id="<?= $r['id_identifikasi'] ?>"
                                        data-kode="<?= esc($r['kode_risiko']) ?>"
                                        data-pernyataan="<?= esc($r['pernyataan_risiko']) ?>"
                                        data-p="<?= $r['kemungkinan'] ?>"
                                        data-d="<?= $r['dampak'] ?>"
                                        data-efektivitas="<?= $r['efektivitas_pengendalian'] ?>"
                                        data-pengendalian="<?= esc($r['pengendalian_eksisting']) ?>"
                                        data-catatan="<?= esc($r['catatan_analisis']) ?>">
                                        <?= esc($r['kode_risiko']) ?>
                                    </a>
                                </td>

                                <!-- PERNYATAAN -->
                                <?php
                                $pernyataan = $r['pernyataan_risiko'] ?? '';

                                // decode entity SEKALI (cukup)
                                $pernyataan = html_entity_decode($pernyataan, ENT_QUOTES, 'UTF-8');

                                // batasi kata
                                $pernyataan_pendek = word_limiter($pernyataan, 12);
                                ?>

                                <td title="<?= esc($pernyataan) ?>">
                                    <?= esc($pernyataan_pendek, 'raw') ?>
                                </td>

                                <!-- P -->
                                <td class="text-center col-p">
                                    <?= $r['kemungkinan'] ?? '-' ?>
                                </td>

                                <!-- D -->
                                <td class="text-center col-d">
                                    <?= $r['dampak'] ?? '-' ?>
                                </td>

                                <!-- NILAI RISIKO -->
                                <td class="text-center col-nilai">
                                    <?php
                                    if ($nilai <= 5) $badge = 'bg-primary';
                                    elseif ($nilai <= 10) $badge = 'bg-success';
                                    elseif ($nilai <= 14) $badge = 'bg-warning';
                                    elseif ($nilai <= 19) $badge = 'bg-orange';
                                    else $badge = 'bg-danger';
                                    ?>

                                    <?php if ($nilai === 0): ?>
                                        <span class="badge bg-secondary px-3 py-2">
                                            Belum Dianalisis
                                        </span>
                                    <?php else: ?>
                                        <span class="badge <?= $badge ?> px-3 py-2">
                                            <?= $nilai ?>
                                        </span>
                                    <?php endif ?>
                                </td>

                                <!-- PENGENDALIAN -->
                                <td class="text-center col-pengendalian" style="white-space:pre-line">
                                    <?= esc($r['pengendalian_eksisting'] ?? '-') ?>
                                </td>

                                <!-- EFEKTIVITAS -->
                                <td class="text-center col-efektivitas">
                                    <?= esc($r['efektivitas_pengendalian'] ?? '-') ?>
                                </td>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>