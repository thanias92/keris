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
            'title' => 'Penugasan Tim',
            'hideGlobalContext' => true,
        ]);
    }

    public function table()
    {
        $data = $this->db->table('penugasan_pengelola pp')
            ->select('
            pp.id,
            pp.pengelola_id,
            pp.tim_kerja_id,
            pp.tahun,
            pp.is_ketua_tim,
            pr.nama as nama_pengelola,
            tk.nama_tim
        ')
            ->join('pengelola_risiko pr', 'pr.id = pp.pengelola_id', 'left')
            ->join('tim_kerja tk', 'tk.id_tim = pp.tim_kerja_id', 'left')
            ->orderBy('pp.tahun', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $isKetua = $this->request->getPost('is_ketua_tim');

        if ($isKetua) {

            $sudahAdaKetua = $this->db
                ->table('penugasan_pengelola')
                ->where('tim_kerja_id', $this->request->getPost('tim_kerja_id'))
                ->where('tahun', $this->request->getPost('tahun'))
                ->where('is_ketua_tim', true)
                ->countAllResults();

            if ($sudahAdaKetua > 0) {

                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Tim ini sudah memiliki ketua pada tahun tersebut'
                    ]);
            }
        }

        $this->db->table('penugasan_pengelola')->insert([
            'pengelola_id' => $this->request->getPost('pengelola_id'),
            'tim_kerja_id' => $this->request->getPost('tim_kerja_id'),
            'tahun' => $this->request->getPost('tahun'),
            'is_ketua_tim' => $isKetua ? true : false,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function update($id)
    {
        $isKetua = $this->request->getPost('is_ketua_tim');

        if ($isKetua) {

            $sudahAdaKetua = $this->db
                ->table('penugasan_pengelola')
                ->where('tim_kerja_id', $this->request->getPost('tim_kerja_id'))
                ->where('tahun', $this->request->getPost('tahun'))
                ->where('is_ketua_tim', true)
                ->where('id !=', $id)
                ->countAllResults();

            if ($sudahAdaKetua > 0) {

                return $this->response
                    ->setStatusCode(400)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Tim ini sudah memiliki ketua pada tahun tersebut'
                    ]);
            }
        }

        $this->db->table('penugasan_pengelola')
            ->where('id', $id)
            ->update([
                'pengelola_id' => $this->request->getPost('pengelola_id'),
                'tim_kerja_id' => $this->request->getPost('tim_kerja_id'),
                'tahun' => $this->request->getPost('tahun'),
                'is_ketua_tim' => $isKetua ? true : false,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function delete($id)
    {
        $this->db->table('penugasan_pengelola')->delete(['id' => $id]);
        return $this->response->setJSON(['status' => true]);
    }
}
