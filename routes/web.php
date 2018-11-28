<?php

use Illuminate\Support\Facades\Route;

// Blog Routes...
Route::get('/', 'BlogController@index')->name('blog.index');
Route::middleware('Canvas\Http\Middleware\ViewThrottle')->get('/{slug}', 'PostController@show')->name('blog.post.show');
Route::get('/tag/{slug}', 'TagController@show')->name('blog.tag.index');
