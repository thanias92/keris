<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AutoPermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('rbac');

        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // ambil segment pertama (LEBIH AMAN)
        $uri = $request->getUri();

        $segment = $uri->getSegment(1);
        $segments = $uri->getSegments();

        log_message('error', 'SEGMENT: ' . $segment);

        if (!$segment) {
            return;
        }

        // kalau root (dashboard) → skip
        if (!$segment) {
            return;
        }

        //  whitelist
        $whitelist = [
            'login',
            'logout',
            'rbac',
            'dashboard'
        ];

        if (in_array($segment, $whitelist)) {
            return;
        }

        $method = strtolower($request->getMethod());

        $resource = str_replace('-', '_', $segment);

        // SPECIAL CASE
        if ($segment === 'rbac') {
            $permission = 'manage_roles';
        } elseif (in_array('approve', $segments)) {
            $permission = 'approve_pelaporan';
        } elseif (in_array('validasi', $segments)) {
            $permission = 'approve_pelaporan';
        } elseif (in_array('set-active', $segments)) {
            $permission = 'update_pelaporan';
        } else {
            $actionMap = [
                'get' => 'view',
                'post' => 'create',
                'put' => 'update',
                'delete' => 'delete'
            ];

            $action = $actionMap[$method] ?? 'view';
            $permission = $action . '_' . $resource;
        }

        if (!hasPermission($permission)) {
            return redirect()->to('/rbac/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
