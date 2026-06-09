<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $users = $db->table('users u')
            ->select('u.*, r.name as role_name, t.nama_tim as tim_name')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('tim_kerja t', 't.id_tim = u.id_tim', 'left')
            ->get()
            ->getResultArray();

        $roles = $db->table('roles')->get()->getResultArray();
        $timKerja = $db->table('tim_kerja')->get()->getResultArray();

        return view('user/index', [
            'users' => $users,
            'roles' => $roles,
            'timKerja' => $timKerja,
            'hideGlobalContext' => true,
        ]);
    }

    public function table()
    {
        $data = $this->model
            ->select('users.*, roles.name role_name, tim_kerja.nama_tim')
            ->join('roles', 'roles.id=users.role_id', 'left')
            ->join('tim_kerja', 'tim_kerja.id_tim=users.id_tim', 'left')
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function store()
    {
        $email = trim($this->request->getPost('email'));

        $exists = $this->model
            ->where('email', $email)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $email,
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'role_id'  => $this->request->getPost('role_id'),
            'id_tim' => $this->request->getPost('id_tim') === ''
                ? null
                : $this->request->getPost('id_tim'),
        ];

        $this->model->insert($data);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function update($id)
    {
        $email = trim($this->request->getPost('email'));

        $exists = $this->model
            ->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($exists) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $idTim = $this->request->getPost('id_tim');

        $data = [
            'name'    => $this->request->getPost('name'),
            'email'   => $email,
            'role_id' => $this->request->getPost('role_id'),
            'id_tim'  => $idTim === '' ? null : $idTim,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->model->update($id, $data);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function detail($id)
    {
        $user = $this->model
            ->select('
            users.id,
            users.name,
            users.email,
            users.role_id,
            users.id_tim,
            roles.name as role_name,
            tim_kerja.nama_tim
        ')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('tim_kerja', 'tim_kerja.id_tim = users.id_tim', 'left')
            ->where('users.id', $id)
            ->first();

        if (!$user) {
            return $this->response->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'User tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $user
        ]);
    }

    public function delete($id)
    {
        if (session('user_id') == $id) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Tidak bisa menghapus akun sendiri'
            ]);
        }

        $this->model->delete($id);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    public function roles()
    {
        $data = db_connect()
            ->table('roles')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }

    public function timKerja()
    {
        $data = db_connect()
            ->table('tim_kerja')
            ->select('id_tim,nama_tim')
            ->orderBy('nama_tim', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($data);
    }
}
