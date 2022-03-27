<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Artsan Command Routes
Route::get('/config-clear', function () {
    $status = Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});
Route::get('/cache-clear', function () {
    $status = Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});
Route::get('/config-cache', function () {
    $status = Artisan::call('config:Cache');
    return '<h1>Configurations cache cleared</h1>';
});
Route::get('/route-clear', function () {
    $status = Artisan::call('route:clear');
    return '<h1>Routes cache cleared</h1>';
});
