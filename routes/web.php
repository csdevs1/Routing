<?php

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
    return view('home');
});
Route::get('/cargar/documentos', function () {
    return view('documents/upload');
});

Route::get('/list/clients', function () {
    return view('clients/show');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/exportar/vehiculos/documentos', 'AssignmentController@vehicles_page');
Route::post('/api/carga/documentos', 'AssignmentController@getFile');
Route::get('/exportar/vehiculos', 'AssignmentController@export_all');
Route::get('/api/clientes', 'ClientController@getClients');
Route::get('/exportar/vehiculos', 'AssignmentController@export_all');
Route::post('/api/save/vehicles', 'AssignmentController@save_vehicles');
