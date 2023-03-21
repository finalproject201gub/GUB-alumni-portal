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

function generateBatchNumbers(): array
{
    $batchNumbers = [];

    $counter = 1;
    for ($i = 100; $i <= 230; $i++) {
        $batchNameDay = $i . " Day";
        $batchNameEve = $i . " Evening";

        $batchNumbers[$counter++] = $batchNameDay;
        $batchNumbers[$counter++] = $batchNameEve;

    }

    return (collect($batchNumbers)->toArray());
}

function generatePassingYears(): array
{
    $passingYears = [];

    $counter = 1;
    for ($i = 2003; $i <= now()->format('Y'); $i++) {
        $spring = $i . " Spring";
        $summer = $i . " Summer";
        $fall = $i . " Fall";

        $passingYears[$counter++] = $spring;
        $passingYears[$counter++] = $summer;
        $passingYears[$counter++] = $fall;

    }

    return (collect($passingYears)->toArray());
}

function getDepartments(): array
{
    return [
        1 => 'CSE',
        2 => 'EEE',
        3 => 'CIV',
        4 => 'BBA',
        5 => 'ENG',
        6 => 'LLB',
    ];
}
