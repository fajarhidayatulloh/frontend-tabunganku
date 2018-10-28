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

	//Tabungan
	Route::get('/tabungan', 'Pemasukan\PemasukanController@index');
	Route::get('/pemasukan/list/{dt}', 'Pemasukan\PemasukanController@listPemasukan');
	Route::get('/tabungan/input', 'Pemasukan\PemasukanController@input');
	Route::post('/pemasukan/store', 'Pemasukan\PemasukanController@store');

	//pengeluaran
	Route::get('/pengeluaran', 'Pengeluaran\PengeluaranController@index');
	Route::get('/pengeluaran/list/{dt}', 'Pengeluaran\PengeluaranController@listPengeluaran');
	Route::get('/pengeluaran/input', 'Pengeluaran\PengeluaranController@input');
	Route::post('/pengeluaran/store', 'Pengeluaran\PengeluaranController@store');

	//tabungan qurban
	Route::get('/tabungan/qurban', 'Qurban\QurbanController@index');
	Route::get('/tabungan/qurban/list/{dt}', 'Qurban\QurbanController@listQurban');
	Route::get('/tabungan/qurban/input', 'Qurban\QurbanController@input');
	Route::post('/tabungan/qurban/store', 'Qurban\QurbanController@store');

});
