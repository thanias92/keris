<?php

namespace App\Controllers;

class IdentifikasiRisiko extends BaseController
{
    public function index()
    {
        return view('identifikasiRisiko/index', [
            'title' => 'Identifikasi Risiko'
        ]);
    }
}
