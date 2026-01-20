<!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?= base_url('dashboard') ?>">
                <!-- ========   Change your logo from here   ============ -->
                <img src="<?= base_url('assets/images/logo-dark.svg') ?>">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <!-- Dashboard -->
                <li class="pc-item">
                    <a href="<?= base_url('dashboard') ?>" class="pc-link">
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

                <!-- Risiko -->
                <li class="pc-item pc-caption">
                    <label>Manajemen Risiko</label>
                </li>

                <!-- Penetapan Konteks -->
                <li class="pc-item">
                    <a href="<?= base_url('penetapan-konteks') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-database"></i></span>
                        <span class="pc-mtext">Penetapan Konteks</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?= base_url('identifikasi-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-alert-triangle"></i></span>
                        <span class="pc-mtext">Identifikasi Risiko</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?= base_url('penetapan-level-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-layers-intersect"></i></span>
                        <span class="pc-mtext">Penetapan Level Risiko</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?= base_url('monitoring-risiko') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-chart-line"></i></span>
                        <span class="pc-mtext">Monitoring Risiko</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="<?= base_url('tindak-lanjut') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-checklist"></i></span>
                        <span class="pc-mtext">Tindak Lanjut</span>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="pc-item pc-caption">
                    <label>Master Data</label>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-database"></i></span>
                        <span class="pc-mtext">Master Data</span>
                        <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item">
                            <a href="<?= base_url('master/tim') ?>" class="pc-link">Tim</a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url('master/user') ?>" class="pc-link">User</a>
                        </li>
                        <li class="pc-item">
                            <a href="<?= base_url('master/level-risiko') ?>" class="pc-link">Level Risiko</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end -->