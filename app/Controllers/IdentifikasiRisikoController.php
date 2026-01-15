<?php

namespace App\Controllers;

class IdentifikasiRisikoController extends BaseController
{
    public function index()
    {
        return view('identifikasi_risiko/index', [
            'risiko' => []
        ]);
    }

    public function create()
    {
        return view('identifikasi_risiko/create');
    }

    public function store()
    {
        // sementara dump dulu (belum ke DB)
        dd($this->request->getPost());
    }
}
