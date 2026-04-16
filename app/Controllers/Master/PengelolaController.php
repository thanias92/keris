<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class PengelolaController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function table()
    {
        $data = $this->db->table('pengelola_risiko')
            ->select('id,nama')
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }
}
