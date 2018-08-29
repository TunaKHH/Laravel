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

Route::post('/getTheStoreAndMenuListByTheStore', 'HomeController@getTheStoreAndMenuListByTheStore');

Route::post('/setEditStoreAndMenu', 'HomeController@setEditStoreAndMenu');

Route::post('/setNewStore', 'HomeController@setNewStore');

Route::post('/setNewMenu', 'HomeController@setNewMenu');

Route::post('/setNewOrder', 'HomeController@setNewOrder');

Route::post('/setOrderLock', 'HomeController@setOrderLock');

Route::post('/editStore', 'HomeController@editStore');

Route::post('/delStoreAndTheMenu', 'HomeController@delStoreAndTheMenu');

Route::post('/delOrder', 'HomeController@delOrder');

Route::post('/checkStoreTel', 'HomeController@checkStoreTel');

Route::post('/checkStoreName', 'HomeController@checkStoreName');