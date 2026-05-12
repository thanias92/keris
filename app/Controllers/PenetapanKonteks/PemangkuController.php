<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\PemangkuKepentinganModel;

class PemangkuController extends BaseContextController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PemangkuKepentinganModel();
    }

    public function index()
    {
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        $data    = $this->model
            ->orderBy('hubungan', 'ASC')
            ->orderBy('nama_instansi', 'ASC')
            ->paginate($perPage);
        $pager   = $this->model->pager;
        $total   = $pager->getTotal();
        $currentPage = $pager->getCurrentPage();
        $from    = $total == 0 ? 0 : ($currentPage - 1) * $perPage + 1;
        $to      = $from + count($data) - 1;

        return view('penetapan_konteks/index', array_merge(
            $this->contextData(),
            [
                'activeTab' => 'pemangku',
                'data'      => $data,
                'pager'     => $pager,
                'from'      => $from,
                'to'        => $to,
                'total'     => $total,
                'perPage'   => $perPage,
                'hideGlobalContext' => true,
            ]
        ));
    }

    public function ajaxTable()
    {
        $data = $this->model
            ->orderBy('hubungan', 'ASC')
            ->orderBy('nama_instansi', 'ASC')
            ->findAll();

        return view('penetapan_konteks/tabs/pemangku/_table_section', [
            'data' => $data,
        ]);
    }

    public function detail($id)
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $data = $this->model->find($id);
        if (!$data) return $this->response->setStatusCode(404);

        return $this->response->setJSON($data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $this->model->insert([
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'hubungan'      => $this->request->getPost('hubungan'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Pemangku Kepentingan berhasil disimpan.',
        ]);
    }

    public function update($id)
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $this->model->update($id, [
            'nama_instansi' => $this->request->getPost('nama_instansi'),
            'hubungan'      => $this->request->getPost('hubungan'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Pemangku Kepentingan berhasil diperbarui.',
        ]);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $this->model->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Pemangku Kepentingan berhasil dihapus.',
        ]);
    }
}
