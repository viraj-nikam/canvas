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

       mix.less('blog/blog.less');
       mix.less('auth/auth.less');
       mix.less('admin/admin.less');
       mix.less('landing/landing.less');

       mix.scripts('blog.js');
       mix.scripts('login.js');
       mix.scripts('admin.js');
       mix.scripts('landing.js');

       // Raw CSS
       mix.copy('resources/assets/css/chosen.min.css', 'public/css/chosen.min.css');
       mix.copy('resources/assets/css/summernote.css', 'public/css/summernote.css');
       mix.copy('resources/assets/css/jquery.bootgrid.min.css', 'public/css/jquery.bootgrid.min.css');
       mix.copy('resources/assets/css/lightgallery.css', 'public/css/lightgallery.css');
       mix.copy('resources/assets/css/bootstrap-select.min.css', 'public/css/bootstrap-select.min.css');
       mix.copy('resources/assets/css/jquery.mCustomScrollbar.min.css', 'public/css/jquery.mCustomScrollbar.min.css');
       mix.copy('resources/assets/css/material-design-iconic-font.min.css', 'public/css/material-design-iconic-font.min.css');
       mix.copy('resources/assets/css/animate.min.css', 'public/css/animate.min.css');
       mix.copy('resources/assets/css/sweet-alert.min.css', 'public/css/sweet-alert.min.css');
       mix.copy('resources/assets/css/custom.css', 'public/css/custom.css');
       mix.copy('resources/assets/css/app-1.css', 'public/css/app-1.css');
       mix.copy('resources/assets/css/app-2.css', 'public/css/app-2.css');

       // Raw JS
       mix.copy('resources/assets/js/bootstrap-select.min.js', 'public/js/bootstrap-select.min.js');
       mix.copy('resources/assets/js/jquery.mask.min.js', 'public/js/jquery.mask.min.js');
       mix.copy('resources/assets/js/chosen.jquery.min.js', 'public/js/chosen.jquery.min.js');
       mix.copy('resources/assets/js/moment.min.js', 'public/js/moment.min.js');
       mix.copy('resources/assets/js/summernote.min.js', 'public/js/summernote.min.js');
       mix.copy('resources/assets/js/jquery.bootgrid.min.js', 'public/js/jquery.bootgrid.min.js');
       mix.copy('resources/assets/js/autosize.min.js', 'public/js/autosize.min.js');
       mix.copy('resources/assets/js/lightgallery.min.js', 'public/js/lightgallery.min.js');
       mix.copy('resources/assets/js/sweet-alert.min.js', 'public/js/sweet-alert.min.js');
       mix.copy('resources/assets/js/waves.min.js', 'public/js/waves.min.js');
       mix.copy('resources/assets/js/jquery.mCustomScrollbar.concat.min.js', 'public/js/jquery.mCustomScrollbar.concat.min.js');
       mix.copy('resources/assets/js/bootstrap.min.js', 'public/js/bootstrap.min.js');
       mix.copy('resources/assets/js/jquery.min.js', 'public/js/jquery.min.js');
       mix.copy('resources/assets/js/functions.js', 'public/js/functions.js');
       mix.copy('resources/assets/js/bootstrap-growl.min.js', 'public/js/bootstrap-growl.min.js');

       // Images
       mix.copy('resources/assets/images', 'public/images');

       // Fonts
       mix.copy('resources/assets/fonts/', 'public/fonts');
       mix.copy('resources/assets/fonts/summernote.ttf', 'public/css/font/summernote.ttf');
       mix.copy('resources/assets/fonts/summernote.woff', 'public/css/font/summernote.woff');

});
