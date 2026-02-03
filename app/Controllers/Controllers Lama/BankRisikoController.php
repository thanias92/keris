<?php

namespace App\Controllers;

class BankRisikoControllerController extends BaseController
{
    public function index()
    {
        return view('bank-risiko/index', [
            'title' => 'Bank Risiko SIMIKO'
        ]);
    }
}
