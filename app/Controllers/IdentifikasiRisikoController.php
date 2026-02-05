<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IdentifikasiRisikoModel;

class IdentifikasiRisikoController extends BaseController
{
    public function index()
    {
        $model = new IdentifikasiRisikoModel();

        $data = $model
            ->orderBy('id_identifikasi', 'ASC')
            ->paginate(10, 'identifikasi');

        return view('identifikasi_risiko/index', [
            'data'  => $data,
            'pager' => $model->pager,
        ]);
    }

    // ====== CRUD placeholder ======
    public function store() {}
    public function update($id) {}
    public function delete($id) {}
    public function detail($id) {}
}
