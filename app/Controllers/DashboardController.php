<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Total Risiko
        $totalRisiko = $db->table('risiko')->countAllResults();

        // 2. Total RTP
        $totalRtp = $db->table('rencana_penanganan')->countAllResults();

        // 3. Realisasi RTP (contoh sederhana)
        $selesai = $db->table('pemantauan')
            ->where('status', 'selesai')
            ->countAllResults();

        $realisasi = $totalRtp > 0 ? round(($selesai / $totalRtp) * 100) : 0;

        // 4. Risiko tinggi
        $risikoTinggi = $db->table('risiko')
            ->where('level', 'tinggi')
            ->countAllResults();

        return view('dashboard/index', [
            'totalRisiko' => $totalRisiko,
            'totalRtp' => $totalRtp,
            'realisasi' => $realisasi,
            'risikoTinggi' => $risikoTinggi
        ]);
    }
}
