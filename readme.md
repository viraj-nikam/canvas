## Canvas

[![Build Status](https://travis-ci.org/austintoddj/Canvas.svg?branch=master)](https://travis-ci.org/austintoddj/Canvas)
[![Total Downloads](https://poser.pugx.org/austintoddj/canvas/downloads)](https://packagist.org/packages/austintoddj/canvas)
[![Latest Stable Version](https://poser.pugx.org/austintoddj/canvas/v/stable)](https://packagist.org/packages/austintoddj/canvas)  [![Latest Unstable Version](https://poser.pugx.org/austintoddj/canvas/v/unstable)](https://packagist.org/packages/austintoddj/canvas) [![GitHub stars](https://img.shields.io/github/stars/austintoddj/Canvas.svg)](https://github.com/austintoddj/Canvas/stargazers) [![License](https://poser.pugx.org/austintoddj/canvas/license)](https://packagist.org/packages/austintoddj/canvas)

Canvas is a minimalistic blogging application for developers. Canvas attempts to make blogging simple and enjoyable by utilizing the latest technologies and keeping the administration as simple as possible with the primary focus on writing.

![Canvas](https://raw.githubusercontent.com/austintoddj/Canvas/master/public/images/canvas-readme.png)

#### Features

*Markdown* - All blog content is stored as markdown so it's portable and easy to move in and out.

*Scheduled Posts* - Write posts and schedule the time and date you want them to appear.

*Tagging* - Canvas allows you to tag posts for categorization and for grouping.

*Uploading* - File management and configuration come fully functional straight out of the box. Create folders and upload files or images.

*Theming* - Canvas utilizes custom LESS files so you can modify the theme to your own taste and preference.

*Simple Configuration* - A single configuration file holds all of the necessary variables to set in order to get you up and running in no time.

#### Requirements

Canvas has a few system requirements:

- PHP >= 5.5.9
- MCrypt PHP Extension
- PDO compliant database (SQL, MySQL, PostgreSQL, SQLite)

#### Installing Canvas

Getting a new instance of Canvas up and running is simple. You can choose either of the following options:

Option 1 - Use Composer:

```sh
composer create-project austintoddj/canvas
```

Option 2 - Download the repository:

```sh
git clone https://github.com/austintoddj/Canvas.git
```

If you chose Option 1, skip this step. If you chose Option 2, run `composer` in the project root:

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

#### Credentials

Open up `Canvas/config/blog.php` and define a few configurations for your new blog.

> The 'title' of your blog is used as the domain to create the default user.

|Data Key|Value|
|---|---|
|Login Email|`admin@canvas.com`(default)|
|Login Password|`password`(default)|

To change your password (Recommended), open up `Canvas/database/seeds/UsersTableSeeder.php` and update it. *Make sure to re-run migrations and seeds if you have already run them.*

Run the database migrations and seed the tables with demo content and a default user:

```sh
php artisan migrate --seed
```

#### Theming Canvas

Adding and modifying styles with Canvas is a breeze. None of this needs to be done out of the box, it simply works on its own. But if you're feeling a little creative and want to make it stand out more, follow these next steps.

Install the `node_modules` directory:

```sh
sudo npm install
```

Install Gulp globally:

```sh
sudo npm install --global gulp-cli
```

After you make any modifications to the files in `Canvas/resources/assets/less`, run gulp:

```sh
gulp
```

#### Disqus Comments

To enable Disqus comments on your blog, you need to have a unique shortname. For more information, check out the [Official Documentation](https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-).

Once you have registered your site and have a shortname, replace `YOUR_UNIQUE_SHORTNAME` in `Canvas/resources/views/blog/partials/disqus.blade.php` with yours.

#### License

Canvas is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
