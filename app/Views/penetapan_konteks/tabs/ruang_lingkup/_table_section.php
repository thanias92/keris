<div class="pk-table-wrapper">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 pk-konteks-table">
            <thead class="table-light">
                <tr>
                    <th width="50" class="text-center py-2" style="font-size: 12px;">#</th>
                    <th width="90" class="py-2" style="font-size: 12px;">Tahun</th>
                    <th width="240" class="py-2" style="font-size: 12px;">Tim Kerja</th>
                    <th class="py-2" style="font-size: 12px;">Kegiatan</th>
                    <th width="160" class="py-2" style="font-size: 12px;">Status</th>
                    <th width="40" class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php $no = $from ?? 1; ?>
                    <?php foreach ($data as $row): ?>
                        <?php
                        $status = $row['status'] ?? 'draft_ruang_lingkup';
                        $statusLabel = match ($status) {
                            'draft_ruang_lingkup', 'draft' => 'Draft',
                            'draft_konteks'       => 'Draft Konteks',
                            'lengkap', 'Ada Konteks' => 'Ada Konteks',
                            default               => 'Draft',
                        };
                        $statusClass = match ($status) {
                            'draft_ruang_lingkup', 'draft' => 'pk-badge-draft',
                            'draft_konteks'       => 'pk-badge-draft-konteks',
                            'lengkap', 'Ada Konteks' => 'pk-badge-lengkap',
                            default               => 'pk-badge-draft',
                        };
                        ?>
                        <tr class="table-row-click rl-row" data-id="<?= $row['id_konteks'] ?>">
                            <td class="text-center text-muted py-1.5" style="font-size: 12.5px;"><?= $no++ ?></td>
                            <td class="py-1.5" style="font-size: 12.5px;"><strong><?= esc($row['tahun']) ?></strong></td>
                            <td class="py-1.5">
                                <div class="text-truncate" style="max-width: 230px; font-size: 12.5px;" title="<?= esc($row['nama_tim'] ?? '-') ?>">
                                    <?= esc($row['nama_tim'] ?? '-') ?>
                                </div>
                            </td>
                            <td class="py-1.5">
                                <div class="text-truncate" style="max-width: 360px; font-size: 12.5px;" title="<?= esc($row['nama_kegiatan'] ?? '-') ?>">
                                    <?= esc($row['nama_kegiatan'] ?? '-') ?>
                                </div>
                            </td>
                            <td class="py-1.5">
                                <span class="pk-status-badge <?= $statusClass ?>">
                                    <span class="pk-badge-dot"></span>
                                    <?= esc($statusLabel) ?>
                                </span>
                            </td>
                            <td class="text-end text-muted pe-3 py-1.5">
                                <i class="ti ti-chevron-right fs-5"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5" style="font-size: 13px;">
                            Belum ada data ruang lingkup.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($total) && $total > 0): ?>
        <div class="pk-table-bottom">
            <div class="pk-table-info">
                <?php if (isset($filters)): ?>
                    <form method="get" class="d-flex align-items-center" id="pkPerPageForm">
                        <?php foreach ($filters as $key => $value): ?>
                            <?php if ($key !== 'perPage' && $key !== 'page'): ?>
                                <input type="hidden" name="<?= $key ?>" value="<?= esc($value) ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <select name="perPage" class="pk-perpage-select" onchange="document.getElementById('pkPerPageForm').submit()">
                            <?php foreach ([5, 10, 25, 50] as $size): ?>
                                <option value="<?= $size ?>" <?= ($perPage ?? 5) == $size ? 'selected' : '' ?>><?= $size ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                <?php endif; ?>
                <div class="pk-info-text">
                    Menampilkan <?= $from ?? 0 ?> - <?= $to ?? 0 ?> dari <?= $total ?? 0 ?> data
                </div>
            </div>

            <div class="pk-pagination-wrapper">
                <ul class="pagination mb-0">
                    <?php
                    // Ambil query string saat ini agar filter pencarian/tahun tidak hilang saat klik halaman
                    $queryString = $_GET;
                    $currentPage = isset($queryString['page']) ? (int)$queryString['page'] : 1;
                    $totalPages = ceil($total / ($perPage ?? 5));
                    if ($totalPages < 1) $totalPages = 1;

                    // Tombol Prev (Sebelumnya)
                    if ($currentPage <= 1): ?>
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    <?php else:
                        $queryString['page'] = $currentPage - 1; ?>
                        <li class="page-item"><a class="page-link" href="?<?= http_build_query($queryString) ?>">&laquo;</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php
                        if ($i == 1 || $i == $totalPages || abs($i - $currentPage) <= 1):
                            $queryString['page'] = $i;
                            if ($i == $currentPage): ?>
                                <li class="page-item active"><span class="page-link"><?= $i ?></span></li>
                            <?php else: ?>
                                <li class="page-item"><a class="page-link" href="?<?= http_build_query($queryString) ?>"><?= $i ?></a></li>
                            <?php endif; ?>
                        <?php elseif ($i == 2 || $i == $totalPages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($currentPage >= $totalPages): ?>
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    <?php else:
                        $queryString['page'] = $currentPage + 1; ?>
                        <li class="page-item"><a class="page-link" href="?<?= http_build_query($queryString) ?>">&raquo;</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>