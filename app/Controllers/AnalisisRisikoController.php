<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KonteksModel;
use App\Models\IdentifikasiRisikoModel;
use App\Models\PenilaianRisikoModel;
use App\Models\KriteriaKemungkinanModel;
use App\Models\KriteriaDampakModel;
use App\Models\MatriksRisikoModel;
use App\Models\SeleraRisikoModel;

class AnalisisRisikoController extends BaseController
{
    public function index()
    {
        $konteksModel      = new KonteksModel();
        $identifikasiModel = new IdentifikasiRisikoModel();
        $kemungkinanList   = new KriteriaKemungkinanModel();
        $dampakList        = new KriteriaDampakModel();

        $idKonteks = $this->request->getGet('id_konteks');
        $filter = $this->request->getGet('filter');

        $activeKonteks   = null;
        $selectedContext = null;

        /* GET ACTIVE CONTEXT */
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
            }
        }

        /* MAIN DATA QUERY
        |---------------------------------------
        | Menampilkan SEMUA Identifikasi Risiko
        | LEFT JOIN ke Penilaian Risiko */
        $builder = $identifikasiModel
            ->select('
                identifikasi_risiko.id_identifikasi,
                identifikasi_risiko.kode_risiko,
                identifikasi_risiko.pernyataan_risiko,

                proses_bisnis.kode_proses,
                proses_bisnis.uraian_proses,

                sasaran_kinerja.uraian_sasaran AS sasaran_kinerja,

                penilaian_risiko.id_penilaian,
                penilaian_risiko.nilai_risiko,
                penilaian_risiko.tindakan,
                penilaian_risiko.efektivitas,

                matriks_risiko.level_kemungkinan,
                matriks_risiko.level_dampak,

                selera_risiko.nama_level as nama_selera
            ')
            ->join(
                'proses_bisnis',
                'proses_bisnis.id_proses = identifikasi_risiko.id_proses'
            )
            ->join(
                'sasaran_kinerja',
                'sasaran_kinerja.id_proses = proses_bisnis.id_proses',
                'left'
            )
            ->join(
                'penilaian_risiko',
                'penilaian_risiko.id_identifikasi = identifikasi_risiko.id_identifikasi',
                'left'
            )
            ->join(
                'matriks_risiko',
                'matriks_risiko.id_matriks = penilaian_risiko.id_matriks',
                'left'
            )
            ->join(
                'selera_risiko',
                'selera_risiko.id_selera = penilaian_risiko.id_selera',
                'left'
            );

        if ($activeKonteks) {
            $builder->where('proses_bisnis.id_konteks', $idKonteks);
        }

        // FILTER LOGIC
        if ($filter === 'sudah') {
            $builder->where('penilaian_risiko.id_penilaian IS NOT NULL');
        }

        if ($filter === 'belum') {
            $builder->where('penilaian_risiko.id_penilaian IS NULL');
        }

        $data = $builder
            ->orderBy('identifikasi_risiko.kode_risiko', 'ASC')
            ->findAll();

        /* SUMMARY DATA (SEPARATE QUERY) */
        $identifikasiSummary = new IdentifikasiRisikoModel();

        /* TOTAL RISIKO */
        $builderTotal = $identifikasiSummary
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses');

        if ($activeKonteks) {
            $builderTotal->where('proses_bisnis.id_konteks', $idKonteks);
        }

        $totalRisiko = $builderTotal->countAllResults();

        /* TOTAL SUDAH DIANALISIS */
        $identifikasiSudah = new IdentifikasiRisikoModel();

        $builderSudah = $identifikasiSudah
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses')
            ->join('penilaian_risiko', 'penilaian_risiko.id_identifikasi = identifikasi_risiko.id_identifikasi');

        if ($activeKonteks) {
            $builderSudah->where('proses_bisnis.id_konteks', $idKonteks);
        }

        $totalSudah = $builderSudah->countAllResults();

        /* TOTAL BELUM */
        $totalBelum = $totalRisiko - $totalSudah;

        /* DISTRIBUSI LEVEL RISIKO */
        $builderDistribusi = $identifikasiModel
            ->select('selera_risiko.nama_level, COUNT(*) as total')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses')
            ->join(
                'penilaian_risiko',
                'penilaian_risiko.id_identifikasi = identifikasi_risiko.id_identifikasi'
            )
            ->join(
                'selera_risiko',
                'selera_risiko.id_selera = penilaian_risiko.id_selera'
            )
            ->groupBy('selera_risiko.nama_level');

        if ($activeKonteks) {
            $builderDistribusi->where('proses_bisnis.id_konteks', $idKonteks);
        }

        $distribusi = $builderDistribusi->findAll();

        /* Format ke array associative */
        $levelRisiko = [
            'Rendah'  => 0,
            'Sedang'  => 0,
            'Tinggi'  => 0,
            'Ekstrem' => 0
        ];

        foreach ($distribusi as $row) {
            $levelRisiko[$row['nama_level']] = $row['total'];
        }

        /* GET ALL CONTEXT FOR DROPDOWN */
        $konteksList = $konteksModel
            ->select('
                konteks.id_konteks,
                konteks.kegiatan,
                konteks.tahun,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis')
            ->orderBy('nama_satuan_kerja')
            ->findAll();

        $kemungkinanList = $kemungkinanList
            ->select('id_kriteria as id_kemungkinan, level, nama_level, deskripsi_frekuensi')
            ->orderBy('level', 'ASC')
            ->findAll();

        $dampakList = $dampakList
            ->select('id_kriteria as id_dampak, level, nama_level, deskripsi')
            ->orderBy('level', 'ASC')
            ->findAll();

        return view('analisis_risiko/index', [
            'activeKonteks'   => $activeKonteks,
            'selectedContext' => $selectedContext,
            'konteksList'     => $konteksList,
            'data'            => $data,
            'kemungkinanList' => $kemungkinanList,
            'dampakList'      => $dampakList,
            // SUMMARY
            'totalRisiko'     => $totalRisiko,
            'totalSudah'      => $totalSudah,
            'totalBelum'      => $totalBelum,
            'filter'          => $filter,
            'levelRisiko'     => $levelRisiko
        ]);
    }

    /* DETAIL (AJAX) */
    public function detail($id)
    {
        $model = new PenilaianRisikoModel();

        $data = $model
            ->select('
            penilaian_risiko.*,

            identifikasi_risiko.kode_risiko,
            identifikasi_risiko.pernyataan_risiko,

            proses_bisnis.kode_proses,
            proses_bisnis.uraian_proses,

            sasaran_kinerja.uraian_sasaran AS sasaran_kinerja,

            konteks.kegiatan,
            konteks.tahun,
            satuan_kerja.nama_satuan_kerja,
            sasaran_strategis.uraian_sasaran AS sasaran_strategis,

            matriks_risiko.level_kemungkinan,
            matriks_risiko.level_dampak,

            selera_risiko.nama_level
        ')
            ->join('identifikasi_risiko', 'identifikasi_risiko.id_identifikasi = penilaian_risiko.id_identifikasi')
            ->join('proses_bisnis', 'proses_bisnis.id_proses = identifikasi_risiko.id_proses')
            ->join('konteks', 'konteks.id_konteks = proses_bisnis.id_konteks')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja', 'left')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis', 'left')
            ->join('sasaran_kinerja', 'sasaran_kinerja.id_proses = proses_bisnis.id_proses', 'left')
            ->join('matriks_risiko', 'matriks_risiko.id_matriks = penilaian_risiko.id_matriks', 'left')
            ->join('selera_risiko', 'selera_risiko.id_selera = penilaian_risiko.id_selera', 'left')
            ->where('penilaian_risiko.id_penilaian', $id)
            ->first();

        return $this->response->setJSON($data);
    }

    /* STORE ANALISIS */
    public function store()
    {
        $penilaianModel = new PenilaianRisikoModel();
        $matriksModel   = new MatriksRisikoModel();
        $seleraModel    = new SeleraRisikoModel();

        $idKemungkinan = $this->request->getPost('id_kemungkinan');
        $idDampak      = $this->request->getPost('id_dampak');

        $levelKemungkinan = (new KriteriaKemungkinanModel())
            ->find($idKemungkinan)['level'];

        $levelDampak = (new KriteriaDampakModel())
            ->find($idDampak)['level'];

        $matriks = $matriksModel
            ->where('level_kemungkinan', $levelKemungkinan)
            ->where('level_dampak', $levelDampak)
            ->first();

        $nilaiRisiko = $matriks['nilai_risiko'];

        $selera = $seleraModel
            ->where('nilai_min <=', $nilaiRisiko)
            ->where('nilai_max >=', $nilaiRisiko)
            ->first();

        $penilaianModel->insert([
            'id_identifikasi' => $this->request->getPost('id_identifikasi'),
            'id_kemungkinan'  => $idKemungkinan,
            'id_dampak'       => $idDampak,
            'id_matriks'      => $matriks['id_matriks'],
            'id_selera'       => $selera['id_selera'],
            'nilai_risiko'    => $nilaiRisiko,
            'warna_risiko'    => $matriks['warna'],
            'tindakan'        => $selera['tindakan'],
            'status_penilaian' => 'final',
            'catatan_analis' => $this->request->getPost('catatan_analis')
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $penilaianModel = new PenilaianRisikoModel();
        $matriksModel   = new MatriksRisikoModel();
        $seleraModel    = new SeleraRisikoModel();

        $idKemungkinan = $this->request->getPost('id_kemungkinan');
        $idDampak      = $this->request->getPost('id_dampak');

        // Ambil level
        $levelKemungkinan = (new KriteriaKemungkinanModel())
            ->find($idKemungkinan)['level'];

        $levelDampak = (new KriteriaDampakModel())
            ->find($idDampak)['level'];

        // Cari matriks baru
        $matriks = $matriksModel
            ->where('level_kemungkinan', $levelKemungkinan)
            ->where('level_dampak', $levelDampak)
            ->first();

        $nilaiRisiko = $matriks['nilai_risiko'];

        // Cari selera baru
        $selera = $seleraModel
            ->where('nilai_min <=', $nilaiRisiko)
            ->where('nilai_max >=', $nilaiRisiko)
            ->first();

        // Update lengkap
        $penilaianModel->update($id, [
            'id_kemungkinan' => $idKemungkinan,
            'id_dampak'      => $idDampak,
            'id_matriks'     => $matriks['id_matriks'],
            'id_selera'      => $selera['id_selera'],
            'nilai_risiko'   => $nilaiRisiko,
            'warna_risiko'   => $matriks['warna'],
            'tindakan'       => $selera['tindakan'],
            'catatan_analis' => $this->request->getPost('catatan_analis'),
        ]);

        return $this->response->setJSON(['status' => 'updated']);
    }

    public function delete($id)
    {
        $model = new PenilaianRisikoModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }

    public function preview()
    {
        $idKemungkinan = $this->request->getPost('id_kemungkinan');
        $idDampak      = $this->request->getPost('id_dampak');

        if (!$idKemungkinan || !$idDampak) {
            return $this->response->setJSON(['status' => 'empty']);
        }

        $kemungkinan = (new KriteriaKemungkinanModel())->find($idKemungkinan);
        $dampak      = (new KriteriaDampakModel())->find($idDampak);

        if (!$kemungkinan || !$dampak) {
            return $this->response->setJSON(['status' => 'invalid']);
        }

        $matriks = (new MatriksRisikoModel())
            ->where('level_kemungkinan', $kemungkinan['level'])
            ->where('level_dampak', $dampak['level'])
            ->first();

        if (!$matriks) {
            return $this->response->setJSON(['status' => 'not_found']);
        }

        $selera = (new SeleraRisikoModel())
            ->where('nilai_min <=', $matriks['nilai_risiko'])
            ->where('nilai_max >=', $matriks['nilai_risiko'])
            ->first();

        return $this->response->setJSON([
            'status'        => 'success',
            'nilai_risiko'  => $matriks['nilai_risiko'],
            'warna'         => $matriks['warna'],
            'nama_selera'   => $selera['nama_level'] ?? '-',
            'tindakan'      => $selera['tindakan'] ?? '-'
        ]);
    }
}
