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

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'Pemasukan\PemasukanController@index');

Route::get('login', 'User\UserController@getLogin');
Route::get('registration', 'User\UserController@getRegister');
Route::post('registration/proses', 'User\UserController@postRegistration');
Route::post('login/proses', 'User\UserController@postLogin');
Route::group(['middleware' => 'tabungan.auth'], function () {
	Route::get('/', 'Home\HomeController@index');
	Route::get('/logout', 'User\UserController@logout');

	//pemasukan
	Route::get('/pemasukan', 'Pemasukan\PemasukanController@index');

	//pengeluaran
	Route::get('/pengeluaran', 'Pengeluaran\PengeluaranController@index');

	//tabungan qurban
	Route::get('/tabungan/qurban', 'Qurban\QurbanController@index');

});
