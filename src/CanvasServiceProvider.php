<?php

namespace Canvas;

use Illuminate\Support\ServiceProvider;

class CanvasServiceProvider extends ServiceProvider
{
    use ServiceBindings;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerResources();
        $this->defineAssetPublishing();
        $this->loadMigrations();
        $this->loadTranslations();
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'canvas');
    }

    /**
     * Load the migrations.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Load the translation files.
     *
     * @return void
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'canvas');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            CANVAS_PATH.'/public' => public_path('vendor/canvas'),
        ], 'canvas-assets');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('CANVAS_PATH')) {
            define('CANVAS_PATH', realpath(__DIR__.'/../'));
        }

        $this->configure();
        $this->offerPublishing();
        $this->registerServices();
        $this->registerCommands();
    }

    /**
     * Setup the configuration.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/canvas.php', 'canvas'
        );
    }

    /**
     * Setup the resource publishing groups.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/canvas.php' => config_path('canvas.php'),
            ], 'canvas-config');
        }
    }

    /**
     * Register services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach ($this->serviceBindings as $key => $value) {
            is_numeric($key)
                ? $this->app->singleton($value)
                : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register the Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}
