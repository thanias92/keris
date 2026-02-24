<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\PemangkuKepentinganModel;

class PemangkuController extends BaseContextController
{
    public function index()
    {
        $model = new PemangkuKepentinganModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'pemangku',
            'data'      => $model->paginate(10),
            'pager'     => $model->pager
        ]);
    }
}
