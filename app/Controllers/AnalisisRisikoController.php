<?php

namespace App\Controllers;

use App\Models\IdentifikasiRisikoModel;
use App\Models\PenilaianRisikoModel;

class AnalisisRisikoController extends BaseController
{
    protected $identifikasiModel;
    protected $penilaianModel;

    public function __construct()
    {
        $this->identifikasiModel = new IdentifikasiRisikoModel();
        $this->penilaianModel   = new PenilaianRisikoModel();
    }

    /**
     * HALAMAN ANALISIS RISIKO
     * Menampilkan daftar risiko + nilai analisis
     */
    public function index()
    {
        helper('text');
        $data['risiko'] = $this->identifikasiModel
            ->select('
        identifikasi_risiko.id_identifikasi,
        identifikasi_risiko.kode_risiko,
        identifikasi_risiko.pernyataan_risiko,
        penilaian_risiko.kemungkinan,
        penilaian_risiko.dampak,
        penilaian_risiko.nilai_risiko,
        penilaian_risiko.efektivitas_pengendalian,
        penilaian_risiko.catatan_analisis,
        penilaian_risiko.pengendalian_eksisting
    ')
            ->join(
                'penilaian_risiko',
                'penilaian_risiko.id_identifikasi = identifikasi_risiko.id_identifikasi',
                'left'
            )
            ->findAll();


        return view('analisis_risiko/index', $data);
    }

    /**
     * SIMPAN / UPDATE ANALISIS RISIKO
     */
    public function store()
    {
        $idIdentifikasi = $this->request->getPost('id_identifikasi');
        $P = (int) $this->request->getPost('kemungkinan');
        $D = (int) $this->request->getPost('dampak');

        $nilaiRisiko = $P * $D;

        // Tentukan level & warna (SESUI MATRKS SUPAS)
        if ($nilaiRisiko <= 5) {
            $level = 1;
            $tingkat = 'Sangat Rendah';
            $warna = 'biru';
        } elseif ($nilaiRisiko <= 10) {
            $level = 2;
            $tingkat = 'Rendah';
            $warna = 'hijau';
        } elseif ($nilaiRisiko <= 14) {
            $level = 3;
            $tingkat = 'Sedang';
            $warna = 'kuning';
        } elseif ($nilaiRisiko <= 19) {
            $level = 4;
            $tingkat = 'Tinggi';
            $warna = 'oranye';
        } else {
            $level = 5;
            $tingkat = 'Sangat Tinggi';
            $warna = 'merah';
        }

        $data = [
            'id_identifikasi' => $idIdentifikasi,
            'kemungkinan'     => $P,
            'dampak'          => $D,
            'nilai_risiko'    => $nilaiRisiko,
            'level_risiko'    => $level,
            'tingkat_risiko'  => $tingkat,
            'warna_level'     => $warna,
            'pengendalian_eksisting' => $this->request->getPost('pengendalian_eksisting'),
            'catatan_analisis' => $this->request->getPost('catatan_analisis'),
            'efektivitas_pengendalian' => $this->request->getPost('efektivitas_pengendalian'),
            'jenis_penilaian' => 'Aktual',
            'tanggal_penilaian' => date('Y-m-d'),
        ];

        // cek apakah sudah ada analisis
        $existing = $this->penilaianModel
            ->where('id_identifikasi', $idIdentifikasi)
            ->where('jenis_penilaian', 'Aktual')
            ->first();

        if ($existing) {
            $this->penilaianModel->update($existing['id_penilaian'], $data);
        } else {
            $this->penilaianModel->insert($data);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'ok',
                'data' => [
                    'kemungkinan' => $P,
                    'dampak' => $D,
                    'nilai' => $nilaiRisiko,
                    'efektivitas' => $data['efektivitas_pengendalian'],
                    'pengendalian' => $data['pengendalian_eksisting'],
                    'warna' => $warna
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Analisis risiko berhasil disimpan');
    }
}
