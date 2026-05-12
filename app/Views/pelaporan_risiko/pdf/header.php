<div class="report-header">

    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <?php
                $logoPath = FCPATH . 'assets/images/logo-bps.png';
                $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                $logoData = file_get_contents($logoPath);

                $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
                ?>

                <img
                    src="<?= $logoBase64 ?>"
                    alt="BPS">

            </td>

            <td class="instansi-cell">

                <div class="bps-title">
                    BADAN PUSAT STATISTIK
                </div>

                <div class="bps-subtitle">
                    PROVINSI RIAU
                </div>

            </td>

            <td class="title-cell">
                LAPORAN PEMANTAUAN RISIKO
            </td>

        </tr>

    </table>

</div>

<div class="header-line"></div>