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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'RegisterController@register');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->middleware('auth:api');
    });
    Route::post('forgot_password', 'ProfileController@forgotPassword');

    Route::get('categories', 'HomeController@categories');
    Route::get('offers', 'HomeController@offers');
    Route::get('gifts', 'HomeController@gifts');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('my_gifts', 'HomeController@myGifts');
        Route::get('profile', 'ProfileController@profile');
        Route::post('update_profile', 'ProfileController@update');
        Route::post('update_password', 'ProfileController@updatePassword');
    });
});

