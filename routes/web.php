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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'home'], function () {
   
    Route::post('/products', 'ProductsController@store')->middleware('permission:products-create');
    Route::get('/products/{id}', 'ProductsController@show')->middleware('permission:products-read');
    Route::post('/products/update-form/{id}', 'ProductsController@updateForm')->middleware('permission:products-update');
    Route::delete('/products/delete', 'ProductsController@destroy')->middleware('permission:products-delete');
    Route::get('/products', 'ProductsController@getProducts')->middleware('permission:users-read')->name('get.products');
    Route::post('/products/filtered', 'ProductsController@filtered')->middleware('permission:users-read')->name('filtered.products');

    Route::get('/orders/get', 'OrdersController@get')->middleware('permission:orders-read')->name('get.orders');
    Route::post('/orders/store', 'OrdersController@store')->middleware('permission:orders-create')->name('store.orders');
 
    Route::get('/manage-users', 'UserController@getUsers')->middleware('permission:users-read')->name('get.users');
    Route::post('/manage-users/store', 'UserController@store')->middleware('permission:users-create')->name('store.users');
    Route::get('/manage-users/show', 'UserController@show')->middleware('permission:users-read')->name('show.user');
    Route::post('/manage-users/update', 'UserController@update')->middleware('permission:users-update')->name('update.users');

    Route::get('/manage-permissions', 'PermissionsController@getPermissions')->middleware('permission:permissions-read')->name('get.permissions');
    Route::post('/manage-permissions/store', 'PermissionsController@store')->middleware('permission:permissions-create')->name('store.permissions');
    Route::get('/manage-permissions/show', 'PermissionsController@show')->middleware('permission:permissions-read')->name('show.permissions');
    Route::post('/manage-permissions/update', 'PermissionsController@update')->middleware('permission:permissions-update')->name('update.permissions');
});

