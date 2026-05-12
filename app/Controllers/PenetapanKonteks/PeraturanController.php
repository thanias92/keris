<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\PeraturanTerkaitModel;

class PeraturanController extends BaseContextController
{
    public function index()
    {
        $model = new PeraturanTerkaitModel();

        $data = $model->paginate(10);

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'peraturan',
                    'data'      => $data,
                    'pager'     => $model->pager,
                    'filters'   => [],
                    'hideGlobalContext' => true,
                ]
            )
        );
    }
}
