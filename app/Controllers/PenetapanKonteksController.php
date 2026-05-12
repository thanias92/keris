<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KonteksModel;
use App\Models\TimKerjaModel;
use App\Models\ProsesBisnisModel;
use App\Models\SasaranKinerjaModel;
use App\Models\PemangkuKepentinganModel;
use App\Models\PeraturanTerkaitModel;
use App\Models\KriteriaKemungkinanModel;
use App\Models\KriteriaDampakModel;
use App\Models\MatriksRisikoModel;
use App\Models\SeleraRisikoModel;
use App\Models\SasaranStrategisModel;

class PenetapanKonteksController extends BaseController
{
    public function index()
    {
        return redirect()->to('/penetapan-konteks/proses-bisnis');
    }

    /* TAB PEMANGKU KEPENTINGAN */
    //View
    public function pemangkuKepentingan()
    {
        $pemangkuModel = new PemangkuKepentinganModel();

        $data = $pemangkuModel
            ->paginate(10);

        return view('penetapan_konteks/index', [
            'activeTab' => 'pemangku',
            'data'      => $data,
            'pager'     => $pemangkuModel->pager,
        ]);
    }
    //Create - Form
    public function createPemangkuKepentingan()
    {
        return view('penetapan_konteks/pemangku_kepentingan_form', [
            'mode' => 'create'
        ]);
    }
    //Store - simpan data
    public function storePemangkuKepentingan()
    {
        $model = new PemangkuKepentinganModel();

        $model->insert([
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'hubungan'      => $this->request->getPost('hubungan'),
        ]);

        return redirect()
            ->to('penetapan-konteks/pemangku')
            ->with('success', 'Pemangku Kepentingan berhasil ditambahkan');
    }
    //Edit - Form Edit
    public function editPemangkuKepentingan($id)
    {
        $model = new PemangkuKepentinganModel();

        return view('penetapan_konteks/pemangku_kepentingan_form', [
            'mode' => 'edit',
            'data' => $model->find($id)
        ]);
    }
    //Update - Simpan perubahan
    public function updatePemangkuKepentingan($id)
    {
        $model = new PemangkuKepentinganModel();

        $model->update($id, [
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'hubungan'      => $this->request->getPost('hubungan'),
        ]);

        return redirect()
            ->to('penetapan-konteks/pemangku')
            ->with('success', 'Pemangku Kepentingan berhasil diperbarui');
    }
    //Delete
    public function deletePemangkuKepentingan($id)
    {
        (new PemangkuKepentinganModel())->delete($id);

        return redirect()
            ->to('penetapan-konteks/pemangku')
            ->with('success', 'Pemangku Kepentingan berhasil dihapus');
    }
    //Detail Pemangku Kepentingan
    public function detailPemangkuKepentingan($id)
    {
        $model = new PemangkuKepentinganModel();
        $data  = $model->find($id);

        if (!$data) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->setJSON($data);
    }

    /* TAB PERATURAN TERKAIT */
    //View
    public function peraturanTerkait()
    {
        $model = new PeraturanTerkaitModel();
        $data = $model
            ->paginate(10);

        return view('penetapan_konteks/index', [
            'activeTab' => 'peraturan',
            'data'      => $data,
            'pager'     => $model->pager,
        ]);
    }
    //Create - Form
    public function createPeraturanTerkait()
    {
        return view('penetapan_konteks/peraturan_form', [
            'mode' => 'create'
        ]);
    }
    //Store - simpan data
    public function storePeraturanTerkait()
    {
        $model = new PeraturanTerkaitModel();

        $model->insert([
            'nama_peraturan' => $this->request->getPost('nama_peraturan'),
            'is_default' => false,
        ]);

        return redirect()
            ->to('penetapan-konteks/peraturan')
            ->with('success', 'Peraturan Terkait berhasil ditambahkan');
    }
    //Edit - Form Edit
    public function editPeraturanTerkait($id)
    {
        $model = new PeraturanTerkaitModel();

        return view('penetapan_konteks/peraturan_form', [
            'mode' => 'edit',
            'data' => $model->find($id)
        ]);
    }
    //Update - Simpan perubahan
    public function updatePeraturanTerkait($id)
    {
        $model = new PeraturanTerkaitModel();
        $data  = $model->find($id);

        $isDefault = $data['is_default'] === true
            || $data['is_default'] === 1
            || $data['is_default'] === 't';

        if ($isDefault) {
            return redirect()->back()
                ->with('error', 'Peraturan default tidak boleh diubah');
        }

        $model->update($id, [
            'nama_peraturan' => $this->request->getPost('nama_peraturan'),
        ]);

        return redirect()
            ->to('penetapan-konteks/peraturan')
            ->with('success', 'Peraturan berhasil diperbarui');
    }
    //Delete
    public function deletePeraturanTerkait($id)
    {
        $model = new PeraturanTerkaitModel();
        $data  = $model->find($id);

        $isDefault = $data['is_default'] === true
            || $data['is_default'] === 1
            || $data['is_default'] === 't';

        if ($isDefault) {
            return redirect()->back()
                ->with('error', 'Peraturan default tidak boleh dihapus');
        }

        $model->delete($id);

        return redirect()
            ->to('penetapan-konteks/peraturan')
            ->with('success', 'Peraturan berhasil dihapus');
    }
    //Detail Peraturan Terkait
    public function detailPeraturanTerkait($id)
    {
        $model = new PeraturanTerkaitModel();
        $data  = $model->find($id);

        if (!$data) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->setJSON($data);
    }

    /* TAB KRITERIA */
    public function kriteria()
    {
        return view('penetapan_konteks/index', [
            'activeTab' => 'kriteria',
            'kemungkinan' => (new KriteriaKemungkinanModel())->orderBy('level')->findAll(),
            'dampak'      => (new KriteriaDampakModel())->orderBy('level')->findAll(),
        ]);
    }

    /* TAB MATRIKS RISIKO */
    public function matriksRisiko()
    {
        helper('kriteria');
        $model = new MatriksRisikoModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'matriks',
            'data'      => $model
                ->orderBy('level_kemungkinan', 'DESC')
                ->orderBy('level_dampak', 'ASC')
                ->findAll(),
        ]);
    }

    /* TAB SELERA RISIKO */
    public function seleraRisiko()
    {
        helper('selera_risiko');

        $model = new SeleraRisikoModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'selera',
            'data'      => $model->orderBy('level', 'ASC')->findAll(),
        ]);
    }

    /* TAB SASARAN STRATEGIS */
    public function sasaranStrategis()
    {
        $model = new SasaranStrategisModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'sasaran_strategis',
            'data'      => $model->orderBy('kode_sasaran', 'ASC')->findAll(),
        ]);
    }
}
