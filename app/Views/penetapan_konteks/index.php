<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pk-page">
    <!-- [ page-header ] start -->
    <div class="page-header pk-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Manajemen Risiko</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Penetapan Konteks
                        </li>
                    </ul>
                    <div class="page-header-title">
                        <h2 class="m-b-10">Penetapan Konteks</h2>
                    </div>
                </div>

                <div class="col-md-6 text-end">
                    <?php
                    $addConfig = [
                        'proses_bisnis' => [
                            'label' => 'Proses Bisnis',
                            'url'   => 'penetapan-konteks/proses-bisnis/create'
                        ],
                        'sasaran_kinerja' => [
                            'label' => 'Sasaran Kinerja',
                            'url'   => 'penetapan-konteks/sasaran-kinerja/create'
                        ],
                        'pemangku' => [
                            'label' => 'Pemangku Kepentingan',
                            'url'   => 'penetapan-konteks/pemangku/create'
                        ],
                        'peraturan' => [
                            'label' => 'Peraturan Terkait',
                            'url'   => 'penetapan-konteks/peraturan/create'
                        ],
                    ];

                    if (isset($addConfig[$activeTab])):
                    ?>
                        <?php if ($activeTab === 'proses_bisnis'): ?>
                            <button class="btn btn-primary"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasProsesBisnis"
                                onclick="resetProsesBisnisForm()">
                                <i class="ti ti-plus"></i> Proses Bisnis
                            </button>
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
                                <i class="ti ti-plus"></i> Pemangku Kepentingan
                            </button>
                        <?php endif; ?>
                        <?php if ($activeTab === 'peraturan'): ?>
                            <button class="btn btn-primary"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasPeraturan"
                                onclick="resetPeraturanForm()">
                                <i class="ti ti-plus"></i> Peraturan Terkait
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- [ page-header ] end -->

    <!-- Tabs -->
    <?= $this->include('penetapan_konteks/_tabs') ?>

    <!-- Content -->
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

<?= $this->endSection() ?>