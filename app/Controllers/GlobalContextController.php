<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TimKerjaModel;
use App\Models\KegiatanModel;

class GlobalContextController extends BaseController
{
    public function set()
    {
        $tahun      = $this->request->getPost('tahun');
        $idTim      = $this->request->getPost('id_tim');
        $idKegiatan = $this->request->getPost('id_kegiatan');

        session()->set([
            'global_tahun'       => $tahun,
            'global_id_tim'      => $idTim,
            'global_id_kegiatan' => $idKegiatan,
        ]);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function getKegiatanByTim()
    {
        $idTim = $this->request->getGet('id_tim');

        $kegiatan = (new KegiatanModel())
            ->where('id_tim', $idTim)
            ->orderBy('nama_kegiatan', 'ASC')
            ->findAll();

        return $this->response->setJSON($kegiatan);
    }

    public function reset()
    {
        session()->remove([
            'global_tahun',
            'global_id_tim',
            'global_id_kegiatan',
        ]);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }
}
