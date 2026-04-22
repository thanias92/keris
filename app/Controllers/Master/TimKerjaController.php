<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TimKerjaController extends BaseController
{
    protected $db;
    protected $table = 'tim_kerja';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/tim_kerja/index', [
            'title' => 'Tim Kerja'
        ]);
    }

    public function table()
    {
        $data = $this->db->table($this->table)
            ->select('id_tim as id, nama_tim')
            ->orderBy('id_tim', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table($this->table)->insert([
            'nama_tim' => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function update($id)
    {
        $this->db->table($this->table)
            ->where('id_tim', $id)
            ->update([
                'nama_tim' => $this->request->getPost('nama'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->db->table($this->table)->delete(['id_tim' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
