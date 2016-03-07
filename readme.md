# Canvas

Canvas is a minimalistic blogging application for developers. Canvas attempts to make blogging simple and enjoyable by utilizing the latest technologies and keeping the administration as simple as possible with the primary focus on writing.

## Requirements

Wardrobe has a few system requirements:

- PHP >= 5.3.7
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
php artisan migrate:refresh --seed
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

By default, your theme files are located in `public/themes`.
You can modify these themes or create your own using the default themes as a guide.
The configuration for your themes is located in `app/config/packages/wardrobe/core/wardrobe.php` in the `theme` option.

## Disqus Comments

To enable Disqus comments on your blog, you need to have a unique shortname. For more information, check out the [Official Documentation](https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-).

Once you have registered your site and have a shortname, replace `YOUR_UNIQUE_SHORTNAME` in `Canvas/resources/views/blog/partials/disqus.blade.php` with yours.