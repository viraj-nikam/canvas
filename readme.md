## Introduction

A [Laravel](https://laravel.com) publishing platform.

[![Build Status](https://travis-ci.org/cnvs/canvas.svg?branch=master)](https://travis-ci.org/cnvs/canvas)
[![StyleCI](https://styleci.io/repos/52815899/shield?style=flat&branch=master)](https://styleci.io/repos/52815899)
[![Latest Stable Version](https://poser.pugx.org/cnvs/canvas/v/stable)](https://packagist.org/packages/cnvs/canvas)
[![Total Downloads](https://poser.pugx.org/cnvs/canvas/downloads)](https://packagist.org/packages/cnvs/canvas)
[![License](https://poser.pugx.org/cnvs/canvas/license)](https://packagist.org/packages/cnvs/canvas)

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

You may use composer to update your current version of Canvas:

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

## Roadmap

- [X] Add useful statistics data. @austintoddj
- [X] Provide SEO and metadata. @austintoddj
- [X] Convert post/tag titles to slugs with a [simple Vue component](https://codepen.io/tatthien/pen/xVBxZQ). @austintoddj
- [ ] Add support for image uploads. @austintoddj
- [ ] Add [QuillJS](https://quilljs.com/guides/cloning-medium-with-parchment/) as the default editor.
- [ ] Add support for [multiple tags](https://vue-multiselect.js.org/#sub-multiple-select) on a single post. @austintoddj
- [ ] Add post/tag filtering.

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).