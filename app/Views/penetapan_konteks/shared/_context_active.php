<?php if (!empty($activeKonteks)): ?>

    <div class="card mb-2 border-0 bg-light" style="font-size: 0.78rem;">
        <div class="card-body py-2 px-3">
            <div class="row g-2">
                <div class="col-auto text-muted">Tim Kerja: <strong class="text-dark"><?= esc($activeKonteks['nama_tim']) ?></strong></div>
                <div class="col-auto text-muted">·</div>
                <div class="col-auto text-muted">Pengelola: <strong class="text-dark"><?= esc($activeKonteks['nama_pengelola']) ?></strong></div>
                <div class="col-auto text-muted">·</div>
                <div class="col-auto text-muted">Tahun: <strong class="text-dark"><?= esc($activeKonteks['tahun']) ?></strong></div>
                <div class="col-auto text-muted">·</div>
                <div class="col-auto text-muted">Kegiatan: <strong class="text-dark"><?= esc($activeKonteks['nama_kegiatan']) ?></strong></div>
                <div class="col-auto text-muted">·</div>
                <div class="col-auto text-muted">Sasaran: <strong class="text-dark"><?= esc($activeKonteks['uraian_sasaran']) ?></strong></div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning d-inline-flex align-items-center gap-2 py-2 px-3 mb-2"
        style="font-size: 0.82rem;">
        <i class="ti ti-alert-circle"></i>
        Konteks belum dipilih
    </div>
<?php endif; ?>