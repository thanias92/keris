<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN DENGAN EMAIL + PASSWORD (SEKARANG)
    |--------------------------------------------------------------------------
    */
    public function loginWithPassword(string $email, string $password): bool
    {
        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $this->setUserSession($user);

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN DENGAN SSO (NANTI)
    |--------------------------------------------------------------------------
    */
    public function loginWithSSO(array $ssoData): bool
    {
        // Contoh ssoData:
        // [
        //   'email' => 'pegawai@bps.go.id',
        //   'name'  => 'Nama Pegawai'
        // ]

        $user = $this->userModel->where('email', $ssoData['email'])->first();

        // Jika belum ada → auto create
        if (!$user) {
            $userId = $this->userModel->insert([
                'name'     => $ssoData['name'],
                'email'    => $ssoData['email'],
                'password' => null,
                'role'     => 'operator', // default role
            ]);

            $user = $this->userModel->find($userId);
        }

        $this->setUserSession($user);

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | SET SESSION
    |--------------------------------------------------------------------------
    */
    protected function setUserSession(array $user)
    {
        $roleId = $user['role_id'] ?? null;

        switch ($roleId) {
            case 1: $finalRole = 'admin'; break;
            case 2: $finalRole = 'operator'; break;
            case 3: $finalRole = 'ketua'; break;
            default: $finalRole = 'operator'; break;
        }

        session()->set([
            'user_id'      => $user['id'],
            'user_name'    => $user['name'],
            'user_role'    => $finalRole,
            'pengelola_id' => $user['pengelola_id'] ?? null,
            'isLoggedIn'   => true,

            // TAMBAHAN WAJIB UNTUK RBAC
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'role_id' => $user['role_id'] // INI KUNCI
            ]
        ]);
        log_message('error', 'ROLE FINAL: ' . $finalRole);
    }

    public function logout()
    {
        session()->destroy();
    }
}
