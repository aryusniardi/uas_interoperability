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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// End-Point User
$router->get('/user','UserController@index');
$router->post('/user','UserController@store');
$router->get('/user/{id}','UserController@show');
$router->put('/user/{id}','UserController@update');
$router->delete('user/{id}','UserController@destroy');

// End-Point Petugas
$router->get('/petugas', 'PetugasController@index');
$router->post('/petugas', 'PetugasController@store');
$router->get('/petugas/{id}', 'PetugasController@show');
$router->put('/petugas/{id}', 'PetugasController@update');
$router->delete('petugas/{id}', 'PetugasController@destroy');