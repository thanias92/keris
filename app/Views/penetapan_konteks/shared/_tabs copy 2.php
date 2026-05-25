<div class="pk-tabs-container">

    <!-- ROW 1 -->
    <div class="pk-tabs-row">
        <a class="pk-tab <?= $activeTab === 'konteks' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/konteks') ?>">
            <span>Konteks</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'proses_bisnis' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/proses-bisnis') ?>">
            <span>Proses Bisnis</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'sasaran_kinerja' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/sasaran-kinerja') ?>">
            <span>Sasaran Kinerja</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'pemangku' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/pemangku') ?>">
            <span>Pemangku Kepentingan</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'peraturan' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/peraturan') ?>">
            <span>Peraturan Terkait</span>
        </a>
    </div>

    <!-- ROW 2 -->
    <div class="pk-tabs-row">
        <a class="pk-tab <?= $activeTab === 'kriteria' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/kriteria') ?>">
            <span>Kriteria</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'matriks' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/matriks') ?>">
            <span>Matriks Risiko</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'selera' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/selera') ?>">
            <span>Selera Risiko</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'sasaran_strategis' ? 'active' : '' ?>" href="<?= site_url('penetapan-konteks/sasaran-strategis') ?>">
            <span>Sasaran Strategis</span>
        </a>
    </div>

</div>