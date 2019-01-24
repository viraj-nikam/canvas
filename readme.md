## Introduction

[![Build Status](https://travis-ci.org/cnvs/canvas.svg?branch=master)](https://travis-ci.org/cnvs/canvas)
[![Total Downloads](https://poser.pugx.org/cnvs/canvas/downloads)](https://packagist.org/packages/cnvs/canvas)
[![Latest Stable Version](https://poser.pugx.org/cnvs/canvas/v/stable)](https://packagist.org/packages/cnvs/canvas)
[![License](https://poser.pugx.org/cnvs/canvas/license)](https://packagist.org/packages/cnvs/canvas)

A [Laravel](https://laravel.com) publishing platform.

## Installation

> **Note:** Canvas requires you to have user authentication in place prior to installation. You may run the `make:auth` Artisan command to satisfy this requirement.

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
    | Public Path
    |--------------------------------------------------------------------------
    |
    | You are free to expose the public-facing blog to any route you wish.
    | If no change is made then it will default to the /blog path of
    | your application.
    |
    */

    'public_path' => env('CANVAS_PUBLIC_PATH', 'blog'),

    /*
    |--------------------------------------------------------------------------
    | Route Middleware
    |--------------------------------------------------------------------------
    |
    | You may assign any custom middleware that you choose to the /canvas
    | routes in your application. They will be protected by basic
    | user authentication by default.
    |
    */

    'middleware' => [
        'web',
        'auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Uploads Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Canvas will use to put file uploads, you can use
    | any of the disks defined in your config/filesystems.php file. You may
    | also configure the path where the files should be stored.
    |
    */

    'storage_disk' => env('CANVAS_STORAGE_DISK', 'local'),

    'storage_path' => env('CANVAS_STORAGE_PATH', 'public/canvas/images'),

];
```

You can optionally publish the views with:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="canvas-views"
```

## Updates

You may update your Canvas installation using composer:

```bash
composer update
```

Run any new migrations using the `migrate` Artisan command:

```bash
php artisan migrate
```

You may also want to run this command to re-publish the assets:

```bash
php artisan vendor:publish --tag=canvas-assets --force
```

## Testing

Run the tests with:

```bash
composer test
```

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).