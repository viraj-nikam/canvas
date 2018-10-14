<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Canvas\Http\Controllers')->group(function () {
    Route::middleware(['web'])->prefix('blog')->group(function () {
        // Homepage Routes...
        Route::get('/', 'HomeController@index')->name('blog.index');
    });

    Route::middleware(['web', 'auth'])->prefix('canvas')->group(function () {
        // Dashboard Routes...
        Route::get('/', 'DashboardController@index')->name('canvas.index');

        // Post Routes...
        Route::prefix('posts')->group(function () {
            Route::get('/', 'PostController@index')->name('canvas.posts.index');
            Route::get('create', 'PostController@create')->name('canvas.posts.create');
            Route::post('/', 'PostController@store')->name('canvas.posts.store');
            Route::get('/{id}/edit')->name(('canvas.posts.edit'));
            Route::put('/{id}')->name('canvas.posts.update');
            Route::delete('/{id}')->name('canvas.posts.destroy');
        });
    });
});
