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


Route::get('/pegumuman/items', 'PengumumansController@getData');
Route::get('/pegumuman/update', 'PengumumansController@update');
Route::get('/pegumuman/delete', 'PengumumansController@delete');
Route::get('/pegumuman/add', 'PengumumansController@add');

Route::get('/usulan/items', 'ItemUsulanController@getData');
Route::get('/usulan/update', 'ItemUsulanController@update');
Route::get('/usulan/delete', 'ItemUsulanController@delete');
Route::get('/usulan/add', 'ItemUsulanController@add');

Route::get('/opd/items', 'PODController@getData');
Route::get('/opd/update', 'PODController@update');
Route::get('/opd/delete', 'PODController@delete');
Route::get('/opd/add', 'PODController@add');

Route::get('/musrenbang-admin', function(){
    return view('musrenbang-admin');
})->middleware('admin');
Route::get('/opd', function(){
    return view('opd');
})->middleware('admin');
Route::get('/kelurahan', function(){
    return view('kelurahan');
})->middleware('admin');
Route::get('/usulan', function(){
    return view('usulan');
})->middleware('admin');
Route::get('/experiment', function () {
    return view('experiment');
});
Route::get('/', function () {
    return view('pengumuman');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', "AuthController@login");
Route::get('/logout', "AuthController@logout");
Route::post('/changepass', "AuthController@changepass");
Route::get('/testVuex', function () {
    return view('testVuex');
});
route::get('/oops',function(){
    return view('notAuthorized');
});
route::get('/test-session',function(){
    // $user = Auth::user();
    // session(['user' => $user->name]);
    return session()->all();
});
Route::get('/musrenbang', 'UsulanController@index')->middleware('user');
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
