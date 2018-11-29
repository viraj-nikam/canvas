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

## Roadmap

- [X] Add useful statistics data. @austintoddj
- [ ] Provide SEO and metadata. @austintoddj
- [ ] Convert post/tag titles to slugs with a [simple Vue component](https://codepen.io/tatthien/pen/xVBxZQ).
- [ ] Add support for image uploads. @austintoddj
- [ ] Add a [QuillJS Vue component](https://pineco.de/wrapping-quill-editor-in-a-vue-component/) as the default text editor.
- [ ] Add support for [multiple tags](https://vue-multiselect.js.org/#sub-multiple-select) on a single post.
- [ ] Add post/tag filtering.

## License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).