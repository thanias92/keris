<?php

namespace App\Controllers;

class PenetapanLevelRisikoRisiko extends BaseController
{
    public function index()
    {
        return view('penetapanLevelRisiko/index', [
            'title' => 'Penetapan Level Risiko'
        ]);
    }
}
