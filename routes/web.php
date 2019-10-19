<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/upload', 'VideoUploadController@index')->name('upload.video.index');
    Route::post('/upload', 'VideoUploadController@store')->name('uploading');

    Route::post('/videos', 'VideoController@store')->name('store.video');
    Route::put('/videos/{video}', 'VideoController@update')->name('update.video');

    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit');
    Route::put('/channel/{channel}/edit', 'ChannelSettingsController@update')->name('edit.channel');
});