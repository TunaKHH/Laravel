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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/order', 'HomeController@order')->name('order');

Route::get('/store', 'HomeController@store')->name('store');

Route::get('/permission', 'HomeController@permission')->name('permission');

Route::get('/history', 'HomeController@history')->name('history');

Route::post('/getTheStoreAndMenuListByTheStore', 'HomeController@getTheStoreAndMenuListByTheStore');

Route::post('/getAllUsersOrderList', 'HomeController@getAllUsersOrderList');

Route::post('/setEditStoreAndMenu', 'HomeController@setEditStoreAndMenu');

Route::post('/setEditUserPermission', 'HomeController@setEditUserPermission');

Route::post('/setNewStore', 'HomeController@setNewStore');

Route::post('/setNewMenu', 'HomeController@setNewMenu');

Route::post('/setNewOrder', 'HomeController@setNewOrder');

Route::post('/setOrderLock', 'HomeController@setOrderLock');

Route::post('/setUsersOrder', 'HomeController@setUsersOrder');

Route::post('/editStore', 'HomeController@editStore');

Route::post('/delStoreAndTheMenu', 'HomeController@delStoreAndTheMenu');

Route::post('/delOrder', 'HomeController@delOrder');

Route::post('/delOneMenu', 'HomeController@delOneMenu');

Route::post('/checkStoreTel', 'HomeController@checkStoreTel');

Route::post('/checkStoreName', 'HomeController@checkStoreName');