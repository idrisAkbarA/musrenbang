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
Route::get('/musrenbang-admin', function(){
    return view('musrenbang-admin');
});
Route::get('/experiment', function () {
    return view('experiment');
});
Route::get('/', function () {
    return view('pengumuman');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/testVuex', function () {
    return view('testVuex');
});
Route::get('/musrenbang', 'UsulanController@index');
Route::get('/init', 'UsulanController@init');
Route::get('/musrenbang-test', function () {
    return view('musrenbang-test');
});
Route::post('/submitFoto','ImageController@store');
Route::post('/submitFiles','FilesController@store');
Route::post('/usul','UsulanController@store');
Route::get('/usulFilter','UsulanController@dataUsulanFilter');
Route::get('/usul','UsulanController@dataUsulan');
Route::post('/usul/hapus','UsulanController@hapus');
Route::post('/usul/update','UsulanController@update');
Route::get('/usul/testFilter','UsulanController@testFilter');

Route::post('/verifikasi','UsulanController@verifikasi');
Route::post('/validasi','UsulanController@validasi');
Route::post('/prioritas','UsulanController@prioritas');

Route::get('/itemPilihan','UsulanController@itemPilihan');
//Auth::routes();

Route::get('/exp',function(){
    $arr =["Usulan"=>"Makan","Pengusul"=>"idris","alamat"=>"swadaya"];
    $arrFinal = [];
    foreach ($arr as $key => $value) {
        $arrTemp = [];
        array_push($arrTemp,"$key");
        array_push($arrTemp,"like");
        array_push($arrTemp,"%$value%");
        array_push($arrFinal,$arrTemp);
    }
    return $arrFinal;
    return $arr;
});
Route::get('/home', 'HomeController@index')->name('home');
