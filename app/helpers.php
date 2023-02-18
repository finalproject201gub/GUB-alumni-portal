<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if (!function_exists('userFullName')) {
    function userFullName(): string
    {
        return Auth::User()->name ?? '';
    }
}

if (!function_exists('routeNameMatched')) {
    function routeNameMatched($routesName, $output = 'active'): string
    {
        $routesName = Arr::wrap($routesName);
        foreach ($routesName as $routeName) {
            if (Route::currentRouteNamed($routeName)) {
                return $output;
            }
        }
        return '';
    }
}
