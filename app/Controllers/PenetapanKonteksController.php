<?php

namespace App\Controllers;
use App\Models\PenetapanKonteksModel;

class PenetapanKonteksController extends BaseController
{
    protected $penetapanKonteksModel;

    public function __construct()
    {
        $this->penetapanKonteksModel = new PenetapanKonteksModel();
    }

    /**
     * LIST DATA
     */
    public function index()
    {
        $data['konteks'] = $this->penetapanKonteksModel->findAll();
        return view('penetapan_konteks/index', $data);
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('penetapan_konteks/create');
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store()
    {
        $data = [
            'nama_kegiatan'         => $this->request->getPost('nama_kegiatan'),
            'unit_kerja'            => $this->request->getPost('unit_kerja'),
            'tahun'                 => $this->request->getPost('tahun'),
            'penanggung_jawab'      => $this->request->getPost('penanggung_jawab'),
            'tujuan_kegiatan'       => $this->request->getPost('tujuan_kegiatan'),
            'sasaran'               => $this->request->getPost('sasaran'),
            'indikator_keberhasilan' => $this->request->getPost('indikator_keberhasilan'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'asumsi'                => $this->request->getPost('asumsi'),
            'keterbatasan'          => $this->request->getPost('keterbatasan'),
            'faktor_internal'       => $this->request->getPost('faktor_internal'),
            'faktor_eksternal'      => $this->request->getPost('faktor_eksternal'),
        ];

        $this->penetapanKonteksModel->insert($data);

        return redirect()->to('/penetapan-konteks')
            ->with('success', 'Data konteks berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $data['konteks'] = $this->penetapanKonteksModel->find($id);

        if (!$data['konteks']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        return view('penetapan_konteks/edit', $data);
    }

    /**
     * UPDATE DATA
     */
    public function update($id)
    {
        $data = [
            'nama_kegiatan'         => $this->request->getPost('nama_kegiatan'),
            'unit_kerja'            => $this->request->getPost('unit_kerja'),
            'tahun'                 => $this->request->getPost('tahun'),
            'penanggung_jawab'      => $this->request->getPost('penanggung_jawab'),
            'tujuan_kegiatan'       => $this->request->getPost('tujuan_kegiatan'),
            'sasaran'               => $this->request->getPost('sasaran'),
            'indikator_keberhasilan' => $this->request->getPost('indikator_keberhasilan'),
            'ruang_lingkup'         => $this->request->getPost('ruang_lingkup'),
            'asumsi'                => $this->request->getPost('asumsi'),
            'keterbatasan'          => $this->request->getPost('keterbatasan'),
            'faktor_internal'       => $this->request->getPost('faktor_internal'),
            'faktor_eksternal'      => $this->request->getPost('faktor_eksternal'),
        ];

        $this->penetapanKonteksModel->update($id, $data);

        return redirect()->to('/penetapan-konteks')
            ->with('success', 'Data konteks berhasil diperbarui');
    }

    /**
     * HAPUS DATA
     */
    public function delete($id)
    {
        $this->penetapanKonteksModel->delete($id);

        return redirect()->to('/penetapan-konteks')
            ->with('success', 'Data konteks berhasil dihapus');
    }
}
