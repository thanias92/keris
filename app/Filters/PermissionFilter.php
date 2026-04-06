<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('rbac');

        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!$arguments || !isset($arguments[0])) {
            return;
        }

        $permission = $arguments[0];

        if (!hasPermission($permission)) {
            return redirect()->to('/rbac/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
