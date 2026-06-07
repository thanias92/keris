<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;

class PengelolaRisikoController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('master/pengelola_risiko/index', [
            'title' => 'Pengelola Risiko',
            'hideGlobalContext' => true,
        ]);
    }

    public function table()
    {
        $data = $this->db->table('pengelola_risiko pr')
            ->select('
            pr.id,
            pr.nama,
            pr.nip,
            pr.jabatan,
            pr.wilayah_id,
            pr.is_pemilik,
            pr.aktif,
            w.nama_wilayah
        ')
            ->join('wilayah w', 'w.id = pr.wilayah_id', 'left')
            ->orderBy('pr.nama', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $this->db->table('pengelola_risiko')->insert([
            'nama'        => $this->request->getPost('nama'),
            'nip'         => $this->request->getPost('nip'),
            'jabatan'     => $this->request->getPost('jabatan'),
            'wilayah_id'  => $this->request->getPost('wilayah_id'),
            'is_pemilik'  => $this->request->getPost('is_pemilik') ? true : false,
            'aktif'       => $this->request->getPost('aktif') ? true : false,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function update($id)
    {
        $this->db->table('pengelola_risiko')
            ->where('id', $id)
            ->update([
                'nama'        => $this->request->getPost('nama'),
                'nip'         => $this->request->getPost('nip'),
                'jabatan'     => $this->request->getPost('jabatan'),
                'wilayah_id'  => $this->request->getPost('wilayah_id'),
                'is_pemilik'  => $this->request->getPost('is_pemilik') ? true : false,
                'aktif'       => $this->request->getPost('aktif') ? true : false,
                'updated_at'  => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function delete($id)
    {
        $this->db->table('pengelola_risiko')
            ->where('id', $id)
            ->update([
                'aktif' => false,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function wilayahTable()
    {
        $data = $this->db->table('wilayah')
            ->select('id, nama_wilayah')
            ->orderBy('kode_wilayah', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }
}
