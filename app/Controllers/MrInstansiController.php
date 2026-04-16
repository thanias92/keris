<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class MrInstansiController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'MR Instansi (SICAPKIN)'
        ];

        return view('mr_instansi/index', $data);
    }

    public function getData()
    {
        $tahun = $this->request->getGet('tahun');
        $triwulan = $this->request->getGet('triwulan');

        $data = [
            [
                'sumber' => 'Instansi',
                'pernyataan_risiko' => 'Menurunnya kualitas statistik dan insight data',
                'kendala' => 'Waktu pelaksanaan pelatihan bersamaan dengan kegiatan susenas',
                'solusi' => 'Melakukan pengawasan jarak jauh dan evaluasi berkala',
                'rtp' => 'Pelaksanaan rilis data dan monitoring pelatihan'
            ]
        ];

        return $this->response->setJSON($data);
    }

    public function sync()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil disinkronkan dari SICAPKIN'
        ]);
    }
}
