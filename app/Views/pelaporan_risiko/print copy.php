<!DOCTYPE html>
<html>

<head>
    <title>Laporan Risiko</title>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .sub {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>LAPORAN RISIKO</h2>
    <div class="sub">Sistem KERIS RAJA</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Risiko</th>
                <th>RTP</th>
                <th>Output</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($data as $d): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($d['pernyataan_risiko']) ?></td>
                    <td><?= esc($d['uraian_rtp']) ?></td>
                    <td><?= esc($d['realisasi_output']) ?></td>
                    <td class="text-center"><?= esc($d['status']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script>
        window.print();
    </script>

</body>

</html>