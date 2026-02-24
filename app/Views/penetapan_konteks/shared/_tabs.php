<ul class="nav nav-tabs mb-3 pk-tabs">

    <!-- KONTEKS -->
    <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'konteks' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/konteks') ?>">
            Konteks
        </a>
    </li>

    <!-- PROSES BISNIS -->
    <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'proses_bisnis' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/proses-bisnis') ?>">
            Proses Bisnis
        </a>
    </li>

    <!-- SASARAN KINERJA -->
    <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'sasaran_kinerja' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/sasaran-kinerja') ?>">
            Sasaran Kinerja
        </a>
    </li>

    <!-- PEMANGKU -->
    <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'pemangku' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/pemangku') ?>">
            Pemangku Kepentingan
        </a>
    </li>

    <!-- PERATURAN -->
    <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'peraturan' ? 'active' : '' ?>"
            href="<?= site_url('penetapan-konteks/peraturan') ?>">
            Peraturan Terkait
        </a>
    </li>

    <!-- DROPDOWN LAINNYA -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle 
            <?= in_array($activeTab, ['kriteria', 'matriks', 'selera', 'sasaran_strategis']) ? 'active' : '' ?>"
            data-bs-toggle="dropdown"
            href="#">
            Lainnya
        </a>

        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item"
                    href="<?= site_url('penetapan-konteks/kriteria') ?>">
                    Kriteria
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                    href="<?= site_url('penetapan-konteks/matriks') ?>">
                    Matriks Risiko
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                    href="<?= site_url('penetapan-konteks/selera') ?>">
                    Selera Risiko
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                    href="<?= site_url('penetapan-konteks/sasaran-strategis') ?>">
                    Sasaran Strategis
                </a>
            </li>
        </ul>
    </li>

</ul>