<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\KriteriaKemungkinanModel;
use App\Models\KriteriaDampakModel;
use App\Models\MatriksRisikoModel;
use App\Models\SeleraRisikoModel;
use App\Models\SasaranStrategisModel;

class MasterDataController extends BaseContextController
{
    /* ==========================
       TAB KRITERIA
    ========================== */
    public function kriteria()
    {
        return view('penetapan_konteks/index', [
            'activeTab'  => 'kriteria',
            'kemungkinan' => (new KriteriaKemungkinanModel())
                ->orderBy('level', 'ASC')
                ->findAll(),
            'dampak'      => (new KriteriaDampakModel())
                ->orderBy('level', 'ASC')
                ->findAll(),
        ]);
    }

    /* ==========================
       TAB MATRIKS RISIKO
    ========================== */
    public function matriks()
    {
        $model = new MatriksRisikoModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'matriks',
            'data'      => $model
                ->orderBy('level_kemungkinan', 'DESC')
                ->orderBy('level_dampak', 'ASC')
                ->findAll(),
        ]);
    }

    /* ==========================
       TAB SELERA RISIKO
    ========================== */
    public function selera()
    {
        $model = new SeleraRisikoModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'selera',
            'data'      => $model
                ->orderBy('level', 'ASC')
                ->findAll(),
        ]);
    }

    /* ==========================
       TAB SASARAN STRATEGIS
    ========================== */
    public function sasaranStrategis()
    {
        $model = new SasaranStrategisModel();

        return view('penetapan_konteks/index', [
            'activeTab' => 'sasaran_strategis',
            'data'      => $model
                ->orderBy('kode_sasaran', 'ASC')
                ->findAll(),
        ]);
    }
}
