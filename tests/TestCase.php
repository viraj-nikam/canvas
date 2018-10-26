<?php

namespace Canvas\Tests;

use Dotenv\Dotenv;
use Canvas\Tests\Unit\User;
use Canvas\CanvasServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @var User
     */
    protected $testUser;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->testUser = User::first();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CanvasServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // If we're not in TravisCI, load our local .env file
        if (empty(getenv('CI'))) {
            $envPath = realpath(__DIR__.'/..');
            if (! file_exists($envPath)) {
                $dotenv = new Dotenv($envPath);
                $dotenv->load();
            }
        }

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('view.paths', [__DIR__.'/resources/views']);

        // Use test User model for users provider
        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function setUpDatabase($app)
    {
        $this->artisan('migrate:fresh');
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
        });

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->createTestUser();
    }

    /**
     * @return User
     */
    protected function createTestUser(): User
    {
        return User::create([
            'email' => 'test@user.com',
        ]);
    }
}
