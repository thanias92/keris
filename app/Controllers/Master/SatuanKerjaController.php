<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SatuanKerjaController extends BaseController
{
    protected $db;
    protected $table = 'satuan_kerja';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/satuan_kerja/index', [
            'title' => 'Satuan Kerja'
        ]);
    }

    public function table()
    {
        $data = $this->db->table($this->table)
            ->select('id_satuan_kerja as id, nama_satuan_kerja')
            ->orderBy('id_satuan_kerja', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table($this->table)->insert([
            'nama_satuan_kerja' => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function update($id)
    {
        $this->db->table($this->table)
            ->where('id', $id)
            ->update([
                'nama_satuan_kerja' => $this->request->getPost('nama'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->db->table($this->table)->delete(['id_satuan_kerja' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
