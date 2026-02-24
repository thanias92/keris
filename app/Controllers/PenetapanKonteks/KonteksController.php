<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\KonteksModel;

class KonteksController extends BaseContextController
{
    public function index()
    {
        $model = new KonteksModel();

        $data = $model
            ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->orderBy('tahun', 'DESC')
            ->findAll();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'konteks',
                    'data'      => $data
                ]
            )
        );
    }

    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');

        if (!$id) {
            return redirect()->back();
        }

        // Simpan ke session
        session()->set('id_konteks_aktif', $id);

        return redirect()->to(site_url('penetapan-konteks'));
    }
}
