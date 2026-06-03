<div class="pk-tabs-container">
    <div class="pk-tabs-row pk-tabs-row-3">
        <a class="pk-tab <?= $activeTab === 'ruang_lingkup' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks') ?>">
            <i class="ti ti-layout-grid-add me-2"></i> <span>Ruang Lingkup</span>
        </a>

        <a class="pk-tab <?= $activeTab === 'konteks' ? 'active' : '' ?>"
            href="<?= $activeKonteks
                        ? site_url('penetapan-konteks/konteks/' . $activeKonteks['id_konteks'])
                        : 'javascript:void(0)' ?>">
            <i class="ti ti-file-text me-2"></i>
            <span>Konteks</span>
        </a>

        <a class="pk-tab <?= in_array($activeTab, ['kriteria', 'matriks', 'selera']) ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/kriteria') ?>">
            <i class="ti ti-scale me-2"></i> <span>Kriteria</span>
        </a>
    </div>
</div>