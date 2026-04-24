<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TimKerjaModel;

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
            'timKerja' => $timKerja
        ]);
    }

    public function store()
    {
        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'  => $this->request->getPost('role_id'),
            'id_tim'   => $this->request->getPost('id_tim'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->with('error', 'Gagal menambahkan user');
        }

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update($id)
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'role_id'  => $this->request->getPost('role_id'),
            'id_tim'   => $this->request->getPost('id_tim'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->model->update($id, $data);

        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        if (session('user_id') == $id) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        $this->model->delete($id);

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
