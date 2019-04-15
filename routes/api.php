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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');

Route::group(['middleware' => ['jwt.verify']], function() {
    
    //rutas de user controller
    Route::get('user', 'UserController@getAuthenticatedUser');
    //rutas de companycontroller
    Route::get('company', 'CompanyController@index');
    Route::get('company/{id}', 'CompanyController@show');
    Route::post('company', 'CompanyController@store');
    //rutas de locationController
    Route::get('location/{company_id}', 'LocationController@index');
    Route::post('location', 'LocationController@store');
    //rutas de AssetsController
    Route::get('asset/{id}', 'AssetsController@show'); 
    Route::get('company/{company_id}/asset', 'AssetsController@index'); 
    Route::get('assets_of_location/{location_id}', 'AssetsController@assets_of_location');
    Route::post('asset', 'AssetsController@store');
    Route::put('asset/{id}', 'AssetsController@update'); 
    Route::delete('asset/{id}', 'AssetsController@destroy'); 
    //rutas de TypesController
    Route::get('types/{user_id}', 'TypeController@index'); 
});
