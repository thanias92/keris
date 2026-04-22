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

    // Konteks
    public function storeKonteks()
    {
        $konteksModel = new KonteksModel();

        $data = [
            'id_satuan_kerja'      => $this->request->getPost('id_satuan_kerja'),
            'pengelola_risiko'     => $this->request->getPost('pengelola_risiko'),
            'kegiatan'             => $this->request->getPost('kegiatan'),
            'tahun'                => $this->request->getPost('tahun'),
            'id_sasaran_strategis' => $this->request->getPost('id_sasaran_strategis'),
        ];

        if (
            empty($data['id_satuan_kerja']) ||
            empty($data['pengelola_risiko']) ||
            empty($data['tahun']) ||
            empty($data['id_sasaran_strategis'])
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data konteks belum lengkap');
        }

        $idKonteks = $konteksModel->insert($data);

        // 🔴 INI KUNCI
        session()->set('id_konteks_aktif', $idKonteks);

        return redirect()
            ->to('penetapan-konteks/proses-bisnis')
            ->with('success', 'Konteks berhasil ditetapkan');
    }
    public function setActiveKonteks()
    {
        $idKonteks = $this->request->getPost('id_konteks');
        $redirect  = $this->request->getPost('redirect');

        if (!empty($idKonteks)) {
            session()->set('id_konteks_aktif', $idKonteks);
        } else {
            session()->remove('id_konteks_aktif');
        }

        // Jika ada redirect → kembali ke halaman asal
        if (!empty($redirect)) {
            return redirect()->to($redirect);
        }

        // fallback default
        return redirect()->to('penetapan-konteks/proses-bisnis');
    }

    public function resetActiveKonteks()
    {
        session()->remove('id_konteks_aktif');

        return redirect()->to('penetapan-konteks/proses-bisnis');
    }

    /* TAB PROSES BISNIS */
    //View
    public function prosesBisnis()
    {
        $prosesModel        = new ProsesBisnisModel();
        $konteksModel       = new KonteksModel();
        $satuanKerjaModel   = new SatuanKerjaModel();
        $sasaranModel       = new SasaranStrategisModel();

        /* ======================================================
       1️⃣ KONTEKS AKTIF (SESSION)
    ====================================================== */
        $idKonteksAktif = session('id_konteks_aktif');

        $activeKonteks = null;
        $selectedContext = null;

        if ($idKonteksAktif) {

            $activeKonteks = $konteksModel
                ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
                ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
                ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
                ->where('konteks.id_konteks', $idKonteksAktif)
                ->first();

            if ($activeKonteks) {
                $selectedContext = [
                    'nama_satuan_kerja' => $activeKonteks['nama_satuan_kerja'],
                    'tahun'             => $activeKonteks['tahun'],
                    'uraian_sasaran'    => $activeKonteks['uraian_sasaran'],
                ];
            } else {
                // Jika session ada tapi konteks tidak ditemukan → hapus session
                session()->remove('id_konteks_aktif');
                $idKonteksAktif = null;
            }
        }

        /* ======================================================
       2️⃣ LIST KONTEKS (UNTUK DROPDOWN)
    ====================================================== */
        $listKonteks = $konteksModel
            ->select('
            konteks.id_konteks,
            konteks.tahun,
            satuan_kerja.nama_satuan_kerja,
            sasaran_strategis.uraian_sasaran
        ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();

        /* ======================================================
       3️⃣ DATA PROSES BISNIS
       - Jika ada konteks → filter
       - Jika tidak ada → tampil semua
    ====================================================== */
        $builder = $prosesModel;

        if ($idKonteksAktif) {
            $builder = $builder->where('id_konteks', $idKonteksAktif);
        }

        $data = $builder
            ->orderBy("
            CASE 
                WHEN jenis_proses = 'Teknis' THEN 1
                WHEN jenis_proses = 'Non-Teknis' THEN 2
            END
        ", '', false)
            ->orderBy('kode_proses', 'ASC')
            ->paginate(10, 'proses');

        /* ======================================================
       4️⃣ DATA MASTER UNTUK OFFCANVAS
    ====================================================== */
        $filterOptions = [
            'satuan_kerja' => $satuanKerjaModel
                ->orderBy('nama_satuan_kerja', 'ASC')
                ->findAll(),

            'sasaran_strategis' => $sasaranModel
                ->orderBy('uraian_sasaran', 'ASC')
                ->findAll(),
        ];

        /* ======================================================
       RETURN VIEW
    ====================================================== */
        return view('penetapan_konteks/index', [
            'activeTab'        => 'proses_bisnis',
            'data'             => $data,
            'pager'            => $prosesModel->pager,
            'activeKonteks'    => $activeKonteks,
            'listKonteks'      => $listKonteks,
            'filterOptions'    => $filterOptions,
            'selectedContext'  => $selectedContext,
        ]);
    }
    //Create - Form
    public function createProsesBisnis()
    {
        return view('penetapan_konteks/proses_bisnis_form', [
            'mode' => 'create'
        ]);
    }
    //Store - simpan data
    public function storeProsesBisnis()
    {
        $jenis = $this->request->getPost('jenis_proses'); // S / K
        $uraian = $this->request->getPost('uraian_proses');

        if (!in_array($jenis, ['S', 'K'])) {
            return redirect()->back()->with('error', 'Jenis proses tidak valid');
        }

        $model = new ProsesBisnisModel();

        $idKonteks = $this->request->getPost('id_konteks');

        if (!$idKonteks) {
            return redirect()->back()
                ->with('error', 'Konteks belum dipilih');
        }

        // Generate kode GLOBAL
        $last = $model
            ->select("MAX(CAST(SUBSTRING(kode_proses FROM 2) AS INTEGER)) as max_number")
            ->where('kode_proses LIKE', $jenis . '%')
            ->first();

        $nextNumber = ($last && $last['max_number'])
            ? ((int)$last['max_number']) + 1
            : 1;

        $kode = $jenis . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $model->insert([
            'id_konteks'    => $idKonteks,
            'kode_proses'   => $kode,
            'jenis_proses'  => $jenis === 'S' ? 'Teknis' : 'Non-Teknis',
            'uraian_proses' => $uraian
        ]);

        return redirect()
            ->to('penetapan-konteks/proses-bisnis')
            ->with('success', 'Data Proses Bisnis berhasil disimpan');
    }
    //Edit - Form Edit
    public function editProsesBisnis($id)
    {
        $model = new ProsesBisnisModel();

        return view('penetapan_konteks/proses_bisnis_form', [
            'mode' => 'edit',
            'data' => $model->find($id)
        ]);
    }
    //Update - simpan perubahan
    public function updateProsesBisnis($id)
    {
        $jenis = $this->request->getPost('jenis_proses'); // S / K

        $model = new ProsesBisnisModel();

        $model->update($id, [
            'kode_proses'   => $this->request->getPost('kode_proses'),
            'jenis_proses'  => $jenis === 'S' ? 'Teknis' : 'Non-Teknis',
            'uraian_proses' => $this->request->getPost('uraian_proses'),
        ]);

        return redirect()->to('penetapan-konteks/proses-bisnis')
            ->with('success', 'Proses Bisnis berhasil diperbarui');
    }
    //Delete
    public function deleteProsesBisnis($id)
    {
        (new ProsesBisnisModel())->delete($id);

        return redirect()->to('penetapan-konteks/proses-bisnis')
            ->with('success', 'Proses Bisnis berhasil dihapus');
    }
    //Generate Kode Proses Bisnis
    public function generateKodeProses()
    {
        $jenis = $this->request->getGet('jenis'); // S atau K

        if (!in_array($jenis, ['S', 'K'])) {
            return $this->response->setJSON(['kode' => '']);
        }

        $model = new ProsesBisnisModel();

        // Ambil nomor terbesar GLOBAL untuk jenis tersebut
        $last = $model
            ->select("MAX(CAST(SUBSTRING(kode_proses FROM 2) AS INTEGER)) as max_number")
            ->where('kode_proses LIKE', $jenis . '%')
            ->first();

        $nextNumber = ($last && $last['max_number'])
            ? ((int)$last['max_number']) + 1
            : 1;

        $kode = $jenis . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return $this->response->setJSON([
            'kode' => $kode
        ]);
    }
    //Detail Proses Bisnis
    public function detailProsesBisnis($id)
    {
        $model = new ProsesBisnisModel();

        $data = $model
            ->select('
            proses_bisnis.*,
            konteks.kegiatan,
            konteks.tahun,
            satuan_kerja.nama_satuan_kerja,
            sasaran_strategis.uraian_sasaran
        ')
            ->join('konteks', 'konteks.id_konteks = proses_bisnis.id_konteks')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->where('proses_bisnis.id_proses', $id)
            ->first();

        if (!$data) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->setJSON($data);
    }

    /* TAB SASARAN KINERJA */
    //View
    public function sasaranKinerja()
    {
        $sasaranModel = new SasaranKinerjaModel();
        $prosesModel  = new ProsesBisnisModel();
        $konteksModel = new KonteksModel();

        $idKonteksAktif = session('id_konteks_aktif');

        $activeKonteks = null;
        $selectedContext = null;

        if ($idKonteksAktif) {

            $activeKonteks = $konteksModel
                ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
                ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
                ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
                ->where('konteks.id_konteks', $idKonteksAktif)
                ->first();

            if ($activeKonteks) {
                $selectedContext = [
                    'nama_satuan_kerja' => $activeKonteks['nama_satuan_kerja'],
                    'tahun'             => $activeKonteks['tahun'],
                    'uraian_sasaran'    => $activeKonteks['uraian_sasaran'],
                ];
            } else {
                session()->remove('id_konteks_aktif');
                $idKonteksAktif = null;
            }
        }

        $listKonteks = $konteksModel
            ->select('
            konteks.id_konteks,
            konteks.tahun,
            satuan_kerja.nama_satuan_kerja,
            sasaran_strategis.uraian_sasaran
        ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->orderBy('konteks.created_at', 'DESC')
            ->findAll();

        $builder = $sasaranModel
            ->select('sasaran_kinerja.*, proses_bisnis.kode_proses, proses_bisnis.uraian_proses')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = sasaran_kinerja.id_proses');

        if ($idKonteksAktif) {
            $builder = $builder->where('proses_bisnis.id_konteks', $idKonteksAktif);
        }

        $data = $builder
            ->orderBy('kode_proses', 'ASC')
            ->paginate(10, 'sasaran');

        $listProses = $idKonteksAktif
            ? $prosesModel
            ->where('id_konteks', $idKonteksAktif)
            ->orderBy('kode_proses', 'ASC')
            ->findAll()
            : [];

        return view('penetapan_konteks/index', [
            'activeTab'        => 'sasaran_kinerja',
            'data'             => $data,
            'pager'            => $sasaranModel->pager,
            'activeKonteks'    => $activeKonteks,
            'listKonteks'      => $listKonteks,
            'listProses'       => $listProses,
            'selectedContext'  => $selectedContext, // 🔴 WAJIB
        ]);
    }

    //Create - Form
    public function createSasaranKinerja()
    {
        $prosesModel  = new ProsesBisnisModel();
        $konteksModel = new KonteksModel();

        $idKonteks = $this->request->getGet('id_konteks');

        if (!$idKonteks) {
            return redirect()->back()
                ->with('error', 'Konteks belum dipilih');
        }

        $proses = $prosesModel
            ->where('id_konteks', $idKonteks)
            ->whereNotIn(
                'id_proses',
                function ($builder) {
                    return $builder
                        ->select('id_proses')
                        ->from('sasaran_kinerja');
                }
            )
            ->orderBy('kode_proses', 'ASC')
            ->findAll();

        return view('penetapan_konteks/sasaran_kinerja_form', [
            'mode'        => 'create',
            'prosesList'  => $proses,
            'activeKonteks' => $konteksModel->getById($idKonteks),
        ]);
    }
    //Store - simpan data
    public function storeSasaranKinerja()
    {
        $model = new SasaranKinerjaModel();

        // generate kode aman
        $last = $model
            ->like('kode_sasaran', 'SK', 'after')
            ->orderBy('kode_sasaran', 'DESC')
            ->first();

        $next = $last
            ? ((int) substr($last['kode_sasaran'], 2)) + 1
            : 1;

        $kode = 'SK' . str_pad($next, 2, '0', STR_PAD_LEFT);

        $model->insert([
            'kode_sasaran'   => $kode,
            'id_proses'      => $this->request->getPost('id_proses'),
            'uraian_sasaran' => $this->request->getPost('uraian_sasaran'),
        ]);

        $idKonteks = $this->request->getPost('id_konteks');

        return redirect()
            ->to('penetapan-konteks/sasaran-kinerja?id_konteks=' . $idKonteks)
            ->with('success', 'Sasaran Kinerja berhasil ditambahkan');
    }
    //Edit - Form Edit
    public function editSasaranKinerja($id)
    {
        $model = new SasaranKinerjaModel();

        return view('penetapan_konteks/sasaran_kinerja_form', [
            'mode' => 'edit',
            'data' => $model->find($id)
        ]);
    }
    //Update - Simpan perubahan
    public function updateSasaranKinerja($id)
    {
        $model = new SasaranKinerjaModel();

        $model->update($id, [
            'id_proses'      => $this->request->getPost('id_proses'),
            'uraian_sasaran' => $this->request->getPost('uraian_sasaran'),
        ]);

        return redirect()
            ->to('penetapan-konteks/sasaran-kinerja')
            ->with('success', 'Sasaran Kinerja berhasil diperbarui');
    }
    //Delete
    public function deleteSasaranKinerja($id)
    {
        (new SasaranKinerjaModel())->delete($id);

        return redirect()
            ->to('penetapan-konteks/sasaran-kinerja')
            ->with('success', 'Sasaran Kinerja berhasil dihapus');
    }
    //Generate Kode Sasaran Kinerja
    public function generateKodeSasaran()
    {
        $model = new SasaranKinerjaModel();

        $last = $model
            ->like('kode_sasaran', 'SK', 'after')
            ->orderBy('kode_sasaran', 'DESC')
            ->first();

        $next = $last
            ? ((int) substr($last['kode_sasaran'], 2)) + 1
            : 1;

        return $this->response->setJSON([
            'kode' => 'SK' . str_pad($next, 2, '0', STR_PAD_LEFT)
        ]);
    }
    //Detail Sasaran Kinerja
    public function detailSasaranKinerja($id)
    {
        $model = new SasaranKinerjaModel();
        $data  = $model->find($id);

        if (!$data) {
            return $this->response->setStatusCode(404);
        }

        return $this->response->setJSON($data);
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
