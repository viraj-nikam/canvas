# Contributing Guide

Hi! I'm really excited that you are interested in contributing to Canvas. The following guide will help you get your environment set up to begin making changes.

## Table of Contents

- [Contributing Guide](#contributing-guide)
  - [Table of Contents](#table-of-contents)
  - [Before you get started](#before-you-get-started)
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

### Git

Fork the project on [https://github.com/cnvs/canvas](https://github.com/cnvs/canvas) to your own account. Then clone the fork with the following command:

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
composer require laravel/ui

php artisan ui vue --auth
php artisan migrate
```

### Directories

From your Laravel app, link the local version of Canvas using the `composer-link()` function:

```bash
composer-link ../canvas/
composer require cnvs/canvas @dev
```

### Installation

Now that the projects are linked, run the following installation steps:

```bash
php artisan canvas:install
php artisan storage:link
php artisan canvas:setup
```


If you want test data from the application, use the `--data` option:
```bash
php artisan canvas:install
php artisan storage:link
php artisan canvas:setup --data
```



### Developing

Instead of making and compiling frontend changes in the package, then having to re-publish the assets in the Laravel app again and again, we can utilize a symlink: 

```bash
# remove the existing assets from the Laravel app
rm -rf public/vendor/canvas/*

# go inside the empty directory and create a symlink
cd public/vendor/canvas
ln -s ../../../../canvas/public/* .
```

Once you've made your changes, [create a pull request](https://github.com/cnvs/canvas/compare) from your fork to the `develop` branch of the project repository.
