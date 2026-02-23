<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProsesBisnisModel;
use App\Models\KonteksModel;
use App\Models\KategoriRisikoModel;
use App\Models\AreaDampakModel;
use App\Models\IdentifikasiAreaDampakModel;
use App\Models\IdentifikasiRisikoModel;

class IdentifikasiRisikoController extends BaseController
{
    public function index()
    {
        $risikoModel  = new IdentifikasiRisikoModel();
        $prosesModel  = new ProsesBisnisModel();
        $konteksModel = new KonteksModel();
        $kategoriModel = new KategoriRisikoModel();
        $areaModel    = new AreaDampakModel();

        /* ======================================================
       1️⃣ AMBIL ID KONTEKS DARI QUERY STRING
    ====================================================== */
        $idKonteks = $this->request->getGet('id_konteks');

        $activeKonteks   = null;
        $selectedContext = null;

        if ($idKonteks) {

            $activeKonteks = $konteksModel
                ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
                ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
                ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
                ->where('konteks.id_konteks', $idKonteks)
                ->first();

            if ($activeKonteks) {
                $selectedContext = [
                    'nama_satuan_kerja' => $activeKonteks['nama_satuan_kerja'],
                    'tahun'             => $activeKonteks['tahun'],
                    'uraian_sasaran'    => $activeKonteks['uraian_sasaran'],
                ];
            } else {
                $idKonteks = null;
            }
        }

        /* ======================================================
       2️⃣ LIST KONTEKS UNTUK DROPDOWN
    ====================================================== */
        $konteksList = $konteksModel
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
       3️⃣ QUERY DATA IDENTIFIKASI RISIKO
    ====================================================== */
        $builder = $risikoModel
            ->select('
        identifikasi_risiko.*,
        proses_bisnis.kode_proses,
        proses_bisnis.uraian_proses,
        kategori_risiko.nama_kategori,
        STRING_AGG(area_dampak.nama_area_dampak, \', \') as area_dampak_list
    ')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses')
            ->join('kategori_risiko', 'kategori_risiko.id_kategori_risiko = identifikasi_risiko.id_kategori_risiko', 'left')
            ->join('identifikasi_area_dampak', 'identifikasi_area_dampak.id_identifikasi = identifikasi_risiko.id_identifikasi', 'left')
            ->join('area_dampak', 'area_dampak.id_area_dampak = identifikasi_area_dampak.id_area_dampak', 'left')
            ->groupBy('
        identifikasi_risiko.id_identifikasi,
        proses_bisnis.kode_proses,
        proses_bisnis.uraian_proses,
        kategori_risiko.nama_kategori
    ');

        if ($idKonteks) {
            $builder->where('proses_bisnis.id_konteks', $idKonteks);
        }

        $idKategori = $this->request->getGet('filter_kategori');

        if ($idKategori) {
            $builder->where('identifikasi_risiko.id_kategori_risiko', $idKategori);
        }

        $data = $builder
            ->orderBy('kode_proses', 'ASC')
            ->paginate(10, 'identifikasi');

        $kategoriList = $kategoriModel
            ->orderBy('nama_kategori', 'ASC')
            ->findAll();

        $areaDampakList = $areaModel
            ->orderBy('nama_area_dampak', 'ASC')
            ->findAll();

        /* ======================================================
       4️⃣ LIST PROSES BISNIS (UNTUK FORM DROPDOWN)
    ====================================================== */
        $listProses = $idKonteks
            ? $prosesModel
            ->where('id_konteks', $idKonteks)
            ->orderBy('kode_proses', 'ASC')
            ->findAll()
            : [];

        $filterKategori = $this->request->getGet('filter_kategori');

        /* ======================================================
       RETURN VIEW
    ====================================================== */
        return view('identifikasi_risiko/index', [
            'data'             => $data,
            'pager'            => $risikoModel->pager,
            'konteksList'      => $konteksList,
            'activeKonteks'    => $activeKonteks,
            'selectedContext'  => $selectedContext,
            'listProses'       => $listProses,
            'kategoriList' => $kategoriList,
            'areaDampakList' => $areaDampakList,
            'filterKategori'  => $filterKategori,
        ]);
    }

    public function store()
    {
        $risikoModel = new IdentifikasiRisikoModel();
        $pivotModel  = new IdentifikasiAreaDampakModel();

        $idIdentifikasi = $risikoModel->insert([
            'id_proses'           => $this->request->getPost('id_proses'),
            'kode_risiko'         => $this->request->getPost('kode_risiko'),
            'pernyataan_risiko'   => $this->request->getPost('pernyataan_risiko'),
            'penyebab_risiko'     => $this->request->getPost('penyebab_risiko'),
            'dampak_risiko'       => $this->request->getPost('dampak_risiko'),
            'id_kategori_risiko'  => $this->request->getPost('id_kategori_risiko'),
            'sumber_risiko'       => $this->request->getPost('sumber_risiko'),
        ]);

        $area = $this->request->getPost('area_dampak');

        if (!empty($area)) {
            foreach ($area as $idArea) {
                $pivotModel->insert([
                    'id_identifikasi' => $idIdentifikasi,
                    'id_area_dampak'  => $idArea
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function generateKodeRisiko()
    {
        $model = new IdentifikasiRisikoModel();

        $last = $model
            ->like('kode_risiko', 'R', 'after')
            ->orderBy('kode_risiko', 'DESC')
            ->first();

        $next = $last
            ? ((int) substr($last['kode_risiko'], 1)) + 1
            : 1;

        return $this->response->setJSON([
            'kode' => 'R' . str_pad($next, 3, '0', STR_PAD_LEFT)
        ]);
    }

    public function update($id)
    {
        $risikoModel = new IdentifikasiRisikoModel();
        $pivotModel  = new IdentifikasiAreaDampakModel();

        $risikoModel->update($id, [
            'id_proses'          => $this->request->getPost('id_proses'),
            'pernyataan_risiko'  => $this->request->getPost('pernyataan_risiko'),
            'penyebab_risiko'    => $this->request->getPost('penyebab_risiko'),
            'dampak_risiko'      => $this->request->getPost('dampak_risiko'),
            'id_kategori_risiko' => $this->request->getPost('id_kategori_risiko'),
            'sumber_risiko'      => $this->request->getPost('sumber_risiko'),
        ]);

        $pivotModel->where('id_identifikasi', $id)->delete();

        $area = $this->request->getPost('area_dampak');

        if (!empty($area)) {
            foreach ($area as $idArea) {
                $pivotModel->insert([
                    'id_identifikasi' => $id,
                    'id_area_dampak'  => $idArea
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function delete($id)
    {
        $risikoModel = new IdentifikasiRisikoModel();
        $pivotModel  = new IdentifikasiAreaDampakModel();

        $pivotModel->where('id_identifikasi', $id)->delete();
        $risikoModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

    public function detail($id)
    {
        $model = new IdentifikasiRisikoModel();

        $data = $model
            ->select('
            identifikasi_risiko.*,
            proses_bisnis.kode_proses,
            proses_bisnis.uraian_proses,
            kategori_risiko.nama_kategori
        ')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses')
            ->join('kategori_risiko', 'kategori_risiko.id_kategori_risiko = identifikasi_risiko.id_kategori_risiko', 'left')
            ->where('identifikasi_risiko.id_identifikasi', $id)
            ->first();

        return $this->response->setJSON($data);
    }

    public function detailArea($id)
    {
        $pivot = new IdentifikasiAreaDampakModel();

        $data = $pivot->where('id_identifikasi', $id)
            ->findColumn('id_area_dampak');

        return $this->response->setJSON($data ?? []);
    }
}
