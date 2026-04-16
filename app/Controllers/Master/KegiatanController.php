<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class KegiatanController extends BaseController
{
    protected $db;
    protected $table = 'kegiatan';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/kegiatan/index', [
            'title' => 'Kegiatan'
        ]);
    }

    public function table()
    {
        $data = $this->db->table($this->table . ' k')
            ->select('k.id_kegiatan as id,k.nama_kegiatan,k.id_satuan_kerja,sk.nama_satuan_kerja')
            ->join('satuan_kerja sk', 'sk.id_satuan_kerja=k.id_satuan_kerja', 'left')
            ->orderBy('k.id_kegiatan', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table($this->table)->insert([
            'id_satuan_kerja' => $this->request->getPost('id_satuan_kerja'),
            'nama_kegiatan' => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function update($id)
    {
        $this->db->table($this->table)
            ->where('id_kegiatan', $id)
            ->update([
                'id_satuan_kerja' => $this->request->getPost('id_satuan_kerja'),
                'nama_kegiatan' => $this->request->getPost('nama'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->db->table($this->table)->delete(['id_kegiatan' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
