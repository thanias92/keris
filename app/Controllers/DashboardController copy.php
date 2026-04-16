<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $totalRisiko = $db->table('identifikasi_risiko')->countAllResults();
        $totalRtp = $db->table('rencana_penanganan_risiko')->countAllResults();

        $rtpSelesai = $db->table('pemantauan_risiko')
            ->where('status', 'selesai')
            ->countAllResults();

        $realisasi = $totalRtp > 0 ? round(($rtpSelesai / $totalRtp) * 100) : 0;

        $risikoTinggi = $db->table('penilaian_risiko pr')
            ->join('matriks_risiko mr', 'mr.id_matriks = pr.id_matriks')
            ->where('mr.level_dampak >=', 4)
            ->countAllResults();

        // ================= HEATMAP GRID =================
        $raw = $db->query("
            SELECT 
                mr.level_kemungkinan,
                mr.level_dampak,
                COUNT(*) as total
            FROM penilaian_risiko pr
            JOIN matriks_risiko mr ON mr.id_matriks = pr.id_matriks
            GROUP BY mr.level_kemungkinan, mr.level_dampak
        ")->getResultArray();

        $grid = [];
        for ($y = 1; $y <= 5; $y++) {
            for ($x = 1; $x <= 5; $x++) {
                $grid[$y][$x] = 0;
            }
        }

        foreach ($raw as $r) {
            $x = (int)$r['level_kemungkinan'];
            $y = (int)$r['level_dampak'];
            $grid[$y][$x] = (int)$r['total'];
        }

        // ================= TREND =================
        $trend = $db->query("
            SELECT EXTRACT(YEAR FROM created_at) AS tahun,COUNT(*) AS total
            FROM identifikasi_risiko
            GROUP BY EXTRACT(YEAR FROM created_at)
            ORDER BY tahun
        ")->getResultArray();

        $trendLabels = array_column($trend, 'tahun');
        $trendValues = array_map('intval', array_column($trend, 'total'));

        // ================= FORM PROGRESS =================
        $progress = $db->query("
            SELECT 
                sk.nama_satuan_kerja,
                COUNT(DISTINCT k.id_konteks) AS f1,
                COUNT(DISTINCT pr.id_penilaian) AS f2,
                COUNT(DISTINCT rp.id_rtp) AS f3
            FROM satuan_kerja sk
            LEFT JOIN konteks k ON k.id_satuan_kerja = sk.id_satuan_kerja
            LEFT JOIN identifikasi_risiko ir ON ir.id_konteks_proses = k.id_konteks
            LEFT JOIN penilaian_risiko pr ON pr.id_identifikasi = ir.id_identifikasi
            LEFT JOIN rencana_penanganan_risiko rp ON rp.id_penilaian_awal = pr.id_penilaian
            GROUP BY sk.nama_satuan_kerja
        ")->getResultArray();

        return view('dashboard/index', [
            'totalRisiko' => $totalRisiko,
            'totalRtp' => $totalRtp,
            'realisasi' => $realisasi,
            'risikoTinggi' => $risikoTinggi,
            'heatmap' => $grid,
            'trendLabels' => $trendLabels,
            'trendValues' => $trendValues,
            'progress' => $progress
        ]);
    }
}
