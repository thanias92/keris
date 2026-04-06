<?php

namespace App\Controllers\RBAC;

use App\Controllers\BaseController;

class RoleController extends BaseController
{
    public function index()
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');
        $db = \Config\Database::connect();
        $roles = $db->table('roles')->get()->getResult();
        return view('rbac/role/index', ['roles' => $roles]);
    }

    public function store()
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');
        $db = \Config\Database::connect();
        $name = strtolower($this->request->getPost('name'));
        $exists = $db->table('roles')->where('name', $name)->get()->getRow();
        if ($exists) return redirect()->back()->with('error', 'Role sudah ada');
        $db->table('roles')->insert(['name' => $name]);
        return redirect()->back()->with('success', 'Role berhasil ditambahkan');
    }

    public function update($id)
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');
        $db = \Config\Database::connect();
        $name = strtolower($this->request->getPost('name'));
        $exists = $db->table('roles')->where('name', $name)->where('id !=', $id)->get()->getRow();
        if ($exists) return redirect()->back()->with('error', 'Role sudah ada');
        $db->table('roles')->where('id', $id)->update(['name' => $name]);
        return redirect()->back()->with('success', 'Role berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');
        if ($id == 1) return redirect()->back()->with('error', 'Role admin tidak boleh dihapus');
        $db = \Config\Database::connect();
        $db->table('roles')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Role berhasil dihapus');
    }

    public function permissions($roleId)
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');

        $db = \Config\Database::connect();

        $role = $db->table('roles')->where('id', $roleId)->get()->getRow();

        $permissions = $db->table('permissions')
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->getResult();

        $rolePermissions = $db->table('role_permissions')
            ->where('role_id', $roleId)
            ->get()
            ->getResultArray();

        $groupedPermissions = [];
        foreach ($permissions as $p) {
            $groupedPermissions[$p->module][] = $p;
        }

        $rolePermissionIds = array_column($rolePermissions, 'permission_id');

        return view('rbac/role/permissions', [
            'role' => $role,
            'groupedPermissions' => $groupedPermissions,
            'rolePermissionIds' => $rolePermissionIds
        ]);
    }

    public function updatePermissions($roleId)
    {
        if (!hasPermission('manage_roles')) return redirect()->to('/rbac/unauthorized');

        $db = \Config\Database::connect();
        $selected = $this->request->getPost('permissions') ?? [];

        $db->table('role_permissions')->where('role_id', $roleId)->delete();

        foreach ($selected as $pid) {
            $db->table('role_permissions')->insert([
                'role_id' => $roleId,
                'permission_id' => $pid
            ]);
        }

        return redirect()->back()->with('success', 'Permission berhasil diperbarui');
    }
}
