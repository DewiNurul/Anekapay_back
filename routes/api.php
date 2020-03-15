<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

//admin
Route::post('admin', 'UserController@store');
Route::put('admin/{id}', 'UserController@ubah');
Route::get('admin', 'UserController@getAll');
Route::get('admin/{id}', 'UserController@show');
Route::get('login/check', 'UserController@getAuthenticatedUser');
Route::delete('admin/{id}', 'UserController@delete');

//pelanggan
Route::post('pelanggan', 'PelangganController@store');
Route::put('pelanggan/{id}', 'PelangganController@ubah');
Route::get('pelanggan', 'PelangganController@getAll');
Route::get('pelanggan/{id}', 'PelangganController@show');
Route::delete('pelanggan/{id}', 'PelangganController@delete');

//tarif
Route::post('tarif', 'TarifController@store');
Route::put('tarif/{id}', 'TarifController@ubah');
Route::get('tarif', 'TarifController@getAll');
Route::get('tarif/{id}', 'TarifController@show');
Route::delete('tarif/{id}', 'TarifController@delete');

//penggunaan
Route::post('penggunaan', 'PenggunaanController@store');
Route::put('penggunaan/{id}', 'PenggunaanController@ubah');
Route::get('penggunaan', 'PenggunaanController@getAll');
Route::get('penggunaan/{id}', 'PenggunaanController@show');
Route::delete('penggunaan/{id}', 'PenggunaanController@delete');

//tagihan
Route::post('tagihan', 'TagihanController@store');
Route::put('tagihan/{id}', 'TagihanController@ubah');
Route::get('tagihan', 'TagihanController@getAll');
Route::get('tagihan/{id}', 'TagihanController@show');
Route::delete('tagihan/{id}', 'TagihanController@delete');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
