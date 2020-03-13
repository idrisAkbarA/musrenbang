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
    return view('pengumuman');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/musrenbang', 'UsulanController@index');
Route::get('/init', 'UsulanController@init');
Route::get('/musrenbang-test', function () {
    return view('musrenbang-test');
});
Route::post('/submitFoto','ImageController@store');
Route::post('/usul','UsulanController@store');
Route::get('/usulFilter','UsulanController@dataUsulanFilter');
Route::get('/usul','UsulanController@dataUsulan');

Route::post('/verif','UsulanController@verifikasi');
Route::post('/valid','UsulanController@validasi');
Route::post('/prioritas','UsulanController@prioritas');

Route::get('/itemPilihan','UsulanController@itemPilihan');
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
