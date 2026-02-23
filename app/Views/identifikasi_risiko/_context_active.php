<div class="card mb-3 border-0 shadow-sm bg-light">
    <div class="card-body py-3">
        <div class="row small text-muted">
            <div class="col-md-3 col-6">
                <strong>Satuan Kerja</strong><br>
                <?= esc($activeKonteks['nama_satuan_kerja']) ?>
            </div>
            <div class="col-md-3 col-6">
                <strong>Tahun</strong><br>
                <?= esc($activeKonteks['tahun']) ?>
            </div>
            <div class="col-md-3 col-6">
                <strong>Kegiatan</strong><br>
                <?= esc($activeKonteks['kegiatan']) ?>
            </div>
            <div class="col-md-3 col-6">
                <strong>Sasaran Strategis</strong><br>
                <?= esc($activeKonteks['uraian_sasaran']) ?>
            </div>
        </div>
    </div>
</div>