const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

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

var assetsPath = 'public/assets/';

elixir(function (mix) {

    // Sass Files
    mix.sass('frontend/frontend.scss', assetsPath + 'css/');
    mix.sass('backend/backend.scss', assetsPath + 'css/');
    mix.sass('../talvbansal/media-manager/css/media-manager.css', assetsPath + 'css/');

    // Frontend JS Files
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'frontend/**/*.js'
    ], assetsPath + 'js/frontend.js');

    // Vendor JS Files
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'moment.min.js',
        'simplemde.min.js',
        'autosize.min.js',
        'bootstrap-select.js',
        'jquery.mask.min.js',
        'chosen.jquery.min.js',
        'jquery.bootgrid.min.js',
        'lightgallery.min.js',
        'sweet-alert.min.js',
        'waves.js',
        'jsvalidation.js',
        'jquery.mCustomScrollbar.concat.min.js',
        'fileinput.min.js',
        'bootstrap-datetimepicker.min.js',
        '../talvbansal/media-manager/js/media-manager.js'
    ], assetsPath + 'js/vendor.js');

    // Application JS Files
    mix.scripts([
        'functions.js',
        'bootstrap-growl.min.js'
    ], assetsPath + 'js/app.js');

    // copy Favicon
    mix.copy('resources/assets/favicon.ico', assetsPath);

    // copy Images
    mix.copy('resources/assets/images', assetsPath + 'images');

    // copy Fonts
    mix.copy(['resources/assets/fonts', 'resources/assets/talvbansal/media-manager/fonts'], assetsPath + '/fonts');

    // versioning css files
    mix.version([
            // css files
            assetsPath + 'css/frontend.css',
            assetsPath + 'css/backend.css',

            // js
            assetsPath + 'js/frontend.js',
            assetsPath + 'js/vendor.js',
            assetsPath + 'js/app.js'
        ]);

    // Run unit tests on code base if in production mode
    if (elixir.config.production) {
        mix.phpUnit();
    }
});
