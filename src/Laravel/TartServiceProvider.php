<?php

namespace IGC\Tart\Laravel;

use Illuminate\Support\ServiceProvider;

class TartServiceProvider extends ServiceProvider
{
    protected const CONFIG_PATH = __DIR__ . '/../../config/tart.php';

    /**
     * Register bindings.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'tart');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            self::CONFIG_PATH => $this->configPath(),
        ], 'tart-config');

        $this->commands([
            Commands\TartDemoCommand::class,
            Commands\TartDemoFullCommand::class,
            Commands\TartFluentDemoCommand::class,
            Commands\TartTestCommand::class,
            Commands\TartNewFeaturesDemo::class,
        ]);
    }

    protected function configPath(): string
    {
        if (function_exists('config_path')) {
            return config_path('tart.php');
        }

        return $this->app->basePath('config/tart.php');
    }
}
