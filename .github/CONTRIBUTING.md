# Contributing Guide

Hi! I'm really excited that you are interested in contributing to Canvas. The following guide will help you get
 your environment set up to begin making changes.

## Table of Contents

- [OS Tools](#before-you-get-started)
- [Development Setup](#development-setup)
	- [Git](#git)
	- [Database](#database)
	- [Authentication](#authentication)
	- [Directories](#directories)
	- [Installation](#installation)
	- [Developing](#developing)

## Before you get started

- Make sure the [Vue DevTools](https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=en) extension is installed in your Chrome browser
- Add the following function from [Caleb Porzio](https://calebporzio.com/bash-alias-composer-link-use-local-folders-as-composer-dependancies/) to your `~/.bashrc`, `~/.bash_profile` or `~/.zshrc`:

```bash
composer-link() {composer config repositories.local '{"type": "path", "url": "'$1'"}' --file composer.json}
```

## Development Setup

You can open a completely prebuilt, ready-to-code development environment using Gitpod.

[![Open in Gitpod](https://gitpod.io/button/open-in-gitpod.svg)](https://gitpod.io/#https://github.com/austintoddj/canvas/tree/develop)

Alternatively, see instructions below to manually setting up an environment on your own machine.

### Git

Fork the project on [https://github.com/austintoddj/canvas](https://github.com/austintoddj/canvas) to your own account. Then clone
 the fork with the following command:

```bash
git clone https://github.com/your-account/canvas.git
```

In an adjacent directory from where you cloned the repo, create a new Laravel project with the following command:

```bash
composer create-project --prefer-dist laravel/laravel blog
```

### Database

The fastest way to get a database up and running is to issue the following command:

```bash
touch database/database.sqlite
```

Now update your `.env` file to reflect the new database:

```php
DB_CONNECTION=sqlite
```

### Authentication

> Note: It's assumed we're developing on Laravel 6.* since that's the current LTS

From your Laravel app, create the authentication system and run the following commands:

```bash
# Require the Laravel UI package
composer require laravel/ui

# Scaffold the frontend
php artisan ui vue --auth

# Install dependencies and compile assets
npm install
npm run dev

# Run the migrations
php artisan migrate
```

### Directories

From your Laravel app, link the local version of Canvas using the `composer-link()` function:

```bash
composer-link ../canvas/
composer require austintoddj/canvas @dev
```

### Installation

Now that the projects are linked, run the following installation steps:

```bash
# Install the Canvas package
php artisan canvas:install

# Link the storage directory
php artisan storage:link
```

Statistics are a core component to the app, so it's best to have a large dataset in place when developing. To
 generate some, add the following snippets to your Laravel app:

Create a new class named `CanvasTrackingDataSeeder` and add this to the `run()` method:

```php
\Illuminate\Support\Facades\DB::table('canvas_views')->truncate();
\Illuminate\Support\Facades\DB::table('canvas_visits')->truncate();

factory(\Canvas\Models\View::class, 2500)->create();
factory(\Canvas\Models\Visit::class, 2500)->create();
```

In the `run()` method of the `DatabaseSeeder`:

```php
$this->call(CanvasTrackingDataSeeder::class);
```

Create a new factory named `ViewFactory` and add this definition:

```php
$factory->define(\Canvas\Models\View::class, function (\Faker\Generator $faker) {
    $timestamp = today()->subDays(rand(0, 60))->toDateTimeString();

    return [
        'post_id'    => \Canvas\Models\Post::all()->pluck('id')->random(),
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'referer' => $faker->url,
        'created_at' => $timestamp,
        'updated_at' => $timestamp,
    ];
});
```

Create a new factory named `VisitFactory` and add this definition:

```php
$factory->define(\Canvas\Models\Visit::class, function (\Faker\Generator $faker) {
    $timestamp = today()->subDays(rand(0, 60))->toDateTimeString();

    return [
        'post_id' => \Canvas\Models\Post::all()->pluck('id')->random(),
        'ip' => $faker->ipv4,
        'agent' => $faker->userAgent,
        'referer' => $faker->url,
        'created_at' => $timestamp,
        'updated_at' => $timestamp,
    ];
});
```

You can now run `php artisan db:seed` and you will have a substantial amount of views for each post.

### Developing

Instead of making and compiling frontend changes in the package, then having to re-publish the assets in the
 Laravel app again and again, we can utilize a symlink: 

```bash
# remove the existing assets from the Laravel app
rm -rf public/vendor/canvas/*

# go inside the empty directory and create a symlink
cd public/vendor/canvas
ln -s ../../../../canvas/public/* .
```

Once you've made your changes, [create a pull request](https://github.com/austintoddj/canvas/compare) from your fork to
 the `develop` branch of the project repository.
