<a href="http://canvas.toddaustin.io"><img src="https://github.com/austintoddj/canvas/blob/master/public/assets/images/gh-readme.jpg?raw=true"></a>

<p align="center">
    <a href="https://travis-ci.org/austintoddj/canvas"><img src="https://travis-ci.org/austintoddj/canvas.svg?branch=master" alt="Build Status"></a>
    <a href="https://styleci.io/repos/52815899"><img src="https://styleci.io/repos/52815899/shield?style=flat&branch=master" alt="StyleCI"></a>
    <a href='https://www.versioneye.com/user/projects/583f066ec68b12000e89433a'><img src='https://www.versioneye.com/user/projects/583f066ec68b12000e89433a/badge.svg?style=flat' alt="Dependency Status" /></a>
    <a href="https://packagist.org/packages/austintoddj/canvas"><img src="https://poser.pugx.org/austintoddj/canvas/downloads" alt="Total Downloads"></a> 
    <a href="https://packagist.org/packages/cnvs/canvas"><img src="https://poser.pugx.org/cnvs/canvas/v/stable" alt="Latest Stable Version"></a>
    <a href="https://github.com/cnvs/canvas/blob/master/LICENSE"><img src="https://poser.pugx.org/cnvs/canvas/license" alt="License"></a>
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

**Congratulations!** Your new blog is set up and ready to go. Feeling adventurous? Check out some [advanced options](https://cnvs.readme.io/docs/advanced-options) to get even more out of Canvas.

## Contributing

Thank you for considering contributing to Canvas! The contribution guide can be found in the [Canvas documentation](https://cnvs.readme.io/docs/contributing).

## Changelog

Detailed changes for each release are documented in the [release notes](https://github.com/cnvs/canvas/releases).

## License

Canvas is open-sourced software licensed under the [MIT license](https://github.com/cnvs/canvas/blob/master/LICENSE).
