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

Route::group(['domain' => env('DOMAIN_ADMIN')], function(){
    Route::get('/', function () { return view('admin.index'); });
});

Route::group([
    'domain' => env('DOMAIN_USER'),
    'namespace' => 'User'
], function(){
    Route::get('/', 'HomeController@index')->name('user.index');
    Route::get('/search', 'HomeController@search')->name('user.search');
    Route::get('/posts', 'HomeController@listPost')->name('user.post.list');
    Route::get('/post/{slug}', 'HomeController@detailPost')->name('user.post.detail');
    Route::get('/product/{slug}', 'HomeController@detailProduct')->name('user.product.detail');
    Route::get('/{parent}', 'HomeController@categoryParent')->name('user.category.parent');
    Route::get('/{parent}/{children}', 'HomeController@categoryChildren')
        ->name('user.category.children');
});
