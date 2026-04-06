<?php

function hasPermission($name)
{
    $session = session();
    $user = $session->get('user');

    if (!$user || !isset($user['role_id'])) return false;

    static $cache = [];
    $roleId = $user['role_id'];

    if (!isset($cache[$roleId])) {
        $db = \Config\Database::connect();

        $rows = $db->table('role_permissions rp')
            ->select('p.name')
            ->join('permissions p', 'p.id = rp.permission_id')
            ->where('rp.role_id', $roleId)
            ->get()
            ->getResultArray();

        $cache[$roleId] = array_column($rows, 'name');
    }

    return in_array($name, $cache[$roleId]);
}

function can($p)
{
    return hasPermission($p);
}
