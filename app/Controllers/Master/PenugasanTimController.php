<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class PenugasanTimController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/penugasan_tim/index', [
            'title' => 'Penugasan Tim'
        ]);
    }

    public function table()
    {
        $data = $this->db->table('penugasan_pengelola pp')
            ->select('
            pp.id,
            pp.pengelola_id,
            pp.satuan_kerja_id,
            pp.tahun,
            pp.is_ketua_tim,
            pr.nama as nama_pengelola,
            sk.nama_satuan_kerja
        ')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id', 'left')
            ->join('satuan_kerja sk', 'sk.id_satuan_kerja = pp.satuan_kerja_id', 'left')
            ->orderBy('pp.tahun', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table('penugasan_pengelola')->insert([
            'pengelola_id' => $this->request->getPost('pengelola_id'),
            'satuan_kerja_id' => $this->request->getPost('satuan_kerja_id'),
            'tahun' => $this->request->getPost('tahun'),
            'is_ketua_tim' => $this->request->getPost('is_ketua_tim') ? true : false,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function update($id)
    {
        $this->db->table('penugasan_pengelola')
            ->where('id', $id)
            ->update([
                'pengelola_id' => $this->request->getPost('pengelola_id'),
                'satuan_kerja_id' => $this->request->getPost('satuan_kerja_id'),
                'tahun' => $this->request->getPost('tahun'),
                'is_ketua_tim' => $this->request->getPost('is_ketua_tim') ? true : false,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON(['status' => true]);
    }

    public function delete($id)
    {
        $this->db->table('penugasan_pengelola')->delete(['id' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
