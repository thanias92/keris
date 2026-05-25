<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php if ($activeTab === 'konteks'): ?>
    <script>
        window.KONTEKS_CONFIG = {
            csrf: {
                name: '<?= csrf_token() ?>',
                token: '<?= csrf_hash() ?>',
            },
            url: {
                store: '<?= site_url('penetapan-konteks/konteks/store') ?>',
                update: '<?= site_url('penetapan-konteks/konteks/update') ?>',
                delete: '<?= site_url('penetapan-konteks/konteks/delete') ?>',
                setActive: '<?= site_url('penetapan-konteks/konteks/set-active') ?>',
                resetActive: '<?= site_url('penetapan-konteks/konteks/reset-active') ?>',

                detail: (id) => `<?= site_url('penetapan-konteks/konteks/detail') ?>/${id}`,
                table: '<?= site_url('penetapan-konteks/konteks/table') ?>',

                getPemilik: '<?= site_url('penetapan-konteks/konteks/get-pemilik-provinsi') ?>',
                getPengelola: '<?= site_url('penetapan-konteks/konteks/get-pengelola-list') ?>',
                getKegiatan: (id) => `<?= site_url('penetapan-konteks/konteks/get-kegiatan') ?>/${id}`,
            }
        };
    </script>
<?php endif; ?>

<?php if ($activeTab === 'proses_bisnis'): ?>
    <script>
        window.PROSES_CONFIG = {
            url: {
                sync: '<?= site_url('penetapan-konteks/proses-bisnis/sync') ?>',
                table: '<?= site_url('penetapan-konteks/proses-bisnis/ajax-table') ?>',
            }
        };
    </script>
<?php endif; ?>

<?php if ($activeTab === 'sasaran_kinerja'): ?>
    <script>
        window.SK_CONFIG = {
            url: {
                store: '<?= site_url('penetapan-konteks/sasaran-kinerja/store') ?>',
                update: (id) => `<?= site_url('penetapan-konteks/sasaran-kinerja/update') ?>/${id}`,
                delete: (id) => `<?= site_url('penetapan-konteks/sasaran-kinerja/delete') ?>/${id}`,
                detail: (id) => `<?= site_url('penetapan-konteks/sasaran-kinerja/detail') ?>/${id}`,
                table: '<?= site_url('penetapan-konteks/sasaran-kinerja/table') ?>',
            }
        };
    </script>
<?php endif; ?>

<?php if ($activeTab === 'pemangku'): ?>
    <script>
        window.PEMANGKU_CONFIG = {
            url: {
                store: '<?= site_url('penetapan-konteks/pemangku/store') ?>',
                update: (id) => `<?= site_url('penetapan-konteks/pemangku/update') ?>/${id}`,
                delete: (id) => `<?= site_url('penetapan-konteks/pemangku/delete') ?>/${id}`,
                detail: (id) => `<?= site_url('penetapan-konteks/pemangku/detail') ?>/${id}`,
                table: '<?= site_url('penetapan-konteks/pemangku/table') ?>',
            }
        };
    </script>
<?php endif; ?>

<?php if ($activeTab === 'peraturan'): ?>
    <script>
        window.PERATURAN_CONFIG = {
            url: {
                store: '<?= site_url('penetapan-konteks/peraturan/store') ?>',
                update: (id) => `<?= site_url('penetapan-konteks/peraturan/update') ?>/${id}`,
                delete: (id) => `<?= site_url('penetapan-konteks/peraturan/delete') ?>/${id}`,
                detail: (id) => `<?= site_url('penetapan-konteks/peraturan/detail') ?>/${id}`,
            }
        };
    </script>
<?php endif; ?>

<div class="pk-page">

    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header mb-3">
        <div class="page-block">
            <div class="row align-items-center">

                <!-- LEFT SIDE -->
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="#">Manajemen Risiko</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Penetapan Konteks
                            </li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Penetapan Konteks</h2>
                </div>

                <!-- RIGHT SIDE BUTTON -->
                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">

                    <?php
                    $btn = pk_module_config('penetapan_konteks', $activeTab);
                    $offcanvasId = match ($btn['module'] ?? '') {
                        'pemangku_kepentingan' => 'offcanvasPemangku',
                        'proses_bisnis'        => 'offcanvasProsesBisnis',
                        'sasaran_kinerja'      => 'offcanvasSasaranKinerja',
                        'konteks'              => 'offcanvasKonteks',
                        default                => 'offcanvas' . str_replace('_', '', ucwords($btn['module'] ?? '', '_')),
                    };
                    ?>

                    <?php if ($btn): ?>
                        <button class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#<?= $offcanvasId ?>"
                            <?= $btn['module'] === 'konteks' ? 'onclick="pkOpenCreateMode()"' : '' ?>>
                            <i class="ti ti-plus"></i> <?= esc($btn['label']) ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= END HEADER ================= -->

    <!-- ================= TABS ================= -->
    <?= view('penetapan_konteks/shared/_tabs', ['activeTab' => $activeTab]) ?>

    <!-- ================= CONTEXT SELECTOR ================= -->
    <?php
    $tabsWithContextSelector = ['konteks', 'proses_bisnis', 'sasaran_kinerja', 'peraturan_terkait'];
    ?>

    <?php if (in_array($activeTab, $tabsWithContextSelector)): ?>
        <?= view('penetapan_konteks/shared/_context_selector') ?>
    <?php endif; ?>

    <!-- ================= CONTEXT ACTIVE ================= -->
    <?php if ($activeTab !== 'konteks' && $activeTab !== 'pemangku'): ?>
        <?= view('penetapan_konteks/shared/_context_active') ?>
    <?php endif; ?>

    <!-- ================= TAB CONTENT ================= -->
    <div class="card mt-3">
        <div class="card-body">
            <?= view('penetapan_konteks/tabs/' . $activeTab . '/content') ?>
        </div>
    </div>
</div>

<?php if ($btn): ?>
    <?= view('penetapan_konteks/tabs/' . $btn['module'] . '/_offcanvas_form') ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    window.APP_USER = <?= json_encode(session('user')) ?>;
    window.APP_KONTEKS = <?= json_encode($activeKonteks ?? null) ?>;
</script>

<?php if (in_array($activeTab, $tabsWithContextSelector)): ?>
    <script src="<?= base_url('assets/js/modules/penetapan_konteks/context-selector.js') ?>"></script>
<?php endif; ?>

<script src="<?= base_url('assets/js/modules/penetapan_konteks/' . $activeTab . '.js') ?>"></script>

<?= $this->endSection() ?>