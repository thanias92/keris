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
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $model = new PeraturanTerkaitModel();

        $id = $model->insert([
            'nama_peraturan' => $this->request->getPost('nama_peraturan'),
            'is_default'     => false,
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'id_peraturan'   => $id,
                'nama_peraturan' => $this->request->getPost('nama_peraturan'),
            ]
        ]);
    }
}
