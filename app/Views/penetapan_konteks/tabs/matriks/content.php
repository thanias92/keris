<?php if (!empty($data)): ?>
    <?= view('penetapan_konteks/matriks') ?>
<?php else: ?>
    <div class="alert alert-info">
        Belum ada data Pemangku Kepentingan.
    </div>
<?php endif; ?>