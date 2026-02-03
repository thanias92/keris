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
        return view('penetapan_konteks/create', [
            'mode'        => 'create',
            'kodeKonteks' => $this->penetapanKonteksModel->generateKodeKonteks(),
        ]);
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store()
    {
        // 1️⃣ generate kode (sekali saja)
        $kodeKonteks = $this->penetapanKonteksModel->generateKodeKonteks();

        // 2️⃣ insert TANPA id_konteks
        $data = [
            'kode_konteks'          => $kodeKonteks,
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
     * MELIHAT DETAIL DATA
     */
    public function view($id)
    {
        $konteks = $this->penetapanKonteksModel->find($id);

        if (!$konteks) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Data konteks tidak ditemukan'
            );
        }

        return view('penetapan_konteks/view', [
            'mode'   => 'view',
            'konteks' => $konteks,
        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $konteks = $this->penetapanKonteksModel->find($id);

        if (!$konteks) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('penetapan_konteks/edit', [
            'mode'        => 'edit',
            'konteks'      => $konteks,
        ]);
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
