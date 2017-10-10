<?php

namespace Tests;

use Canvas\Models\User;
use App\Exceptions\Handler;
use Exception;
use Faker\Generator;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Foundation\Application;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        $this->app->singleton(EloquentFactory::class, function () {
            return EloquentFactory::construct(app(Generator::class), base_path().'/vendor/cnvs/easel/database/factories');
        });

    }
}