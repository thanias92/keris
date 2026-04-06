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

        // REDIRECT SESUAI ROLE
        $role = session('user_role');

        if ($role === 'admin') {
            return redirect()->to('/dashboard');
        }

        if ($role === 'operator') {
            return redirect()->to('/dashboard');
        }

        if ($role === 'ketua') {
            return redirect()->to('/dashboard');
        }

        return redirect()->to('/');
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/login');
    }
}
