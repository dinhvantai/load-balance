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


Route::group(['domain' => env('DOMAIN_ADMIN'), 'namespace' => 'Api\Admin', 'prefix' => 'v0'], function() {
    Route::middleware('auth:api')->get('user', function (Request $request) {
        return $request->user();
    });
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::group(['middleware' => 'api_auth_admin'], function(){
        $methodAllow = ['index', 'show', 'store', 'update', 'destroy'];

        Route::resource('menus', 'MenuController')->only($methodAllow);
        Route::resource('categories', 'CategoryController')->only($methodAllow);
        Route::resource('products', 'ProductController')->only($methodAllow);
        Route::resource('posts', 'PostController')->only($methodAllow);
        Route::resource('banners', 'BannerController')->only($methodAllow);

        Route::post('upload-image', 'MediaController@uploadImage');

        Route::get('setups', 'ExtraController@getSetup');
        Route::put('setups', 'ExtraController@putSetup');

        Route::put('change-password', 'UserController@changePassword');
    });
});


Route::group(['domain' => env('DOMAIN_USER'), 'namespace' => 'Api\User', 'prefix' => 'v0'], function() {
    Route::get('sliders', 'BannerController@getSlider');
});