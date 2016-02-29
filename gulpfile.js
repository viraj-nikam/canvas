var elixir = require('laravel-elixir');

/**
 * Default gulp is to run this elixir stuff
 */
elixir(function(mix) {

    mix.scripts([
        'js/jquery.js',
        'js/bootstrap.js',
        'js/jquery.dataTables.js',
        'js/dataTables.bootstrap.js'
    ], 'public/assets/js/admin.js', 'resources//assets');

    mix.scripts([
        'js/jquery.js',
        'js/bootstrap.js',
        'js/blog.js'
    ], 'public/assets/js/blog.js', 'resources//assets');

    mix.less('home.less', 'public/assets/css/home.css');
    mix.less('admin.less', 'public/assets/css/admin.css');
    mix.less('blog.less', 'public/assets/css/blog.css');
});