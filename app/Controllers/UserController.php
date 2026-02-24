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
        return view('user/index', [
            'users' => $this->model->findAll()
        ]);
    }

    public function store()
    {
        $this->model->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function update($id)
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'role'  => $this->request->getPost('role'),
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
