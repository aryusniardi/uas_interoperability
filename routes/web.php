<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route as Route;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// User Authentication
Route::group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/user/register', 'Auth\\UserAuthController@register');
    $router->post('/user/login', 'Auth\\UserAuthController@login');
    $router->post('/user/logout', 'Auth\\UserAuthController@logout');
});

// Petugas Authentication
Route::group(['prefix' => 'auth'], function() use ($router) {
    $router->post('/petugas/register', 'Auth\\PetugasAuthController@register');
    $router->post('/petugas/login', 'Auth\\PetugasAuthController@login');
    $router->post('/petugas/logout', 'Auth\\PetugasAuthController@logout');
});

// Authorized Routes
Route::group(['middleware' => ['auth']], function ($router) {
    // Petugas End-Point
    $router->get('/petugas', 'PetugasController@index');
    $router->get('/petugas/{id}', 'PetugasController@show');
    $router->put('/petugas/{id}', 'PetugasController@update');
    $router->delete('petugas/{id}', 'PetugasController@destroy');
    
    // User End-Point
    $router->get('/user', 'UserController@index');
    $router->get('/user/{id}', 'UserController@show');
    $router->put('/user', 'UserController@update');
    $router->delete('/user/{id}', 'UserController@destroy');

    // Keluhan End-Point
    $router->post('/keluhan', 'KeluhanController@store');
    $router->get('/keluhan', 'KeluhanController@index');
    $router->get('/keluhan/{id}', 'KeluhanController@show');
    $router->delete('/keluhan/{id}', 'KeluhanController@destroy');

    // Saran End-Point
    $router->post('/saran', 'SaranController@store');
    $router->get('/saran', 'SaranController@index');
    $router->get('/saran/{id}', 'SaranController@show');
    $router->delete('/saran/{id}', 'SaranController@destroy');

    // Tanggapan End-Point
    $router->post('/tanggapan', 'TanggapanController@store');
    $router->put('/tanggapan/{id}', 'TanggapanController@update');
    $router->delete('tanggapan/{id}', 'TanggapanController@destroy');
});

// Public Route
$router->get('/public/tanggapan', 'TanggapanController@index');
$router->get('/public/tanggapan/{id}', 'TanggapanController@show');

$router->get('/public/saran', 'SaranController@index');
$router->get('/public/saran/{id}', 'SaranController@show');