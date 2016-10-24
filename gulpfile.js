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

elixir(function (mix) {

    // Sass Files
    // Sass Files
    mix.sass([
            'frontend/frontend.scss',
            'backend/backend.scss',
            '../talvbansal/media-manager/css/media-manager.css'
        ])
        // Copy Media Manager SVG images into the public directory
        .copy( 'resources/assets/talvbansal/media-manager/fonts', 'public/fonts' )
        .version([
            'css/frontend.css',
            'css/backend.css',
            'css/media-manager.css',
            'public/fonts'
        ])

    // Frontend JS Files
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'frontend/**/*.js'
    ], 'public/js/frontend.js');

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
    ], 'public/js/vendor.js');

    // Application JS Files
    mix.scripts([
        'functions.js',
        'bootstrap-growl.min.js'
    ], 'public/js/app.js');
});
