<?php

namespace App\Controllers\PenetapanKonteks;

use App\Models\KriteriaKemungkinanModel;
use App\Models\KriteriaDampakModel;
use App\Models\MatriksRisikoModel;
use App\Models\SeleraRisikoModel;
use App\Models\SasaranStrategisModel;

class MasterDataController extends BaseContextController
{
    public function kriteria()
    {
        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab'  => 'kriteria',
                    'kemungkinan' => (new KriteriaKemungkinanModel())
                        ->orderBy('level', 'ASC')
                        ->findAll(),
                    'dampak' => (new KriteriaDampakModel())
                        ->orderBy('level', 'ASC')
                        ->findAll(),
                    'filters' => [],
                    'hideGlobalContext' => true,
                ]
            ),
        );
    }

    public function matriks()
    {
        $model = new MatriksRisikoModel();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'matriks',
                    'data' => $model
                        ->orderBy('level_kemungkinan', 'DESC')
                        ->orderBy('level_dampak', 'ASC')
                        ->findAll(),
                    'filters' => [],
                    'hideGlobalContext' => true,
                ]
            )
        );
    }

    public function selera()
    {
        $model = new SeleraRisikoModel();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'selera',
                    'data' => $model
                        ->orderBy('level', 'ASC')
                        ->findAll(),
                    'filters' => [],
                    'hideGlobalContext' => true,
                ]
            )
        );
    }

    public function sasaranStrategis()
    {
        $model = new SasaranStrategisModel();

        return view(
            'penetapan_konteks/index',
            array_merge(
                $this->contextData(),
                [
                    'activeTab' => 'sasaran_strategis',
                    'data' => $model
                        ->orderBy('kode_sasaran', 'ASC')
                        ->findAll(),
                    'filters' => [],
                    'hideGlobalContext' => true,
                ]
            )
        );
    }
}
