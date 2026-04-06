<?php

namespace App\Controllers\RBAC;

use App\Controllers\BaseController;

class PermissionController extends BaseController
{
    public function index()
    {
        if (!hasPermission('manage_roles')) {
            return redirect()->to('/rbac/unauthorized');
        }

        $db = \Config\Database::connect();

        $permissions = $db->table('permissions')
            ->orderBy('module')
            ->get()
            ->getResult();

        return view('rbac/permission/index', [
            'permissions' => $permissions
        ]);
    }

    public function store()
    {
        if (!hasPermission('manage_roles')) {
            return redirect()->to('/rbac/unauthorized');
        }

        $db = \Config\Database::connect();

        $name = strtolower($this->request->getPost('name'));
        $module = strtolower($this->request->getPost('module'));

        $exists = $db->table('permissions')->where('name', $name)->get()->getRow();

        if ($exists) {
            return redirect()->back()->with('error', 'Permission sudah ada');
        }

        $db->table('permissions')->insert([
            'name' => $name,
            'module' => $module
        ]);

        return redirect()->back()->with('success', 'Permission berhasil ditambahkan');
    }

    public function update($id)
    {
        if (!hasPermission('manage_roles')) {
            return redirect()->to('/rbac/unauthorized');
        }

        $db = \Config\Database::connect();

        $name = strtolower($this->request->getPost('name'));
        $module = strtolower($this->request->getPost('module'));

        $db->table('permissions')->where('id', $id)->update([
            'name' => $name,
            'module' => $module
        ]);

        return redirect()->back()->with('success', 'Permission berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!hasPermission('manage_roles')) {
            return redirect()->to('/rbac/unauthorized');
        }

        $db = \Config\Database::connect();

        $db->table('permissions')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Permission berhasil dihapus');
    }
}
