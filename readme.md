<p align="center">
    <br>
    <img src="https://raw.githubusercontent.com/cnvs/art/master/github-header.png" width="500">
</p>

<p align="center">
	<a href="https://travis-ci.org/cnvs/canvas"><img src="https://travis-ci.org/cnvs/canvas.svg?branch=master"></a>
	<a href="https://packagist.org/packages/cnvs/canvas"><img src="https://poser.pugx.org/cnvs/canvas/downloads"></a>
	<a href="https://packagist.org/packages/cnvs/canvas"><img src="https://poser.pugx.org/cnvs/canvas/v/stable"></a>
	<a href="https://packagist.org/packages/cnvs/canvas"><img src="https://poser.pugx.org/cnvs/canvas/license"></a>
    <br>
</p>

## Introduction

A [Laravel](https://laravel.com) publishing platform. Canvas is a fully open source package to extend your 
application and get you up-and-running with a blog in just a few minutes. In addition to a distraction-free 
writing experience, you can view monthly trends on your content, get insights into reader traffic and more!

<img src="https://cnvs.io/img/zDTOCfMeOf2pr1sHax9KqNzWsnF8KOa55CPPyppc.png">

## Installation

> **Note:** Canvas requires you to have user authentication in place prior to installation. You may run the `make:auth` Artisan command to satisfy this requirement.

You may use composer to install Canvas into your Laravel project:

```bash
composer require cnvs/canvas
```

Publish the assets and primary configuration file using the `canvas:install` Artisan command:

```bash
php artisan canvas:install
```

Create a symbolic link to ensure file uploads are publicly accessible from the web using the `storage:link` Artisan command:

```bash
php artisan storage:link
```

If you choose to design your own theme instead of the default, you can publish the views with:

```bash
php artisan vendor:publish --provider="Canvas\CanvasServiceProvider" --tag="canvas-views"
```

If you publish your own views, review the API specifications below to see available data for the public-facing endpoints:

<details>
<summary><b>API Specifications</b></summary>
<ul>
<li><code>GET /blog</code> Returns a simple-paginated index of posts</li>

```php
"data": [
	"posts": "Illuminate\Pagination\Paginator"
]
```

<li><code>GET /blog/{slug}</code> Returns a single blog post</li>

```php
"data": [
	"author": "App\User",
	"post": "App\Canvas\Post",
	"meta": {
		"og_title": "string"
		"twitter_title": "string"
		"og_description": "string"
		"meta_description": "string"
		"twitter_description": "string"
	},
	"next": "App\Canvas\Post",
	"random": "App\Canvas\Post"
]
```

<li><code>GET /blog/tag/{slug}</code> Returns a simple-paginated index of posts for a single tag</li>

```php
"data": [
	"topic": "Canvas/Tag",
	"posts": "Illuminate\Pagination\Paginator"
]
```
</ul>
</details>

If you want to use Unsplash images in your posts, you'll need to set up a new application at [https://unsplash.com/oauth/applications](https://unsplash.com/oauth/applications). Grab your access key and update `config/canvas.php`:

```php
'unsplash' => [
    'access_key' => env('CANVAS_UNSPLASH_ACCESS_KEY'),
],
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