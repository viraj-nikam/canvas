<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    // Stats routes...
    Route::get('/stats', 'StatsController@index');
    Route::get('/stats/{id}', 'StatsController@show');

    // Post routes...
    Route::get('/posts', 'PostController@index');
    Route::get('/posts/create', 'PostController@create');
    Route::post('/posts', 'PostController@store');
    Route::get('/posts/{id}/edit', 'PostController@edit');
    Route::put('/posts/{id}', 'PostController@update');
    Route::delete('/posts/{id}', 'PostController@destroy');

    // Media routes...
    Route::post('/media/uploads', 'MediaController');

    // Tag routes...
    Route::get('/tags', 'TagController@index');
    Route::get('/tags/create', 'TagController@create');
    Route::post('/tags', 'TagController@store');
    Route::get('/tags/{id}/edit', 'TagController@edit');
    Route::put('/tags/{id}', 'TagController@update');
    Route::delete('/tags/{id}', 'TagController@destroy');

    // Topic routes...
    Route::get('/topics', 'TopicController@index');
    Route::get('/topics/create', 'TopicController@create');
    Route::post('/topics', 'TopicController@store');
    Route::get('/topics/{id}/edit', 'TopicController@edit');
    Route::put('/topics/{id}', 'TopicController@update');
    Route::delete('/topics/{id}', 'TopicController@destroy');
});

// Catch-all routes...
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('canvas');
