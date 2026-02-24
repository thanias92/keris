<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\PeraturanTerkaitModel;

class PeraturanController extends BaseContextController
{
    public function index()
    {
        $model = new PeraturanTerkaitModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'peraturan',
            'data'      => $model->paginate(10),
            'pager'     => $model->pager
        ]);
    }
}
