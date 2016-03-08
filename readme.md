# Canvas

Canvas is a minimalistic blogging application for developers. Canvas attempts to make blogging simple and enjoyable by utilizing the latest technologies and keeping the administration as simple as possible with the primary focus on writing.

![Canvas](https://raw.githubusercontent.com/austintoddj/Canvas/master/public/images/canvas-readme.jpg)

## Features

*Markdown* - All content is stored as markdown so it's portable and easy to move in and out.

*Scheduled Posts* - Write posts and schedule the time and date you want them to appear.

*Tagging* - Canvas allows you to tag posts for categorization and for grouping.

*Uploading* -File management and configuration come full functional straight out of the box. Create folders and upload files or images.

*Theming* - Canvas utilizes custom LESS files so you can modify the theme to your own taste and preference.

*Simple Configuration* - A single configuration file holds all of the necessary global variables to set in order to get you up and running in no time.

## Requirements

Canvas has a few system requirements:

- PHP >= 5.6.18
- MCrypt PHP Extension
- PDO compliant database (SQL, MySQL, PostgreSQL, SQLite)

## Installing Canvas

Getting a new instance of Canvas up and running is simple. Just follow these few steps.

Download the repository:

```sh
git clone https://github.com/austintoddj/Canvas.git
```

Once the project has downloaded, run composer:

```sh
composer install
```

Make sure to modify the permissions of the storage directory:

```sh
sudo chmod o+w -R storage
```

To enable uploads on the site, change the ownership of the uploads directory:

```sh
sudo chown -R www-data:www-data public/uploads
```

## Configuring Canvas

You will need to create a new environment file and fill in the necessary credentials:

```sh
cat .env.example > .env; vim .env;
```

Generate a new key for your application:

```sh
php artisan key:generate
```

Run the database migrations and seed the tables with demo content:

```sh
php artisan migrate --seed
```

### Credentials

|Data Key|Value|
|---|---|
|Login Email|`admin@gmail.com`|
|Login Password|`password`|

To update these credentials, you need to modify the file at `Canvas/database/seeds/UsersTableSeeder.php`. Then re-run the migrations:

```sh
php artisan migrate:refresh --seed
```

Finally, you need to modify the file at `Canvas/config/blog.php` with your own site information.

## Theming Canvas

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

## Disqus Comments

To enable Disqus comments on your blog, you need to have a unique shortname. For more information, check out the [Official Documentation](https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-).

Once you have registered your site and have a shortname, replace `YOUR_UNIQUE_SHORTNAME` in `Canvas/resources/views/blog/partials/disqus.blade.php` with yours.
