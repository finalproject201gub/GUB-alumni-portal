<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('userFullName')) {
    function userFullName(): string
    {
        return Auth::User()->name ?? '';
    }
}
