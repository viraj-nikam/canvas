<?php
/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@index');

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
*/

Route::get('blog', 'BlogController@index');
Route::get('blog/{slug}', 'BlogController@showPost');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('admin', function () {
  return redirect('/admin/post');
});

$router->group([
  'namespace' => 'Admin',
  'middleware' => 'auth',
], function () {
  Route::resource('admin/post', 'PostController', ['except' => 'show']);
  Route::resource('admin/tag', 'TagController', ['except' => 'show']);
  Route::get('admin/upload', 'UploadController@index');
  Route::post('admin/upload/file', 'UploadController@uploadFile');
  Route::delete('admin/upload/file', 'UploadController@deleteFile');
  Route::post('admin/upload/folder', 'UploadController@createFolder');
  Route::delete('admin/upload/folder', 'UploadController@deleteFolder');
});

/*
|--------------------------------------------------------------------------
| Logging In/Out Routes
|--------------------------------------------------------------------------
*/

Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

/*
|--------------------------------------------------------------------------
| RSS Feed
|--------------------------------------------------------------------------
*/

Route::get('rss', 'BlogController@rss');