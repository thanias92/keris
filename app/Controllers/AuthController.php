<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$this->authService->loginWithPassword($email, $password)) {
            return redirect()->back()->with('error', 'Email atau password salah');
        }

        return redirect()->to('/penetapan-konteks');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/login');
    }
}
