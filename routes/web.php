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

Route::get('photo-upload', 'UploadImageController@createPhoto')->name('create.image');
Route::post('photo-upload', 'UploadImageController@storePhoto')->name('upload.image');