## Introduction

Canvas is a blogging package for [Laravel](https://laravel.com).

[![Build Status](https://travis-ci.org/cnvs/canvas.svg?branch=master)](https://travis-ci.org/cnvs/canvas)
[![StyleCI](https://styleci.io/repos/52815899/shield?style=flat&branch=master)](https://styleci.io/repos/52815899)
[![Latest Stable Version](https://poser.pugx.org/cnvs/canvas/v/stable)](https://packagist.org/packages/cnvs/canvas)
[![Total Downloads](https://poser.pugx.org/cnvs/canvas/downloads)](https://packagist.org/packages/cnvs/canvas)
[![License](https://poser.pugx.org/cnvs/canvas/license)](https://packagist.org/packages/cnvs/canvas)

## Documentation

You can find the documentation for Canvas on [https://cnvs.io/docs](https://cnvs.io/docs). Along with the documentation, you'll find the changelog, upgrade guide, and more.

## Installation

You may use composer to install Canvas into your Laravel project:

```bash
composer require cnvs/canvas
```

Publish the assets using the `canvas:install` Artisan command:

```bash
php artisan canvas:install
```

The installation will publish all public assets as well as the primary configuration file:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Blog URL
    |--------------------------------------------------------------------------
    |
    | You are free to expose the public-facing blog to any route you wish.
    | If no change is made then it will default to the /blog path of
    | your application.
    |
    */

    'blog_url' => 'blog',

];
```

After installing, you should run the also run the `migrate` command:

```bash
php artisan migrate
```

You can optionally publish the views with:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="views"
```

## Testing

Run the tests with:

```bash
composer test
```

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).