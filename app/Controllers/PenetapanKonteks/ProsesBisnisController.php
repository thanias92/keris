<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\ProsesBisnisModel;
use App\Models\KonteksProsesBisnisModel;

class ProsesBisnisController extends BaseContextController
{
    protected $model;
    protected $junctionModel;

    public function __construct()
    {
        $this->model         = new ProsesBisnisModel();
        $this->junctionModel = new KonteksProsesBisnisModel();
    }

    private function validateKonteksAccess($idKonteks): bool
    {
        $db = \Config\Database::connect();

        $row = $db->table('konteks')
            ->select('id_tim')
            ->where('id_konteks', $idKonteks)
            ->get()
            ->getRow();

        if (!$row) {
            return false;
        }

        $role = session('role');

        if ($role === 'admin') {
            return true;
        }

        if ($role === 'ketua') {
            return false;
        }

        return (string) session('id_tim')
            === (string) $row->id_tim;
    }

    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();

        // Semua master proses bisnis
        $allProses = $this->model
            ->orderBy('kode_proses', 'ASC')
            ->findAll();

        // Yang sudah dipilih untuk konteks aktif
        $selectedProses = [];
        $selectedProsesData = [];
        if ($activeKonteks) {
            $rows = $this->junctionModel->getByKonteks($activeKonteks['id_konteks']);
            $selectedProses = array_column($rows, 'id_proses');
            $selectedProsesData = $rows;
        }

        return view('penetapan_konteks/index', array_merge(
            $this->contextData(),
            [
                'activeTab'      => 'proses_bisnis',
                'allProses'      => $allProses,
                'selectedProses' => $selectedProses,
                'selectedProsesData' => $selectedProsesData,
            ]
        ));
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $idKonteks = $this->request->getPost('id_konteks');

        if (!$this->validateKonteksAccess($idKonteks)) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Tidak punya akses'
                ]);
        }

        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('konteks_proses_bisnis')->insert([
            'id_konteks'       => $idKonteks,
            'id_proses'        => $this->request->getPost('id_proses'),
            'deskripsi_proses' => $this->request->getPost('deskripsi_proses'),
        ]);

        $idKonteksProses = $db->insertID();

        $db->table('sasaran_kinerja')->insert([
            'uraian_sasaran'   => $this->request->getPost('uraian_sasaran'),
            'id_konteks_proses' => $idKonteksProses,
        ]);

        $db->transComplete();

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('konteks_proses_bisnis')
            ->where('id_konteks_proses', $id)
            ->update([
                'id_proses'        => $this->request->getPost('id_proses'),
                'deskripsi_proses' => $this->request->getPost('deskripsi_proses'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);

        $existingSasaran = $db->table('sasaran_kinerja')
            ->where('id_konteks_proses', $id)
            ->get()
            ->getRow();

        if ($existingSasaran) {

            $db->table('sasaran_kinerja')
                ->where('id_konteks_proses', $id)
                ->update([
                    'uraian_sasaran' => $this->request->getPost('uraian_sasaran'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);
        } else {

            $db->table('sasaran_kinerja')->insert([
                'uraian_sasaran'   => $this->request->getPost('uraian_sasaran'),
                'id_konteks_proses' => $id,
            ]);
        }

        $db->transComplete();

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function detail($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data = $this->junctionModel
            ->select('
            konteks_proses_bisnis.*,
            proses_bisnis.kode_proses,
            proses_bisnis.jenis_proses,
            proses_bisnis.uraian_proses,
            sasaran_kinerja.uraian_sasaran
        ')
            ->join(
                'proses_bisnis',
                'proses_bisnis.id_proses = konteks_proses_bisnis.id_proses'
            )
            ->join(
                'sasaran_kinerja',
                'sasaran_kinerja.id_konteks_proses = konteks_proses_bisnis.id_konteks_proses',
                'left'
            )
            ->where('konteks_proses_bisnis.id_konteks_proses', $id)
            ->first();

        if (!$data) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan',
                ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $db = \Config\Database::connect();

        $db->transStart();

        $db->table('sasaran_kinerja')
            ->where('id_konteks_proses', $id)
            ->delete();

        $db->table('konteks_proses_bisnis')
            ->where('id_konteks_proses', $id)
            ->delete();

        $db->transComplete();

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function ajaxTable()
    {
        $activeKonteks = $this->getActiveKonteks();
        $selectedProsesData = [];

        if ($activeKonteks) {
            $selectedProsesData = $this->junctionModel
                ->getByKonteks($activeKonteks['id_konteks']);
        }

        return view('penetapan_konteks/tabs/proses_bisnis/_table_section', [
            'data' => $selectedProsesData,
        ]);
    }
}
