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

        $isAjax = $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';

        if (!session('isLoggedIn')) {

            if ($isAjax) {
                return service('response')
                    ->setStatusCode(401)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Not logged in'
                    ]);
            }

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

        $method = strtolower($request->getMethod(true));
        if ($method === 'get') {
            return;
        }

        // FIX: gunakan segment ke-2 jika ada
        $resource = str_replace('-', '_', $segment1);

        if ($segment1 === 'rbac') {
            $permission = 'manage_roles';
        } elseif (in_array('approve', $segments)) {
            $permission = 'approve_pelaporan';
        } elseif (in_array('validasi', $segments)) {
            $permission = 'approve_pelaporan';
        } elseif (in_array('set-active', $segments)) {
            $permission = 'update_' . $resource;
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

            $isAjax = $request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest';

            if ($isAjax) {
                return service('response')
                    ->setStatusCode(403)
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Unauthorized',
                        'permission' => $permission
                    ]);
            }

            return redirect()->to('/rbac/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
