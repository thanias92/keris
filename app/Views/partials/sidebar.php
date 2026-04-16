<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header keris-header">
            <a href="<?= base_url('/') ?>" class="b-brand keris-brand">
                <img src="<?= base_url('assets/images/logo-keris-raja.png') ?>" class="keris-logo-full">
                <img src="<?= base_url('assets/images/logo-keris.png') ?>" class="keris-logo-mini">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">

                <li class="pc-item">
                    <a href="<?= base_url('/') ?>" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <?php if (session()->get('user_role')): ?>
                    <li class="pc-item">
                        <a href="<?= base_url('bank-risiko') ?>" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-database"></i></span>
                            <span class="pc-mtext">Bank Risiko</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('user_role')): ?>
                    <li class="pc-item pc-hasmenu">
                        <a href="javascript:void(0)" class="pc-link pc-parent">
                            <span class="pc-micon"><i class="ti ti-folders"></i></span>
                            <span class="pc-mtext">Manajemen Risiko</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>

                        <ul class="pc-submenu">

                            <li class="pc-item">
                                <a href="<?= base_url('mr-instansi') ?>" class="pc-link">
                                    <span class="pc-mtext">MR Instansi (SICAPKIN)</span>
                                </a>
                            </li>

                            <li class="pc-item pc-hasmenu">
                                <a href="javascript:void(0)" class="pc-link pc-parent">
                                    <span class="pc-mtext">MR Kegiatan</span>
                                    <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                                </a>

                                <ul class="pc-submenu">
                                    <li class="pc-item"><a href="<?= base_url('penetapan-konteks') ?>" class="pc-link"><span class="pc-mtext">Penetapan Konteks</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('identifikasi-risiko') ?>" class="pc-link"><span class="pc-mtext">Identifikasi Risiko</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('analisis-risiko') ?>" class="pc-link"><span class="pc-mtext">Analisis Risiko</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('evaluasi-risiko') ?>" class="pc-link"><span class="pc-mtext">Evaluasi Risiko</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('rencana-penanganan') ?>" class="pc-link"><span class="pc-mtext">RTP</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('pemantauan-risiko') ?>" class="pc-link"><span class="pc-mtext">Pemantauan Risiko</span></a></li>
                                    <li class="pc-item"><a href="<?= base_url('pelaporan-risiko') ?>" class="pc-link"><span class="pc-mtext">Pelaporan Risiko</span></a></li>
                                </ul>

                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('user_role') === 'admin'): ?>
                    <li class="pc-item pc-caption"><label>Administrasi</label></li>

                    <li class="pc-item">
                        <a href="<?= base_url('manajemen-user') ?>" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Manajemen User</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="<?= base_url('rbac/role') ?>" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-shield"></i></span>
                            <span class="pc-mtext">Role</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="<?= base_url('rbac/permission') ?>" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-key"></i></span>
                            <span class="pc-mtext">Permission</span>
                        </a>
                    </li>

                    <li class="pc-item pc-hasmenu">
                        <a href="javascript:void(0)" class="pc-link pc-parent">
                            <span class="pc-micon"><i class="ti ti-database"></i></span>
                            <span class="pc-mtext">Master Data</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a href="<?= base_url('master/satuan-kerja') ?>" class="pc-link"><span class="pc-mtext">Tim Kerja</span></a></li>
                            <li class="pc-item"><a href="<?= base_url('master/kegiatan') ?>" class="pc-link"><span class="pc-mtext">Kegiatan</span></a></li>
                            <li class="pc-item"><a href="<?= base_url('master/penugasan-tim') ?>" class="pc-link"><span class="pc-mtext">Penugasan Tim</span></a></li>
                            <li class="pc-item"><a href="<?= base_url('master/sasaran-strategis') ?>" class="pc-link"><span class="pc-mtext">Sasaran Strategis</span></a></li>
                            <li class="pc-item"><a href="<?= base_url('master/bank-risiko') ?>" class="pc-link"><span class="pc-mtext">Bank Risiko</span></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>