<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::apiResources(['users' => 'UserController', 'books' => 'BookController']);

Route::put('users/{email}/password', 'UserController@updatePassword');

Route::post('books/{id}/image', 'BookController@updateImage');

Route::group([

    'prefix' => 'auth',
    'as' => 'auth.'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::apiResource('userBooks', 'UserProductController');