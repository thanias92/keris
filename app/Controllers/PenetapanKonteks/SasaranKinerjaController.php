<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\SasaranKinerjaModel;
use App\Models\KonteksProsesBisnisModel;

class SasaranKinerjaController extends BaseContextController
{
    protected $model;
    protected $junctionModel;

    public function __construct()
    {
        $this->model = new SasaranKinerjaModel();
        $this->junctionModel = new KonteksProsesBisnisModel();
    }

    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();

        $data = [];
        $listProses = [];

        if ($activeKonteks) {
            $data = $this->model->getByKonteks($activeKonteks['id_konteks']);
            $listProses = $this->junctionModel->getByKonteks($activeKonteks['id_konteks']);
        }

        return view('penetapan_konteks/index', array_merge(
            $this->contextData(),
            [
                'activeTab' => 'sasaran_kinerja',
                'data' => $data,
                'listProses' => $listProses,
            ]
        ));
    }

    public function store()
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->insert([
            'id_konteks_proses' => $this->request->getPost('id_konteks_proses'),
            'uraian_sasaran' => $this->request->getPost('uraian_sasaran'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Sasaran Kinerja berhasil disimpan.',
        ]);
    }

    public function update($id)
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->update($id, [
            'id_konteks_proses' => $this->request->getPost('id_konteks_proses'),
            'uraian_sasaran' => $this->request->getPost('uraian_sasaran'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Sasaran Kinerja berhasil diperbarui.',
        ]);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Sasaran Kinerja berhasil dihapus.',
        ]);
    }

    public function detail($id)
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $db   = \Config\Database::connect();
        $data = $db->table('sasaran_kinerja sk')
            ->select('sk.*, pb.kode_proses, pb.uraian_proses as uraian_proses_bisnis, kpb.id_konteks_proses')
            ->join('konteks_proses_bisnis kpb', 'kpb.id_konteks_proses = sk.id_konteks_proses')
            ->join('proses_bisnis pb', 'pb.id_proses = kpb.id_proses')
            ->where('sk.id_sasaran', $id)
            ->get()
            ->getRowArray();

        if (!$data) return $this->response->setStatusCode(404);

        return $this->response->setJSON($data);
    }

    public function ajaxTable()
    {
        $activeKonteks = $this->getActiveKonteks();
        $data = [];

        if ($activeKonteks) {
            $data = $this->model->getByKonteks($activeKonteks['id_konteks']);
        }

        return view('penetapan_konteks/tabs/sasaran_kinerja/_table_section', [
            'data' => $data,
        ]);
    }
}