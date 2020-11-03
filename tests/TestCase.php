<?php

namespace Canvas\Tests;

use Canvas\CanvasServiceProvider;
use Canvas\Models\User;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ReflectionClass;
use ReflectionException;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * A test user with the role of Contributor.
     *
     * @var User
     */
    protected $contributor;

    /**
     * A test user with the role of Editor.
     *
     * @var User
     */
    protected $editor;

    /**
     * A test user with the role of Admin.
     *
     * @var User
     */
    protected $admin;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->createTestUsers();
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            CanvasServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     * @return void
     */
    protected function resolveApplicationCore($app): void
    {
        parent::resolveApplicationCore($app);

        $app->detectEnvironment(function () {
            return 'testing';
        });
    }

    /**
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $config = $app->get('config');

        $config->set('view.paths', [dirname(__DIR__).'/resources/views']);

        $config->set('database.default', 'sqlite');

        $config->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $config->set('auth.providers.canvas_users', [
            'driver' => 'eloquent',
            'model' => User::class,
        ]);

        $config->set('auth.guards.canvas', [
            'driver' => 'session',
            'provider' => 'canvas_users',
        ]);
    }

    /**
     * @param Application $app
     * @return void
     * @throws Exception
     */
    protected function setUpDatabase($app): void
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadFactoriesUsing($app, __DIR__.'/../database/factories');

        $this->artisan('migrate');
    }

    /**
     * Create role-based users for testing.
     *
     * @void
     */
    protected function createTestUsers(): void
    {
        $this->contributor = factory(User::class)->create([
            'role' => User::CONTRIBUTOR,
        ]);

        $this->editor = factory(User::class)->create([
            'role' => User::EDITOR,
        ]);

        $this->admin = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);
    }

    /**
     * Call the protected or private methods of a class.
     *
     * @param $object
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    protected function invokeMethod(&$object, string $method, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
