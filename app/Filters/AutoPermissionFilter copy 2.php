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

        $uri = $request->getUri();
        $segments = $uri->getSegments();

        $segment1 = $segments[0] ?? '';
        $segment2 = $segments[1] ?? '';

        if (!$segment1) {
            return;
        }

        $whitelist = [
            'login',
            'logout',
            'rbac',
            'dashboard'
        ];

        if (in_array($segment1, $whitelist)) {
            return;
        }

        $method = strtolower($request->getMethod());
        if ($method === 'get' && count($segments) === 2) {
            return;
        }

        // FIX: gunakan segment ke-2 jika ada
        $resource = $segment2 ? $segment2 : $segment1;
        $resource = str_replace('-', '_', $resource);

        if ($segment1 === 'rbac') {
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
