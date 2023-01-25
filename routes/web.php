<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

function isPrime($num) {
    for ($i = 2; $i < $num; $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;  
}

function isEven($num) {
    return $num % 2 == 0;  
}

Route::get('/prime', ['middleware' => 'log', function () {
    $numbers = [];
    for ($i = 1; $i <= 10000; $i++) {
        if(isPrime($i)) {
            $numbers[] = $i;
        }
    }
    return [
        'numbers' => $numbers,
    ];
}]);

Route::get('/even', ['middleware' => 'log', function () {
    $numbers = [];
    for ($i = 1; $i <= 10000; $i++) {
        if(isEven($i)) {
            $numbers[] = $i;
        }
    }
    return [
        'numbers' => $numbers,
    ];
}]);

Route::get('/stats', function () {
    return Inertia::render('State');
});

Route::get('/client-requests', function () {
    return DB::select("
        SELECT
            path,
            strftime('%m-%d-%Y',created_at) AS `date`,
            count(*) as count
        FROM
            client_requests
        WHERE
            created_at < DATE('now') AND
            created_at > DATE('now', '-1 year')
        GROUP BY
            path,
            strftime('%m-%d-%Y',created_at)
        ORDER BY
            created_at ASC
    ");
});