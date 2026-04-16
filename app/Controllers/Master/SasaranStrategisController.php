<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class SasaranStrategisController extends BaseController
{
    protected $db;
    protected $table = 'sasaran_strategis';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/sasaran_strategis/index', [
            'title' => 'Sasaran Strategis'
        ]);
    }

    public function table()
    {
        $data = $this->db->table($this->table)
            ->select('id_sasaran_strategis as id,kode_sasaran,uraian_sasaran')
            ->orderBy('kode_sasaran', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table($this->table)->insert([
            'kode_sasaran' => $this->request->getPost('kode'),
            'uraian_sasaran' => $this->request->getPost('uraian'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function update($id)
    {
        $this->db->table($this->table)
            ->where('id_sasaran_strategis', $id)
            ->update([
                'kode_sasaran' => $this->request->getPost('kode'),
                'uraian_sasaran' => $this->request->getPost('uraian'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->db->table($this->table)->delete(['id_sasaran_strategis' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
