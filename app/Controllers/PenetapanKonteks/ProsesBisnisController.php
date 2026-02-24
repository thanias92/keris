<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\ProsesBisnisModel;

class ProsesBisnisController extends BaseContextController
{
    public function index()
    {
        $model = new ProsesBisnisModel();

        $activeKonteks = $this->getActiveKonteks();
        $listKonteks   = $this->getListKonteks();

        if ($activeKonteks) {
            $model->where('id_konteks', $activeKonteks['id_konteks']);
        }

        $data = $model
            ->orderBy('kode_proses', 'ASC')
            ->paginate(10);

        return view('penetapan_konteks/index', [
            'activeTab'     => 'proses_bisnis',
            'data'          => $data,
            'pager'         => $model->pager,
            'activeKonteks' => $activeKonteks,
            'listKonteks'   => $listKonteks,
        ]);
    }
}
