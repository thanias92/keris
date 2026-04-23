<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\ProsesBisnisModel;
use App\Models\KonteksProsesBisnisModel;

class ProsesBisnisController extends BaseContextController
{
    protected $model;
    protected $junctionModel;

    public function __construct()
    {
        $this->model         = new ProsesBisnisModel();
        $this->junctionModel = new KonteksProsesBisnisModel();
    }

    public function index()
    {
        $activeKonteks = $this->getActiveKonteks();

        // Semua master proses bisnis
        $allProses = $this->model
            ->orderBy('kode_proses', 'ASC')
            ->findAll();

        // Yang sudah dipilih untuk konteks aktif
        $selectedProses = [];
        $selectedProsesData = [];
        if ($activeKonteks) {
            $rows = $this->junctionModel->getByKonteks($activeKonteks['id_konteks']);
            $selectedProses = array_column($rows, 'id_proses');
            $selectedProsesData = $rows;
        }

        return view('penetapan_konteks/index', array_merge(
            $this->contextData(),
            [
                'activeTab'      => 'proses_bisnis',
                'allProses'      => $allProses,
                'selectedProses' => $selectedProses,
                'selectedProsesData' => $selectedProsesData,
            ]
        ));
    }

    public function sync()
    {
        if (!$this->request->isAJAX()) return redirect()->back();

        $user = session()->get('user');

        $idKonteks   = $this->request->getPost('id_konteks');
        $idProsesList = $this->request->getPost('id_proses') ?? [];

        log_message('error', 'SYNC KONTEKS: ' . $idKonteks);
        log_message('error', 'SYNC PROSES: ' . json_encode($idProsesList));


        if (!$idKonteks) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Konteks tidak ditemukan.',
            ]);
        }

        // TAMBAHAN CEK TIM
        if ($user['role'] === 'operator') {

            // ambil data konteks
            $konteks = $this->getActiveKonteks();

            if (!$konteks || $konteks['id_konteks'] != $idKonteks) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Akses tidak valid.',
                ]);
            }

            // CEK TIM
            if ($konteks['id_tim'] != $user['id_tim']) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Kamu tidak boleh mengedit konteks tim lain.',
                ]);
            }
        }

        // lanjut normal
        $this->junctionModel->syncByKonteks($idKonteks, $idProsesList);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Proses Bisnis berhasil disimpan.',
        ]);
    }

    public function ajaxTable()
    {
        $activeKonteks = $this->getActiveKonteks();
        $selectedProsesData = [];

        if ($activeKonteks) {
            $selectedProsesData = $this->junctionModel
                ->getByKonteks($activeKonteks['id_konteks']);
        }

        return view('penetapan_konteks/tabs/proses_bisnis/_table_section', [
            'data' => $selectedProsesData,
        ]);
    }
}
