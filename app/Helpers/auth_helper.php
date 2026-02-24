<?php

if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool
    {
        return session()->get('isLoggedIn') === true;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return session()->get('user_role') === 'admin';
    }
}

if (!function_exists('isOperator')) {
    function isOperator(): bool
    {
        return session()->get('user_role') === 'operator';
    }
}

if (!function_exists('currentUserName')) {
    function currentUserName(): ?string
    {
        return session()->get('user_name');
    }
}
