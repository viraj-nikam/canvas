var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

       mix.less('landing/landing.less');
       mix.less('admin/admin.less');
       mix.less('blog/blog.less');
       mix.less('auth/auth.less');

       mix.copy('resources/assets/images','public/images');

});
