<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['usuarios']], function () {
    Route::post('login','api\AuthenticationController@authenticate');
    Route::post('register','api\AuthenticationController@register');
    Route::get('user','api\AuthenticationController@get_user_info');
    Route::post('packertest', 'AsignacionController@pack');
    Route::get('export/{param}', 'AssignmentController@export_xls')->where('param', '[0-9]+');
    Route::post('getassignment','api\AssignmentController@GetAsignacion');
});
Route::post('/save/products', 'AssignmentController@save_products');
