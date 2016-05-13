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

    mix.less('landing.less')
       .less('admin.less')
       .less('blog.less')
       .less('auth.less')

       .scriptsIn('resources/assets/js')
       .scriptsIn('resources/assets/vendor')
       .version(['css/landing.css', 'css/auth.css', 'css/blog.css', 'js/all.js']);

});
