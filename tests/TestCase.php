<?php

namespace Canvas\Tests;

use Canvas\CanvasServiceProvider;
use Canvas\Models\User;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse as LegacyTestResponse;
use Illuminate\Testing\TestResponse;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use PHPUnit\Framework\Assert as PHPUnit;
use ReflectionClass;
use ReflectionException;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * A contributor-level user for testing.
     *
     * @var User
     */
    protected $contributor;

    /**
     * An editor-level user for testing.
     *
     * @var User
     */
    protected $editor;

    /**
     * An admin-level user for testing.
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

    /**
     * Register an exact JSON fragment assertion.
     *
     * @return void
     */
    protected function registerAssertJsonExactFragmentMacro()
    {
        $assertion = function ($expected, $key) {
            $jsonResponse = $this->json();

            PHPUnit::assertEquals(
                $expected,
                $actualValue = data_get($jsonResponse, $key),
                "Failed asserting that [$actualValue] matches expected [$expected].".PHP_EOL.PHP_EOL.
                json_encode($jsonResponse)
            );

            return $this;
        };

        if ($this->app->version() === '7.x-dev' || version_compare($this->app->version(), '7.0', '>=')) {
            TestResponse::macro('assertJsonExactFragment', $assertion);
        } else {
            LegacyTestResponse::macro('assertJsonExactFragment', $assertion);
        }
    }
}
