<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Canvas\Http\Controllers')->group(function () {
    Route::middleware(['web'])->prefix('blog')->group(function () {
        // Blog Routes...
        Route::get('/', 'BlogController@index')->name('blog.index');
        Route::get('/{post}', 'PostController@show')->name('blog.post.show');
        Route::get('/tag/{tag}', 'TagController@show')->name('blog.tag.show');
    });

    Route::middleware(['web', 'auth'])->prefix('canvas')->group(function () {
        // Dashboard Routes...
        Route::get('/', 'CanvasController@index')->name('canvas.index');

        // Post Routes...
        Route::prefix('posts')->group(function () {
            Route::get('/', 'PostController@index')->name('canvas.post.index');
            Route::get('create', 'PostController@create')->name('canvas.post.create');
            Route::post('/', 'PostController@store')->name('canvas.post.store');
            Route::get('/{id}/edit', 'PostController@edit')->name(('canvas.post.edit'));
            Route::put('/{id}', 'PostController@update')->name('canvas.post.update');
            Route::delete('/{id}', 'PostController@destroy')->name('canvas.post.destroy');
        });
    });
});
