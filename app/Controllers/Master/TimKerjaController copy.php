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
            'title' => 'Tim Kerja',
            'hideGlobalContext' => true,
        ]);
    }

    public function table()
    {
        $data = $this->db->table('tim_kerja tk')
            ->select("
            tk.id_tim as id,
            tk.nama_tim,
            COUNT(k.id_kegiatan) as jumlah_kegiatan
        ")
            ->join('kegiatan k', 'k.id_tim = tk.id_tim', 'left')
            ->groupBy('tk.id_tim, tk.nama_tim')
            ->orderBy('tk.id_tim', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function detail($id)
    {
        $tim = $this->db->table('tim_kerja')
            ->where('id_tim', $id)
            ->get()
            ->getRowArray();

        $kegiatan = $this->db->table('kegiatan')
            ->select('id_kegiatan,nama_kegiatan')
            ->where('id_tim', $id)
            ->orderBy('nama_kegiatan')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'tim' => $tim,
            'kegiatan' => $kegiatan
        ]);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        $this->db->table('tim_kerja')->insert([
            'nama_tim'   => $data['nama'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $idTim = $this->db->insertID();

        foreach ($data['kegiatan'] as $kegiatan) {

            if (trim($kegiatan) === '') {
                continue;
            }

            $this->db->table('kegiatan')->insert([
                'id_tim'         => $idTim,
                'nama_kegiatan'  => $kegiatan,
                'created_at'     => date('Y-m-d H:i:s')
            ]);
        }

        $this->db->transComplete();

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function update($id)
    {
        $data = $this->request->getJSON(true);

        $this->db->transStart();

        // update tim
        $this->db->table('tim_kerja')
            ->where('id_tim', $id)
            ->update([
                'nama_tim'   => $data['nama'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        // hapus seluruh kegiatan lama
        $this->db->table('kegiatan')
            ->where('id_tim', $id)
            ->delete();

        // insert ulang kegiatan terbaru
        foreach ($data['kegiatan'] as $kegiatan) {

            if (trim($kegiatan) === '') {
                continue;
            }

            $this->db->table('kegiatan')->insert([
                'id_tim'        => $id,
                'nama_kegiatan' => $kegiatan,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }

        $this->db->transComplete();

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function delete($id)
    {
        $this->db->table($this->table)->delete(['id_tim' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
