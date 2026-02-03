<?php

namespace App\Controllers;

class MonitoringRisikoRisiko extends BaseController
{
    public function index()
    {
        return view('MonitoringRisiko/index', [
            'title' => 'Monitoring Risiko'
        ]);
    }
}
