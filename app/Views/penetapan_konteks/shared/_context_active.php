<?php if (!empty($activeKonteks)): ?>

    <div class="card mb-3 border-0 shadow-sm bg-light">
        <div class="card-body py-3">
            <div class="row small">

                <div class="col-md-3">
                    <strong>Satuan Kerja</strong><br>
                    <?= esc($activeKonteks['nama_satuan_kerja']) ?>
                </div>

                <div class="col-md-3">
                    <strong>Pengelola Risiko</strong><br>
                    <?= esc($activeKonteks['pengelola_risiko']) ?>
                </div>

                <div class="col-md-2">
                    <strong>Tahun</strong><br>
                    <?= esc($activeKonteks['tahun']) ?>
                </div>

                <div class="col-md-2">
                    <strong>Kegiatan</strong><br>
                    <?= esc($activeKonteks['kegiatan']) ?>
                </div>

                <div class="col-md-2">
                    <strong>Sasaran Strategis</strong><br>
                    <?= esc($activeKonteks['uraian_sasaran']) ?>
                </div>

            </div>
        </div>
    </div>

<?php else: ?>
    <div class="alert alert-warning d-inline-flex align-items-center gap-2 py-2 px-3 mb-3"
        style="font-size: 0.9rem;">
        <i class="ti ti-alert-circle"></i>
        Konteks belum dipilih
    </div>
<?php endif; ?>