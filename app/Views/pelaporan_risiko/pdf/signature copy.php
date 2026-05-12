<div class="signature-wrapper">

    <div class="signature-box">

        <div class="signature-date invisible-date">
            Pekanbaru
        </div>

        <div class="signature-role">
            Pengelola Risiko,
        </div>

        <div class="signature-role">
            Ketua Tim <?= esc($timkerja ?? '-') ?>
        </div>

        <div class="signature-space"></div>

        <div class="signature-name">
            <?= esc($nama_ketua ?? '-') ?>
        </div>

        <div class="signature-nip">
            NIP. <?= esc($nip_ketua ?? '-') ?>
        </div>

    </div>

    <div class="signature-box">
        <div class="signature-date">
            Pekanbaru,<?= date('d') ?>
            <?= esc($bulan ?? '-') ?>
            <?= esc($tahun ?? '-') ?>
        </div>

        <div class="signature-role">
            Pemilik Risiko,
        </div>

        <div class="signature-role">
            Kepala BPS Provinsi Riau
        </div>

        <div class="signature-space"></div>

        <div class="signature-name">
            <?= esc($nama_pemilik ?? '-') ?>
        </div>

        <div class="signature-nip">
            NIP. <?= esc($nip_pemilik ?? '-') ?>
        </div>

    </div>

</div>