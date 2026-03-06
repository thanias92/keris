<?php if (!empty($data)): ?>
    <?= view('penetapan_konteks/tabs/pemangku/_table_section') ?>
<?php else: ?>
    <div class="alert alert-info">
        Belum ada data Pemangku Kepentingan.
    </div>
<?php endif; ?>