<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\SasaranKinerjaModel;

class SasaranKinerjaController extends BaseContextController
{
    public function index()
    {
        $model = new SasaranKinerjaModel();

        $activeKonteks = $this->getActiveKonteks();
        $listKonteks   = $this->getListKonteks();

        if ($activeKonteks) {
            $model->join('proses_bisnis', 'proses_bisnis.id_proses = sasaran_kinerja.id_proses')
                ->where('proses_bisnis.id_konteks', $activeKonteks['id_konteks']);
        }

        $data = $model->paginate(10);

        return view('penetapan_konteks/index', [
            'activeTab'     => 'sasaran_kinerja',
            'data'          => $data,
            'pager'         => $model->pager,
            'activeKonteks' => $activeKonteks,
            'listKonteks'   => $listKonteks,
        ]);
    }
}
