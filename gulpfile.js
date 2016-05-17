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

    mix.less('landing/landing.less')
       .less('admin/admin.less')
       .less('blog/blog.less')
       .less('auth/auth.less')

       .scriptsIn('resources/assets/js')
       .scriptsIn('resources/assets/vendor')
       .version(['css/landing.css', 'css/admin.css', 'css/blog.css','css/auth.css', 'js/all.js']);

});
