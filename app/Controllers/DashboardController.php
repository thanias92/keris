<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $tahunList = $db->query("
            SELECT DISTINCT tahun FROM konteks WHERE tahun IS NOT NULL ORDER BY tahun DESC
        ")->getResultArray();

        $timKerjaList = $db->table('tim_kerja')
            ->select('id_tim, nama_tim')
            ->orderBy('nama_tim')
            ->get()->getResultArray();

        $kategoriList = $db->table('kategori_risiko')
            ->select('id_kategori_risiko, nama_kategori')
            ->orderBy('nama_kategori')
            ->get()->getResultArray();

        return view('dashboard/index', [
            'tahunList'       => $tahunList,
            'timKerjaList' => $timKerjaList,
            'kategoriList'    => $kategoriList,
            'hideGlobalContext' => true,
        ]);
    }

    public function data()
    {
        $db     = \Config\Database::connect();
        $tahun  = $this->request->getGet('tahun');
        $timId  = $this->request->getGet('tim');
        $katId  = $this->request->getGet('kategori');

        $baseIr = $db->table('identifikasi_risiko ir')
            ->join('konteks k', 'k.id_konteks = ir.id_konteks_proses', 'left');

        if ($tahun)  $baseIr->where('k.tahun', $tahun);
        if ($timId)   $baseIr->where('k.id_tim', $timId);
        if ($katId)  $baseIr->where('ir.id_kategori_risiko', $katId);

        $totalRisiko = (clone $baseIr)->countAllResults(false);

        $irIds = (clone $baseIr)->select('ir.id_identifikasi')->get()->getResultArray();
        $irIdList = array_column($irIds, 'id_identifikasi');

        $totalRtp = 0;
        $rtpSelesai = 0;
        $risikoTinggi = 0;
        $risikoRendah = 0;

        if (!empty($irIdList)) {
            $totalRtp = $db->table('penilaian_risiko pr')
                ->whereIn('pr.id_identifikasi', $irIdList)
                ->join('rencana_penanganan_risiko rp', 'rp.id_penilaian_awal = pr.id_penilaian', 'left')
                ->where('rp.id_rtp IS NOT NULL')
                ->countAllResults();

            $prIds = $db->table('penilaian_risiko')
                ->select('id_penilaian')
                ->whereIn('id_identifikasi', $irIdList)
                ->get()->getResultArray();
            $prIdList = array_column($prIds, 'id_penilaian');

            if (!empty($prIdList)) {
                $rtpIds = $db->table('rencana_penanganan_risiko')
                    ->select('id_rtp')
                    ->whereIn('id_penilaian_awal', $prIdList)
                    ->get()->getResultArray();
                $rtpIdList = array_column($rtpIds, 'id_rtp');

                if (!empty($rtpIdList)) {
                    $rtpSelesai = $db->table('pemantauan_risiko')
                        ->whereIn('id_rtp', $rtpIdList)
                        ->where('status', 'selesai')
                        ->countAllResults();
                }

                $risikoTinggi = $db->table('penilaian_risiko pr')
                    ->join('matriks_risiko mr', 'mr.id_matriks = pr.id_matriks')
                    ->whereIn('pr.id_penilaian', $prIdList)
                    ->where('mr.level_dampak >=', 4)
                    ->countAllResults();

                $risikoRendah = $db->table('penilaian_risiko pr')
                    ->join('matriks_risiko mr', 'mr.id_matriks = pr.id_matriks')
                    ->whereIn('pr.id_penilaian', $prIdList)
                    ->where('mr.level_dampak <=', 2)
                    ->where('mr.level_kemungkinan <=', 2)
                    ->countAllResults();
            }
        }

        $realisasi = $totalRtp > 0 ? round(($rtpSelesai / $totalRtp) * 100) : 0;

        // HEATMAP
        $hmQuery = $db->table('penilaian_risiko pr')
            ->select('mr.level_kemungkinan, mr.level_dampak, COUNT(*) as total')
            ->join('matriks_risiko mr', 'mr.id_matriks = pr.id_matriks')
            ->join('identifikasi_risiko ir', 'ir.id_identifikasi = pr.id_identifikasi')
            ->join('konteks k', 'k.id_konteks = ir.id_konteks_proses', 'left')
            ->groupBy('mr.level_kemungkinan, mr.level_dampak');

        if ($tahun) $hmQuery->where('k.tahun', $tahun);
        if ($timId)  $hmQuery->where('k.id_tim', $timId);
        if ($katId) $hmQuery->where('ir.id_kategori_risiko', $katId);

        $rawHm = $hmQuery->get()->getResultArray();
        $grid  = [];
        for ($y = 1; $y <= 5; $y++)
            for ($x = 1; $x <= 5; $x++)
                $grid[$y][$x] = 0;
        foreach ($rawHm as $r)
            $grid[(int)$r['level_dampak']][(int)$r['level_kemungkinan']] = (int)$r['total'];

        // TREND
        $trendQuery = $db->table('identifikasi_risiko ir')
            ->select('EXTRACT(YEAR FROM ir.created_at) AS tahun, COUNT(*) AS total')
            ->join('konteks k', 'k.id_konteks = ir.id_konteks_proses', 'left')
            ->groupBy('EXTRACT(YEAR FROM ir.created_at)')
            ->orderBy('tahun');

        if ($tahun) $trendQuery->where('k.tahun', $tahun);
        if ($timId)  $trendQuery->where('k.id_tim', $timId);
        if ($katId) $trendQuery->where('ir.id_kategori_risiko', $katId);

        $trend       = $trendQuery->get()->getResultArray();
        $trendLabels = array_column($trend, 'tahun');
        $trendValues = array_map('intval', array_column($trend, 'total'));

        // KATEGORI
        $katQuery = $db->table('identifikasi_risiko ir')
            ->select('kr.nama_kategori, COUNT(*) as total')
            ->join('kategori_risiko kr', 'kr.id_kategori_risiko = ir.id_kategori_risiko')
            ->join('konteks k', 'k.id_konteks = ir.id_konteks_proses', 'left')
            ->groupBy('kr.nama_kategori')
            ->orderBy('total', 'DESC')
            ->limit(6);

        if ($tahun) $katQuery->where('k.tahun', $tahun);
        if ($timId)  $katQuery->where('k.id_tim', $timId);
        if ($katId) $katQuery->where('ir.id_kategori_risiko', $katId);

        $byKategori    = $katQuery->get()->getResultArray();
        $kategoriLabels = array_column($byKategori, 'nama_kategori');
        $kategoriValues = array_map('intval', array_column($byKategori, 'total'));

        // STATUS RTP
        $statusQuery = "
            SELECT
                SUM(CASE WHEN pm.status = 'selesai' THEN 1 ELSE 0 END) as selesai,
                SUM(CASE WHEN pm.status = 'proses'  THEN 1 ELSE 0 END) as proses,
                SUM(CASE WHEN pm.status IS NULL OR pm.status NOT IN ('selesai','proses') THEN 1 ELSE 0 END) as belum
            FROM rencana_penanganan_risiko rp
            LEFT JOIN pemantauan_risiko pm ON pm.id_rtp = rp.id_rtp
            LEFT JOIN penilaian_risiko pr  ON pr.id_penilaian = rp.id_penilaian_awal
            LEFT JOIN identifikasi_risiko ir ON ir.id_identifikasi = pr.id_identifikasi
            LEFT JOIN konteks k ON k.id_konteks = ir.id_konteks_proses
            WHERE 1=1
        ";
        $statusParams = [];
        if ($tahun) {
            $statusQuery .= " AND k.tahun = ?";
            $statusParams[] = $tahun;
        }
        if ($timId) {
            $statusQuery .= " AND k.id_tim = ?";
            $statusParams[] = $timId;
        }
        if ($katId) {
            $statusQuery .= " AND ir.id_kategori_risiko = ?";
            $statusParams[] = $katId;
        }

        $statusRtp = $db->query($statusQuery, $statusParams)->getRowArray();

        // PROGRESS
        $progressQuery = "
            SELECT
                sk.nama_tim,
                COUNT(DISTINCT k.id_konteks)   AS f1,
                COUNT(DISTINCT pr.id_penilaian) AS f2,
                COUNT(DISTINCT rp.id_rtp)       AS f3
            FROM tim_kerja sk
            LEFT JOIN konteks k ON k.id_tim = sk.id_tim
            LEFT JOIN identifikasi_risiko ir ON ir.id_konteks_proses = k.id_konteks
            LEFT JOIN penilaian_risiko pr ON pr.id_identifikasi = ir.id_identifikasi
            LEFT JOIN rencana_penanganan_risiko rp ON rp.id_penilaian_awal = pr.id_penilaian
            WHERE 1=1
        ";
        $progressParams = [];
        if ($tahun) {
            $progressQuery .= " AND k.tahun = ?";
            $progressParams[] = $tahun;
        }
        if ($timId) {
            $progressQuery .= " AND k.id_tim = ?";
            $progressParams[] = $timId;
        }
        if ($katId) {
            $progressQuery .= " AND ir.id_kategori_risiko = ?";
            $progressParams[] = $katId;
        }
        $progressQuery .= " GROUP BY sk.nama_tim ORDER BY (COUNT(DISTINCT k.id_konteks) + COUNT(DISTINCT pr.id_penilaian) + COUNT(DISTINCT rp.id_rtp)) DESC LIMIT 8";

        $progress = $db->query($progressQuery, $progressParams)->getResultArray();

        // RISIKO TERBARU
        $terbaruQuery = $db->table('identifikasi_risiko ir')
            ->select('ir.pernyataan_risiko, kr.nama_kategori, ir.created_at')
            ->join('kategori_risiko kr', 'kr.id_kategori_risiko = ir.id_kategori_risiko', 'left')
            ->join('konteks k', 'k.id_konteks = ir.id_konteks_proses', 'left')
            ->orderBy('ir.created_at', 'DESC')
            ->limit(5);

        if ($tahun) $terbaruQuery->where('k.tahun', $tahun);
        if ($timId)  $terbaruQuery->where('k.id_tim', $timId);
        if ($katId) $terbaruQuery->where('ir.id_kategori_risiko', $katId);

        $risikoTerbaru = $terbaruQuery->get()->getResultArray();

        return $this->response->setJSON([
            'kpi' => [
                'totalRisiko'  => $totalRisiko,
                'totalRtp'     => $totalRtp,
                'realisasi'    => $realisasi,
                'risikoTinggi' => $risikoTinggi,
                'risikoRendah' => $risikoRendah,
            ],
            'heatmap'        => $grid,
            'trendLabels'    => $trendLabels,
            'trendValues'    => $trendValues,
            'kategoriLabels' => $kategoriLabels,
            'kategoriValues' => $kategoriValues,
            'statusRtp'      => $statusRtp,
            'progress'       => $progress,
            'risikoTerbaru'  => $risikoTerbaru,
        ]);
    }
}
