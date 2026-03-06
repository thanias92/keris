<?php if ($activeKonteks): ?>
    <?= view('penetapan_konteks/tabs/sasaran_kinerja/_table_section') ?>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="ti ti-alert-circle"></i>
        Silakan tetapkan <strong>Konteks</strong> terlebih dahulu.
    </div>
<?php endif; ?>