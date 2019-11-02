<?php


Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/videos/{video}', 'VideoController@show')->name('show.video');

Route::post('/videos/{video}/views', 'VideoViewController@create')->name('create.video.view');

Route::get('/search', 'SearchController@index')->name('search.inddex');

Route::get('/videos/{video}/votes', 'VideoVoteController@show')->name('video.votes.show');

Route::get('/videos/{video}/comments', 'VideoCommentController@index')->name('video.comments.index');
Route::get('/subscription/{channel}', 'ChannelSubscriptionController@show')->name('video.subscribe.show');
Route::get('/channel/{channel}', 'ChannelController@show')->name('video.channel.show');

Route::post('/webhook/encoding', 'EncodingWebhookController@handle');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/upload', 'VideoUploadController@index')->name('upload.video.index');
    Route::post('/upload', 'VideoUploadController@store')->name('uploading');

    Route::get('/videos', 'VideoController@index')->name('user.videos.index');
    Route::get('/videos/{video}/edit', 'VideoController@edit')->name('user.video.edit');
    Route::post('/videos', 'VideoController@store')->name('store.video');
    Route::put('/videos/{video}', 'VideoController@update')->name('update.video');
    Route::delete('/videos/{video}', 'VideoController@delete')->name('delete.video');

    Route::get('/channel/{channel}/edit', 'ChannelSettingsController@edit');
    Route::put('/channel/{channel}/edit', 'ChannelSettingsController@update')->name('edit.channel');

    Route::post('/videos/{video}/votes', 'VideoVoteController@create')->name('video.votes.create');
    Route::delete('/videos/{video}/votes', 'VideoVoteController@remove')->name('video.votes.remove');  

    Route::post('/videos/{video}/comments', 'VideoCommentController@create')->name('video.comments.create');
    Route::delete('/videos/{video}/comments/{comment}', 'VideoCommentController@delete')->name('video.comments.delete');

    Route::post('/subscription/{channel}', 'ChannelSubscriptionController@create')->name('video.subscribe.create');
    Route::delete('/subscription/{channel}', 'ChannelSubscriptionController@delete')->name('video.subscribe.delete');
});