<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\KonteksModel;
use App\Models\KonteksPemangkuModel;
use App\Models\KonteksPeraturanModel;
use App\Models\PemangkuKepentinganModel;
use App\Models\PeraturanTerkaitModel;

class KonteksController extends BaseContextController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KonteksModel();
    }

    /* =====================================================
       INDEX (LOAD FULL PAGE)
    ===================================================== */
    public function index()
    {
        $listPemangku = (new PemangkuKepentinganModel())->findAll();
        $listPeraturan = (new PeraturanTerkaitModel())->findAll();

        $builder = $this->model
            ->select('
                konteks.*,
                satuan_kerja.nama_satuan_kerja,
                sasaran_strategis.uraian_sasaran
            ')
            ->join('satuan_kerja', 'satuan_kerja.id_satuan_kerja = konteks.id_satuan_kerja')
            ->join('sasaran_strategis', 'sasaran_strategis.id_sasaran_strategis = konteks.id_sasaran_strategis');

        // FILTER
        $sk  = $this->request->getGet('sk');
        $pr  = $this->request->getGet('pr');
        $th  = $this->request->getGet('th');
        $kg  = $this->request->getGet('kg');
        $ss  = $this->request->getGet('ss');

        if ($sk) $builder->where('satuan_kerja.nama_satuan_kerja', $sk);
        if ($pr) $builder->where('konteks.pengelola_risiko', $pr);
        if ($th) $builder->where('konteks.tahun', $th);
        if ($kg) $builder->where('konteks.kegiatan', $kg);
        if ($ss) $builder->where('sasaran_strategis.uraian_sasaran', $ss);

        $perPage = (int) ($this->request->getGet('perPage') ?? 5);

        $data = $builder
            ->orderBy('tahun', 'DESC')
            ->paginate($perPage);

        $pager = $this->model->pager;

        $total = $pager->getTotal();
        $currentPage = $pager->getCurrentPage();
        $from = ($currentPage - 1) * $perPage + 1;
        $to = $from + count($data) - 1;

        if ($total == 0) {
            $from = 0;
            $to = 0;
        }

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'konteks',
                    'data'      => $data,
                    'pager'     => $pager,
                    'from'      => $from,
                    'to'        => $to,
                    'total'     => $total,
                    'perPage'   => $perPage,
                    'listPemangku'   => $listPemangku,
                    'listPeraturan'  => $listPeraturan,
                    'filters'   => compact('sk', 'pr', 'th', 'kg', 'ss')
                ]
            )
        );
    }

    /* =====================================================
       STORE (AJAX CREATE)
    ===================================================== */
    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data = [
            'tahun' => $this->request->getPost('tahun'),
            'pengelola_risiko' => $this->request->getPost('pengelola_risiko'),
            'kegiatan' => $this->request->getPost('kegiatan'),
            'id_satuan_kerja' => $this->request->getPost('id_satuan_kerja'),
            'id_sasaran_strategis' => $this->request->getPost('id_sasaran_strategis'),
        ];

        $this->model->insert($data);
        $idKonteks = $this->model->getInsertID();

        // === SIMPAN PEMANGKU ===
        $pemangkuIds = $this->request->getPost('pemangku') ?? [];

        $pemangkuModel = new KonteksPemangkuModel();

        foreach ($pemangkuIds as $idPemangku) {
            $pemangkuModel->insert([
                'id_konteks' => $idKonteks,
                'id_pemangku' => $idPemangku,
            ]);
        }

        // === SIMPAN PERATURAN ===
        $peraturanIds = $this->request->getPost('peraturan') ?? [];

        $peraturanModel = new KonteksPeraturanModel();

        foreach ($peraturanIds as $idPeraturan) {
            $peraturanModel->insert([
                'id_konteks' => $idKonteks,
                'id_peraturan' => $idPeraturan,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil disimpan'
        ]);
    }

    /* =====================================================
       UPDATE (AJAX EDIT)
    ===================================================== */
    public function update()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $id = $this->request->getPost('id_konteks');

        $data = [
            'tahun'             => $this->request->getPost('tahun'),
            'pengelola_risiko'  => $this->request->getPost('pengelola_risiko'),
            'kegiatan'          => $this->request->getPost('kegiatan'),
            'id_satuan_kerja'   => $this->request->getPost('id_satuan_kerja'),
            'id_sasaran_strategis' => $this->request->getPost('id_sasaran_strategis'),
        ];

        $this->model->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data berhasil diubah'
        ]);
    }

    /* =====================================================
       DELETE (AJAX)
    ===================================================== */
    public function delete()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $id = $this->request->getPost('id_konteks');

        $this->model->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    /* =====================================================
       AJAX TABLE REFRESH
    ===================================================== */
    public function ajaxTable()
    {
        $data = $this->model
            ->orderBy('tahun', 'DESC')
            ->findAll();

        return view(
            'penetapan_konteks/tabs/konteks/_table_section',
            [
                'data'     => $data,
                'from'     => 1,
                'to'       => count($data),
                'total'    => count($data),
                'filters'  => [],
                'perPage'  => 5
            ]
        );
    }

    /* =====================================================
       SET ACTIVE
    ===================================================== */
    public function setActive()
    {
        $id = $this->request->getPost('id_konteks');

        if (!$id) {
            return redirect()->back();
        }

        session()->set('id_konteks_aktif', $id);

        return redirect()->to(site_url('penetapan-konteks'));
    }
}
