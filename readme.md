## Canvas

[![Build Status](https://travis-ci.org/austintoddj/Canvas.svg?branch=master)](https://travis-ci.org/austintoddj/Canvas) [![GitHub issues](https://img.shields.io/github/issues/austintoddj/Canvas.svg)](https://github.com/austintoddj/Canvas/issues) [![Total Downloads](https://poser.pugx.org/austintoddj/canvas/downloads)](https://packagist.org/packages/austintoddj/canvas) [![GitHub stars](https://img.shields.io/github/stars/austintoddj/Canvas.svg)](https://github.com/austintoddj/Canvas/stargazers) [![Latest Stable Version](https://poser.pugx.org/austintoddj/canvas/v/stable)](https://packagist.org/packages/austintoddj/canvas) [![License](https://poser.pugx.org/austintoddj/canvas/license)](https://packagist.org/packages/austintoddj/canvas)

Canvas is a minimal blogging application for developers. It attempts to make blogging simple and enjoyable by utilizing the latest technologies and keeping the administration as simple as possible with the primary focus on writing.

#### Requirements

Canvas has a few system requirements:

- PHP >= 5.5.9
- MCrypt PHP Extension
- PDO compliant database (SQL, MySQL, PostgreSQL, SQLite)

#### Installation

Getting Canvas up and running is simple. You can choose either of the following installation options:

Option 1 - Use Composer:

```sh
composer create-project austintoddj/canvas
```

Option 2 - Download the repository:

```sh
git clone https://github.com/austintoddj/canvas.git
```

If you chose Option 1, skip this step. If you chose Option 2, run the following command from the project root:

```sh
composer install
```

Make sure to modify the permissions of the storage directory:

```sh
sudo chmod o+w -R storage
```

To enable uploads on the site, give ownership of the uploads directory to the web server:

```sh
sudo chown -R www-data:www-data public/uploads
```

#### Configuring Canvas

You will need to create a new `.env` file and fill in the necessary variables:

```sh
cat .env.example > .env; vim .env;
```

Generate a key for your application:

```sh
php artisan key:generate
```

#### Settings

Open up `Canvas/config/blog.php` and define the few configurations options for your blog.

>Note:  The 'title' of your blog is used as the domain to create the default user email.

|Data Key|Value|
|---|---|
|Login Email|`admin@canvas.com`(default)|
|Login Password|`password`(default)|

When you first set up Canvas, you may want to change the default user information right away. To update user information including setting a new password (Recommended), edit the file `Canvas/database/seeds/UsersTableSeeder.php` and save it. *Make sure to re-run migrations and seeds if you have already run them.*

Run the database migrations:

```sh
php artisan migrate --seed
```

#### Theming Canvas

Adding or modifying styles with Canvas is a breeze. None of this needs to be done out of the box, it simply works on its own. But if you're feeling a little creative and want to make it stand out more, follow these steps:

Install the project dependencies via `npm`:

```sh
sudo npm install
```

Install Gulp globally:

```sh
sudo npm install --global gulp-cli
```

After you make any modifications to the files in `Canvas/resources/assets/less/`, run gulp:

```sh
gulp
```

#### Disqus Comments

To enable Disqus comments on your blog, you need to have a unique shortname. For more information, check out the [Official Documentation](https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-).

Once you have registered your site and have a shortname, replace `YOUR_UNIQUE_SHORTNAME` in `Canvas/resources/views/frontend/blog/partials/disqus.blade.php` with yours.

#### Changelog

Detailed changes for each release are documented in the [release notes](https://github.com/austintoddj/Canvas/releases).

#### License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
