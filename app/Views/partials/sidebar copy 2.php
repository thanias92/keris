<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?= base_url('/') ?>" class="b-brand">
                <img src="<?= base_url('assets/images/logo-dark.svg') ?>" class="logo-lg" alt="logo">
            </a>
        </div>

        <div class="navbar-content">
            <ul class="pc-navbar">

                <!-- Dashboard -->
                <li class="pc-item">
                    <a href="<?= base_url('/') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Bank Risiko -->
                <li class="pc-item">
                    <a href="<?= base_url('bank-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-database"></i></span>
                        <span class="pc-mtext">Bank Risiko</span>
                    </a>
                </li>

                <!-- Caption
                <li class="pc-item pc-caption">
                    <label>Proses Risiko</label>
                </li>
                -->

                <!-- Manajemen Risiko (Parent tanpa icon) -->
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link pc-parent">
                        <span class="pc-micon">
                            <i class="ti ti-folders"></i>
                        </span>
                        <span class="pc-mtext">Manajemen Risiko</span>
                        <span class="pc-arrow">
                            <i data-feather="chevron-right"></i>
                        </span>
                    </a>

                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="<?= base_url('penetapan-konteks') ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-settings"></i></span>
                                <span class="pc-mtext">Penetapan Konteks</span>
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="<?= base_url('identifikasi-risiko') ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-alert-circle"></i></span>
                                <span class="pc-mtext">Identifikasi Risiko</span>
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="<?= base_url('analisis-risiko') ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-chart-bar"></i></span>
                                <span class="pc-mtext">Analisis Risiko</span>
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="<?= base_url('evaluasi-risiko') ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-clipboard-check"></i></span>
                                <span class="pc-mtext">Evaluasi Risiko</span>
                            </a>
                        </li>

                        <li class="pc-item">
                            <a href="<?= base_url('rencana-penanganan') ?>" class="pc-link">
                                <span class="pc-micon"><i class="ti ti-list-check"></i></span>
                                <span class="pc-mtext">Penanganan Risiko</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Pemantauan Risiko -->
                <li class="pc-item">
                    <a href="<?= base_url('monitoring-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-eye"></i></span>
                        <span class="pc-mtext">Pemantauan Risiko</span>
                    </a>
                </li>

                <!-- Pelaporan Risiko -->
                <li class="pc-item">
                    <a href="<?= base_url('pelaporan-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-report-analytics"></i></span>
                        <span class="pc-mtext">Pelaporan Risiko</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->