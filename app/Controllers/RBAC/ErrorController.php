<?php

namespace App\Controllers\RBAC;

use App\Controllers\BaseController;

class ErrorController extends BaseController
{
    public function unauthorized()
    {
        return view('rbac/errors/unauthorized');
    }
}
