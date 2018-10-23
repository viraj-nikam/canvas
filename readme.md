## Canvas

A blogging package for [Laravel](https://laravel.com).

[![Build Status](https://travis-ci.org/cnvs/canvas.svg?branch=master)](https://travis-ci.org/cnvs/canvas)
[![StyleCI](https://styleci.io/repos/52815899/shield?style=flat&branch=master)](https://styleci.io/repos/52815899)
[![Latest Stable Version](https://poser.pugx.org/cnvs/canvas/v/stable)](https://packagist.org/packages/cnvs/canvas)
[![Total Downloads](https://poser.pugx.org/cnvs/canvas/downloads)](https://packagist.org/packages/cnvs/canvas)
[![License](https://poser.pugx.org/cnvs/canvas/license)](https://packagist.org/packages/cnvs/canvas)

## Documentation

You can find the documentation for Canvas on [https://cnvs.io/docs](https://cnvs.io/docs). Along with the documentation, you'll find the changelog, upgrade guide, and more.

## Installation

You can install the package via composer:

```bash
composer require cnvs/canvas
```

The package will automatically register itself.

After installing, publish its assets using the `vendor:publish` Artisan command:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="config" --tag="assets"
```

You can optionally publish the views with:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="views"
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="config"
```

The contents of the published config file:

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

## Testing

Run the tests with:

```bash
composer test
```

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).