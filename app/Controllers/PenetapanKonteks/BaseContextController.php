<?php

namespace App\Controllers\PenetapanKonteks;

use App\Controllers\BaseController;
use App\Models\KonteksModel;

class BaseContextController extends BaseController
{
    protected function getActiveKonteks()
    {
        $id = session('id_konteks_aktif');
        if (!$id) return null;

        $model = new KonteksModel();

        $data = $model
            ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->where('konteks.id_konteks', $id)
            ->first();

        if (!$data) {
            session()->remove('id_konteks_aktif');
            return null;
        }

        return $data;
    }

    protected function getListKonteks()
    {
        return (new KonteksModel())
            ->select('
                konteks.id_konteks,
                konteks.tahun,
                konteks.kegiatan,
                konteks.pengelola_risiko,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();
    }

    protected function contextData(): array
    {
        return [
            'activeKonteks' => $this->getActiveKonteks(),
            'listKonteks'   => $this->getListKonteks(),
        ];
    }
}
