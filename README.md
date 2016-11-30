<a href="http://canvas.toddaustin.io"><img src="https://github.com/austintoddj/canvas/blob/master/public/assets/images/gh-readme.jpg?raw=true"></a>

<p align="center">
    <a href="https://travis-ci.org/austintoddj/canvas"><img src="https://travis-ci.org/austintoddj/canvas.svg?branch=master" alt="Build Status"></a>
    <a href="https://styleci.io/repos/52815899"><img src="https://styleci.io/repos/52815899/shield?style=flat&branch=master" alt="StyleCI"></a>
    <a href="https://www.versioneye.com/user/projects/57dff0d579806f0043346a68"><img src="https://www.versioneye.com/user/projects/57dff0d579806f0043346a68/badge.svg?style=flat" alt="Dependency Status"></a>
    <a href="https://packagist.org/packages/austintoddj/canvas"><img src="https://poser.pugx.org/austintoddj/canvas/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/austintoddj/canvas"><img src="https://poser.pugx.org/austintoddj/canvas/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/austintoddj/canvas"><img src="https://poser.pugx.org/austintoddj/canvas/license" alt="License"></a>
</p>

## About Canvas

[Canvas](http://canvas.toddaustin.io) is a simple, powerful blog publishing platform that lets you to share your stories with the world. Its beautifully designed interface and completely customizable framework allows you to create and publish your own blog, giving you tools that make it easy and even fun to do. Canvas includes some of the most popular web packages today, such as:

* [Google Material Design](https://material.google.com).
* [SimpleMDE](https://simplemde.com) for markdown publishing.
* Syntax highlighting by [PrismJS](http://prismjs.com).
* Full-site searching by [TNTSearch](https://github.com/teamtnt/laravel-scout-tntsearch-driver).
* Native [Google Analytics](https://www.google.com/analytics/#?modal_active=none) integration.
* Powered by [Laravel 5](https://laravel.com).

## Requirements

Before you proceed make sure your server meets the following requirements:

- [Composer](https://getcomposer.org/)
- [PHP](https://php.net/) >= 5.6.4
- JavaScript package manager ([Yarn](https://yarnpkg.com/) / [NPM](https://www.npmjs.com))
- PHP extensions ([PDO](http://php.net/manual/en/book.pdo.php), [SQLite](http://php.net/manual/en/book.sqlite.php), [OpenSSL](http://php.net/manual/en/book.openssl.php), [Mbstring](http://php.net/manual/en/book.mbstring.php), [Tokenizer](http://php.net/manual/en/book.tokenizer.php), [Zip](http://php.net/manual/en/book.zip.php))
- PDO compliant database ([SQL](https://www.microsoft.com/en-us/sql-server/) / [MySQL](https://www.mysql.com) / [PostgreSQL](https://www.postgresql.org) / [SQLite](https://www.sqlite.org))

## Installation

1. There are 3 ways of downloading the application:
    * Use [GitHub](https://github.com): simply click the `Clone or download` button at the top right of this page and choose `Download ZIP`
    * Use [Git](https://git-scm.com): `git clone https://github.com/cnvs/canvas.git`
    * Use [Packagist](https://packagist.org): `composer create-project cnvs/canvas`

2. Run `composer install` from the command line in the project root.
3. Run `yarn` from the command line in the project root.
4. Run `php artisan storage:link` to link the `storage/app/public` folder to `public/storage`
5. Copy the contents of `.env.example` and create a new file called `.env` in the project root. Set your application variables in the new file. Be sure to keep the value of `APP_ENV` set to `local` for the duration of the install.
6. Run `php artisan canvas:install` and follow the on-screen prompts.
7. Run `chmod -R 777 storage/` to change the permissions of the `storage/` directory.

**Congratulations!** Your new blog is set up and ready to go. Feeling adventurous? Continue on with the advanced options below to get even more out of Canvas.

## Advanced Options

1. Themes
    * Create your own theme by editing the stylesheet at `resources/assets/sass/theme/styles.scss` or grab an [Official Canvas Theme](https://github.com/cnvs/palette), fresh off the palette.
    * Run `gulp` after any changes to `resources/assets/sass/theme/styles.scss`

2. Google Analytics
    * Set up a web property on [Google Analytics](https://www.google.com/analytics/#?modal_active=none).
    * Enter your tracking ID on the `Settings` page.

3. Disqus Integration
    * Generate a unique shortname from [Disqus](https://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-).
    * Enter your shortname on the `Settings` page.

4. Email Notifications
    * To enable the **Forgot My Password** feature on the login page, make sure you set the appropriate mail driver variables in your `.env` file.

## Contributing

Thank you for considering contributing to Canvas! The [contribution guide](https://github.com/cnvs/canvas/blob/master/CONTRIBUTING.md) provides instructions on how to [submit an issue](https://github.com/cnvs/canvas/issues), [create pull requests](https://github.com/cnvs/canvas/pulls) and more. It also has details about joining the official [HipChat group](https://canvas-chat.hipchat.com) for those who want to be a part of Canvas' future development.

## Changelog

Detailed changes for each release are documented in the [release notes](https://github.com/cnvs/canvas/releases).

## License

Canvas is open-sourced software licensed under the [MIT license](https://github.com/cnvs/canvas/blob/master/LICENSE).
