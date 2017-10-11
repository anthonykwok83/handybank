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

Route::get('/', 'IndexController@index');
Route::post('/reset_database', 'IndexController@resetDatabase');
Route::get('/open_account', 'IndexController@openAccount');
Route::get('/close_account', 'IndexController@closeAccount');
Route::get('/get_current_balance', 'IndexController@getCurrentBalance');
Route::get('/withdraw_money', 'IndexController@withdrawMoney');
Route::get('/deposit_money', 'IndexController@depositMoney');
Route::get('/transfer_money', 'IndexController@transferMoney');