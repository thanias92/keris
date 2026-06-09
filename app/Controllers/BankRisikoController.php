<?php

namespace App\Controllers;

use App\Models\BankRisikoModel;
use CodeIgniter\Controller;

class BankRisikoController extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new BankRisikoModel();
    }

    public function index()
    {
        $perPage = 10;
        $data    = $this->model->getForTable($perPage);
        $pager   = $this->model->getPager();

        return view('bank_risiko/index', [
            'data'    => $data,
            'pager'   => $pager,
            'perPage' => $perPage,
            'hideGlobalContext' => true,
        ]);
    }

    public function store()
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->insert([
            'pernyataan_risiko' => $this->request->getPost('pernyataan_risiko'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Bank Risiko berhasil disimpan.',
        ]);
    }

    public function update($id)
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->update($id, [
            'pernyataan_risiko' => $this->request->getPost('pernyataan_risiko'),
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Bank Risiko berhasil diperbarui.',
        ]);
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $this->model->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Bank Risiko berhasil dihapus.',
        ]);
    }

    public function ajaxTable()
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $perPage = $this->request->getGet('per_page') ?? 10;
        $data    = $this->model->getForTable((int) $perPage);
        $pager   = $this->model->getPager();

        return view('bank_risiko/_table_section', [
            'data'    => $data,
            'pager'   => $pager,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Endpoint untuk dropdown Pernyataan Risiko
     * di form Identifikasi Risiko
     */
    public function list()
    {
        if (!$this->request->isAJAX())
            return redirect()->back();

        $data = $this->model->getForDropdown();

        return $this->response->setJSON($data);
    }
}
