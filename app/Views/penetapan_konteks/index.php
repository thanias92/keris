<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">
    <!-- ================= PAGE HEADER ================= -->
    <div class="page-header pk-header">
        <div class="page-block">
            <div class="row">
                <!-- LEFT: breadcrumb + title (SELALU VERTIKAL) -->
                <div class="col-12 col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Manajemen Risiko</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Penetapan Konteks
                            </li>
                        </ol>
                    </nav>
                    <h2 class="page-title mb-0">Penetapan Konteks</h2>
                </div>

                <!-- RIGHT: action button -->
                <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0 pk-header-action">
                    <?php if ($activeTab === 'proses_bisnis'): ?>
                        <!-- + KONTEKS (SELALU AKTIF) -->
                        <button class="btn btn-outline-primary me-2"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasKonteks">
                            <i class="ti ti-plus"></i> Konteks
                        </button>
                        <?php if ($activeKonteks): ?>
                            <!-- + PROSES BISNIS (AKTIF JIKA ADA KONTEKS) -->
                            <button class="btn btn-primary"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasProsesBisnis"
                                data-id-konteks="<?= esc($activeKonteks['id_konteks']) ?>"
                                onclick="resetProsesBisnisForm()">
                                <i class="ti ti-plus"></i> Proses Bisnis
                            </button>
                        <?php else: ?>
                            <!-- + PROSES BISNIS (DISABLED) -->
                            <button class="btn btn-primary disabled"
                                type="button"
                                data-bs-toggle="tooltip"
                                data-bs-placement="left"
                                title="Tetapkan Konteks terlebih dahulu">
                                <i class="ti ti-plus"></i> Proses Bisnis
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($activeTab === 'sasaran_kinerja'): ?>
                        <button class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasSasaranKinerja"
                            onclick="resetSasaranKinerjaForm()">
                            <i class="ti ti-plus"></i> Sasaran Kinerja
                        </button>
                    <?php endif; ?>
                    <?php if ($activeTab === 'pemangku'): ?>
                        <button class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasPemangkuKepentingan"
                            onclick="resetPemangkuKepentinganForm()">
                            <i class="ti ti-plus"></i> Pemangku
                        </button>
                    <?php endif; ?>
                    <?php if ($activeTab === 'peraturan'): ?>
                        <button class="btn btn-primary"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasPeraturan"
                            onclick="resetPeraturanForm()">
                            <i class="ti ti-plus"></i> Peraturan
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= END PAGE HEADER ================= -->

    <!-- ================= TABS ================= -->
    <?= $this->include('penetapan_konteks/_tabs') ?>

    <!-- ================= FILTER ================= -->
    <?php if (in_array($activeTab, ['proses_bisnis', 'sasaran_kinerja'])): ?>
        <?= $this->include('penetapan_konteks/_konteks_filter') ?>
    <?php endif; ?>

    <!-- ================= CONTENT ================= -->
    <div class="card">
        <div class="card-body">

            <?php
            switch ($activeTab) {
                case 'proses_bisnis':
                    echo $this->include('penetapan_konteks/proses_bisnis');
                    break;

                case 'sasaran_kinerja':
                    echo $this->include('penetapan_konteks/sasaran_kinerja');
                    break;

                case 'pemangku':
                    echo $this->include('penetapan_konteks/pemangku');
                    break;

                case 'peraturan':
                    echo $this->include('penetapan_konteks/peraturan');
                    break;

                case 'kriteria':
                    echo $this->include('penetapan_konteks/kriteria');
                    break;

                case 'matriks':
                    echo $this->include('penetapan_konteks/matriks');
                    break;

                case 'selera':
                    echo $this->include('penetapan_konteks/selera');
                    break;

                case 'sasaran_strategis':
                    echo $this->include('penetapan_konteks/sasaran_strategis');
                    break;
            }
            ?>
        </div>
    </div>
</div>
<?= $this->include('penetapan_konteks/konteks_form') ?>

<?= $this->endSection() ?>

<?php if ($activeTab === 'proses_bisnis' && !$activeKonteks): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const offcanvas = new bootstrap.Offcanvas(
                document.getElementById('offcanvasKonteks')
            );
            offcanvas.show();
        });
    </script>
<?php endif; ?>