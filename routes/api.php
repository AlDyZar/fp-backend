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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('', function (){
    return 'hello world';
});
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::apiResource('items', 'ItemController')->only(['index', 'show']);

Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@me');
    Route::apiResource('cart', 'CartController')->except(['show']);
    Route::get('pay', 'VtwebController@vtweb');
});
