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
                kegiatan.nama_kegiatan,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran,
                p.nama as nama_pemilik,
                g.nama as nama_pengelola
            ')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
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
            konteks.id_satuan_kerja,
            konteks.pengelola_risiko_id,
            konteks.id_kegiatan,
            konteks.id_sasaran_strategis,
            kegiatan.nama_kegiatan,
            satuan_kerja.nama_satuan_kerja,
            sasaran_strategis.uraian_sasaran,
            p.nama as nama_pemilik,
            g.nama as nama_pengelola
        ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->join('kegiatan', 'kegiatan.id_kegiatan = konteks.id_kegiatan')
            ->join('pengelola_risiko p', 'p.id = konteks.pemilik_risiko_id', 'left')
            ->join('pengelola_risiko g', 'g.id = konteks.pengelola_risiko_id', 'left')
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
