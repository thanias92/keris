<?php

namespace App\Controllers;
use App\Models\IdentifikasiRisikoModel;
use App\Models\PenetapanKonteksModel;

class IdentifikasiRisikoController extends BaseController
{
    protected $identifikasiRisikoModel;

    public function __construct()
    {
        $this->identifikasiRisikoModel = new IdentifikasiRisikoModel();
    }

    /**
     * LIST DATA
     */
    public function index()
    {
        $data['risiko'] = $this->identifikasiRisikoModel->findAll();

        return view('identifikasi_risiko/index', $data);
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $konteksModel = new PenetapanKonteksModel();

        $kodeRisiko = $this->identifikasiRisikoModel->generateKodeRisiko();

        $data = [
            'konteksList' => $konteksModel->findAll(),
            'kodeRisiko'  => $kodeRisiko, // ⬅ INI YANG KURANG
        ];

        return view('identifikasi_risiko/create', $data);
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store()
    {
        // 1️⃣ generate kode (sekali saja)
        $kodeRisiko = $this->identifikasiRisikoModel->generateKodeRisiko();

        // 2️⃣ insert TANPA id_identifikasi
        $data = [
            'kode_risiko'       => $kodeRisiko, // ✅ PAKAI
            'id_konteks'        => $this->request->getPost('id_konteks'),
            'uraian_kegiatan'   => $this->request->getPost('uraian_kegiatan'),
            'indikator'         => $this->request->getPost('indikator'),
            'pernyataan_risiko' => $this->request->getPost('pernyataan_risiko'),
            'penyebab_risiko'   => $this->request->getPost('penyebab_risiko'),
            'kategori_risiko'   => $this->request->getPost('kategori_risiko'),
            'sumber_risiko'     => $this->request->getPost('sumber_risiko'),
        ];

        $this->identifikasiRisikoModel->insert($data);

        return redirect()->to('/identifikasi-risiko')
            ->with('success', 'Data risiko berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $data['risiko'] = $this->identifikasiRisikoModel->find($id);

        if (!$data['risiko']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('identifikasi_risiko/edit', $data);
    }

    /**
     * UPDATE DATA
     */
    public function update($id)
    {
        $data = [
            'uraian_kegiatan'    => $this->request->getPost('uraian_kegiatan'),
            'indikator'          => $this->request->getPost('indikator'),
            'pernyataan_risiko'  => $this->request->getPost('pernyataan_risiko'),
            'penyebab_risiko'    => $this->request->getPost('penyebab_risiko'),
            'kategori_risiko'    => $this->request->getPost('kategori_risiko'),
            'sumber_risiko'      => $this->request->getPost('sumber_risiko'),
        ];

        $this->identifikasiRisikoModel->update($id, $data);

        return redirect()->to('/identifikasi-risiko')
            ->with('success', 'Data risiko berhasil diperbarui');
    }

    /**
     * HAPUS DATA
     */
    public function delete($id)
    {
        $this->identifikasiRisikoModel->delete($id);

        return redirect()->to('/identifikasi-risiko')
            ->with('success', 'Data risiko berhasil dihapus');
    }
}
