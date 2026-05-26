<div class="pk-subtabs-container mb-3">
    <div class="pk-subtabs-row">

        <a class="pk-subtab <?= $activeTab === 'kriteria' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/kriteria') ?>">
            <i class="ti ti-list"></i>
            Level Kriteria
        </a>

        <a class="pk-subtab <?= $activeTab === 'matriks' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/matriks') ?>">
            <i class="ti ti-layout-grid me-1"></i>
            Matriks Analisis Risiko
        </a>

        <a class="pk-subtab <?= $activeTab === 'selera' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/selera') ?>">
            <i class="ti ti-target me-1"></i>
            Selera Risiko
        </a>

    </div>
</div>