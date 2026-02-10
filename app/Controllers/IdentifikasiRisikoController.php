<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProsesBisnisModel;
use App\Models\KonteksModel;
use App\Models\IdentifikasiRisikoModel;

class IdentifikasiRisikoController extends BaseController
{
    public function index()
    {
        $risikoModel = new IdentifikasiRisikoModel();
        $prosesModel = new ProsesBisnisModel();
        $konteksModel = new KonteksModel();

        $idKonteks = $this->request->getGet('id_konteks');

        $risikoModel
            ->select('identifikasi_risiko.*, proses_bisnis.kode_proses, proses_bisnis.uraian_proses')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses');

        if ($idKonteks) {
            $risikoModel->where('proses_bisnis.id_konteks', $idKonteks);
        }

        $data = $risikoModel
            ->orderBy('kode_proses', 'ASC')
            ->paginate(10, 'identifikasi');

        return view('identifikasi_risiko/index', [
            'data'          => $data,
            'pager'         => $risikoModel->pager,

            // 🔑 konteks
            'konteksList'   => $konteksModel->getAll(),
            'activeKonteks' => $idKonteks
                ? $konteksModel->getById($idKonteks)
                : null,

            // 🔽 dropdown proses bisnis (konteks-aware)
            'listProses' => $idKonteks
                ? $prosesModel->getByKonteks($idKonteks)
                : [],
        ]);
    }
    public function store()
    {
        $idKonteks = $this->request->getPost('id_konteks');
        $idProses  = $this->request->getPost('id_proses');

        if (!$idKonteks || !$idProses) {
            return redirect()->back()
                ->with('error', 'Konteks atau Proses Bisnis belum dipilih');
        }

        $model = new IdentifikasiRisikoModel();

        $model->insert([
            'id_proses'         => $idProses,
            'kode_risiko'       => $this->request->getPost('kode_risiko'),
            'uraian_kegiatan'   => $this->request->getPost('uraian_kegiatan'),
            'pernyataan_risiko' => $this->request->getPost('pernyataan_risiko'),
            'penyebab_risiko'   => $this->request->getPost('penyebab_risiko'),
            'dampak_risiko'     => $this->request->getPost('dampak_risiko'),
        ]);

        return redirect()
            ->to('identifikasi-risiko?id_konteks=' . $idKonteks)
            ->with('success', 'Identifikasi Risiko berhasil ditambahkan');
    }

    public function update($id) {}
    public function delete($id) {}
    public function detail($id) {}
}
